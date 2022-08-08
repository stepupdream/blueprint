<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Creator;

use InvalidArgumentException;
use StepUpDream\Blueprint\Creator\Foundations\Migration;
use StepUpDream\Blueprint\Creator\Supports\File\ColumnVersionMigration;
use StepUpDream\Blueprint\Creator\Supports\File\ColumnVersionYaml;

class MigrationCreator extends BaseCreator
{
    /**
     * Execution of processing.
     *
     * Output the file according to the read yaml file.
     *
     * @param  \StepUpDream\Blueprint\Creator\Foundations\Migration  $foundation
     * @param  string|null  $version
     */
    public function run(Migration $foundation, ?string $version): void
    {
        $readPath = $foundation->readPath();
        $outputDirectoryPath = $foundation->outputDirectoryPath();
        $yamlFiles = $this->yamlReader->readByDirectoryPath($readPath, $foundation->exceptFileNames());

        foreach ($yamlFiles as $filePath => $yamlFile) {
            $fileName = basename($filePath, '.yml');
            $columnVersionMigration = $this->fileCreator->getColumnVersionByTable($outputDirectoryPath, $fileName);
            $columnVersionYaml = $this->yamlReader->readColumnVersionByFileName($readPath, $fileName, $version);
            $bladeFile = $this->readBlade($foundation, true, $columnVersionYaml, $columnVersionMigration);

            // first time.
            if (! $columnVersionMigration->isExistMigrationFile()) {
                $outputPath = $this->outputPath($foundation, $columnVersionYaml->targetVersion(), $fileName);
                $this->fileCreator->createFile($bladeFile, $outputPath);
                continue;
            }

            if ($columnVersionMigration->maxTargetVersion() > $columnVersionYaml->targetVersion()) {
                throw new InvalidArgumentException(
                    'You cannot specify a value lower than the existing migration file : '.$version
                );
            }

            // If you export again with the same version, place them manually. Print to the tmp location.
            if ($columnVersionMigration->maxTargetVersion() === $columnVersionYaml->targetVersion()) {
                $outputPath = $this->outputPathTmp($foundation, $fileName);
                $this->fileCreator->createFile($bladeFile, $outputPath, true);
                continue;
            }

            // Assuming the table already exists. Modify the contents of the table in the new version.
            $bladeFileUpdate = $this->readBlade($foundation, false, $columnVersionYaml, $columnVersionMigration);
            $outputPath = $this->outputPath($foundation, $columnVersionYaml->targetVersion(), $fileName);
            $this->fileCreator->createFile($bladeFileUpdate, $outputPath);
        }
    }

    /**
     * Get outputPath.
     *
     * @param  \StepUpDream\Blueprint\Creator\Foundations\Migration  $foundation
     * @param  string  $targetVersion
     * @param  string  $fileName
     * @return string
     */
    private function outputPath(Migration $foundation, string $targetVersion, string $fileName): string
    {
        $outputDirectoryPath = $foundation->outputDirectoryPath();
        $connection = $foundation->connection();

        return sprintf('%s/%s/%s/%s.php', $outputDirectoryPath, $targetVersion, $connection, $fileName);
    }

    /**
     * Get outputPathTmp.
     *
     * @param  \StepUpDream\Blueprint\Creator\Foundations\Migration  $foundation
     * @param  string  $fileName
     * @return string
     */
    private function outputPathTmp(Migration $foundation, string $fileName): string
    {
        $outputDirectoryPath = $foundation->outputDirectoryPathTmp();
        $connection = $foundation->connection();

        return sprintf('%s/%s/%s.php', $outputDirectoryPath, $connection, $fileName);
    }

    /**
     * Read blade file for Migration file.
     *
     * @param  \StepUpDream\Blueprint\Creator\Foundations\Migration  $foundation
     * @param  bool  $isNewTable
     * @param  \StepUpDream\Blueprint\Creator\Supports\File\ColumnVersionYaml  $columnVersionYaml
     * @param  \StepUpDream\Blueprint\Creator\Supports\File\ColumnVersionMigration  $columnVersionMigration
     * @return string
     */
    protected function readBlade(
        Migration $foundation,
        bool $isNewTable,
        ColumnVersionYaml $columnVersionYaml,
        ColumnVersionMigration $columnVersionMigration,
    ): string {
        $bladeViewArguments = [];
        $bladeViewArguments['yamlFile'] = $columnVersionYaml->readYamlFile();
        $bladeViewArguments['versionMatchColumns'] = $columnVersionYaml->versionMatchColumnDetail();
        $bladeViewArguments['existColumnNames'] = $columnVersionMigration->existColumnNames();
        $bladeViewArguments['targetVersion'] = $columnVersionYaml->targetVersion();
        $bladeViewArguments['options'] = $foundation->optionsForBlade('', '');

        if ($isNewTable) {
            return view($foundation->templateBladeFile(), $bladeViewArguments)->render();
        }

        return view($foundation->templateUpdateBladeFile(), $bladeViewArguments)->render();
    }
}
