<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Creator\Supports\File;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use LogicException;
use StepUpDream\SpreadSheetConverter\DefinitionDocument\Supports\FileOperation as SpreadSheetConverterFileOperation;

class FileOperation extends SpreadSheetConverterFileOperation
{
    /**
     * Add Tab Space.
     *
     * @param  int  $tabCount
     * @return string
     */
    public function addTabSpace(int $tabCount = 1): string
    {
        $result = '';

        for ($i = 1; $i <= $tabCount; $i++) {
            $result .= '    ';
        }

        return $result;
    }

    /**
     * Get the contents of a file.
     *
     * @param  string  $path
     * @return string
     */
    public function get(string $path): string
    {
        if (is_file($path)) {
            $contents = file_get_contents($path);

            if (! $contents) {
                throw new LogicException('Failed to get the file. : '.$path);
            }

            return $contents;
        }

        throw new FileNotFoundException("File does not exist at path {$path}.");
    }

    /**
     * Get the version for each column.
     *
     * @param  string  $migrationDirectoryPath
     * @param  string  $tableName
     * @return \StepUpDream\Blueprint\Creator\Supports\File\ColumnVersionMigration
     */
    public function getColumnVersionByTable(string $migrationDirectoryPath, string $tableName): ColumnVersionMigration
    {
        $columnVersionMigration = new ColumnVersionMigration();
        if (! is_dir($migrationDirectoryPath)) {
            return $columnVersionMigration;
        }

        $files = $this->allFiles($migrationDirectoryPath);
        foreach ($files as $file) {
            if ($file->getFilenameWithoutExtension() !== $tableName) {
                continue;
            }

            $directoryPathSplit = explode('/', dirname($file->getRealPath()));
            $versionName = $this->pop($directoryPathSplit, 2);
            if ($versionName === 'tmp') {
                continue;
            }

            $columnVersions = $this->getColumnVersion($file->getRealPath(), $versionName);
            if (! empty($columnVersions)) {
                $columnVersionMigration->addColumnVersions($columnVersions);
            }
        }

        return $columnVersionMigration;
    }

    /**
     * Get the specified element from the back.
     *
     * @param  string[]  $directoryPathSplit
     * @param  int  $arrayNumber
     * @return string
     */
    public function pop(array $directoryPathSplit, int $arrayNumber): string
    {
        $results = [];
        for ($i = 1; $i <= $arrayNumber; $i++) {
            $results[$i] = array_pop($directoryPathSplit);
        }

        if (empty($results[$arrayNumber])) {
            throw new LogicException('Incorrect migration version folder arrangement structure.');
        }

        return $results[$arrayNumber];
    }

    /**
     * Get the last updated version of the corresponding column.
     *
     * @param  string  $filePath
     * @param  string  $version
     * @return string[]
     */
    private function getColumnVersion(string $filePath, string $version): array
    {
        // ver9.x support
        $migrationKeys = [
            'year', 'uuidMorphs', 'uuid', 'unsignedTinyInteger', 'unsignedSmallInteger', 'unsignedMediumInteger',
            'unsignedInteger', 'unsignedDecimal', 'unsignedBigInteger', 'tinyText', 'tinyInteger', 'tinyIncrements',
            'timeTz', 'timestampTz', 'timestamp', 'time', 'text', 'string', 'smallInteger', 'smallIncrements', 'set',
            'polygon', 'point', 'nullableUuidMorphs', 'nullableMorphs', 'multiPolygon', 'multiPoint', 'multiLineString',
            'morphs', 'mediumText', 'mediumInteger', 'mediumIncrements', 'macAddress', 'longText', 'lineString',
            'jsonb', 'json', 'ipAddress', 'integer', 'increments', 'geometryCollection', 'geometry', 'foreignUuid',
            'foreignId', 'float', 'enum', 'double', 'decimal', 'dateTimeTz', 'dateTime', 'date', 'char', 'boolean',
            'binary', 'bigInteger', 'bigIncrements',
        ];

        $columnNames = [];
        $content = file_get_contents($filePath);
        if (empty($content)) {
            throw new LogicException($filePath.' : Failed to load content.');
        }

        $rows = explode("\n", $content);
        foreach ($rows as $row) {
            foreach ($migrationKeys as $migrationKey) {
                preg_match('/(->'.$migrationKey."\(')(.*?)(')/s", $row, $return);
                if (! empty($return)) {
                    $columnNames[$return[2]] = $version;
                    break;
                }

                preg_match('/(->renameColumn\()(.*?)(\))/s', $row, $return);
                preg_match('/->renameColumn/', $row, $return);
                if (! empty($return)) {
                    $returnByExplode = explode(',', $return);
                    $columnNames[trim(array_pop($returnByExplode))] = $version;
                }
            }
        }

        return $columnNames;
    }
}
