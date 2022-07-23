<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Reader\Yaml;

use Illuminate\Filesystem\Filesystem;
use LogicException;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Yaml\Yaml;

class YamlFileOperation
{
    /**
     * Read yaml files.
     *
     * @param  string  $directoryPath
     * @param  string  $findFileName
     * @return mixed[]
     */
    public function readByFileName(string $directoryPath, string $findFileName): array
    {
        $yamlFiles = $this->readByDirectoryPath($directoryPath);

        foreach ($yamlFiles as $fileName => $yamlFile) {
            if (basename($fileName, '.yml') === $findFileName) {
                return $yamlFile;
            }
        }

        return [];
    }

    /**
     * Read yaml files.
     *
     * @param  string  $directoryPath
     * @param  string[]  $exceptFileNames
     * @return mixed[][]
     */
    public function readByDirectoryPath(string $directoryPath, array $exceptFileNames = []): array
    {
        if (! $this->isDirectory($directoryPath)) {
            throw new LogicException($directoryPath.': read path must be a directory');
        }

        $filePaths = $this->getAllFilePath($directoryPath);
        $yamlFiles = $this->parseAllYaml($filePaths);

        // Exclude from creation
        if (! empty($exceptFileNames) && ! empty($yamlFiles)) {
            $yamlFiles = collect($yamlFiles)->filter(function ($value, $key) use ($exceptFileNames) {
                return ! in_array(basename($key, '.yml'), $exceptFileNames, false);
            })->all();
        }

        return $yamlFiles;
    }

    /**
     * Determine if the given path is a directory.
     *
     * @param  string  $directory
     * @return bool
     * @see \Illuminate\Filesystem\Filesystem::isDirectory
     */
    public function isDirectory(string $directory): bool
    {
        return is_dir($directory);
    }

    /**
     * Recursively get a list of file paths from a directory.
     *
     * @param  string  $directoryPath
     * @return string[]
     */
    protected function getAllFilePath(string $directoryPath): array
    {
        $filePaths = [];

        if (! $this->isDirectory($directoryPath)) {
            throw new LogicException('Not a Directory');
        }

        $files = $this->allFiles($directoryPath);
        foreach ($files as $file) {
            $realPath = (string) $file->getRealPath();
            $filePaths[$realPath] = $realPath;
        }

        return $filePaths;
    }

    /**
     * Get all the files from the given directory (recursive).
     *
     * @param  string  $directory
     * @param  bool  $hidden
     * @return \Symfony\Component\Finder\SplFileInfo[]
     * @see \Illuminate\Filesystem\Filesystem::allFiles
     */
    public function allFiles(string $directory, bool $hidden = false): array
    {
        return iterator_to_array(
            Finder::create()->files()->ignoreDotFiles(! $hidden)->in($directory)->sortByName(),
            false
        );
    }

    /**
     * Parse all definition Yaml files.
     *
     * @param  string[]  $filePaths
     * @return mixed[][]
     */
    public function parseAllYaml(array $filePaths): array
    {
        $yamlParseTexts = [];

        foreach ($filePaths as $filePath) {
            $yamlParseTexts[$filePath] = $this->parseYaml($filePath);
        }

        return $yamlParseTexts;
    }

    /**
     * Parse Yaml files.
     *
     * @param  string  $filePath
     * @return mixed[]
     */
    public function parseYaml(string $filePath): array
    {
        $extension = $this->extension($filePath);

        if ($extension !== 'yml') {
            throw new LogicException('Could not parse because it is not Yaml data filePath: '.$filePath);
        }

        $contents = file_get_contents($filePath);
        if (! $contents) {
            throw new LogicException('Failed to get the file :'.$filePath);
        }

        $yaml = Yaml::parse($contents);
        if (! is_array($yaml) || ! $this->isMultidimensional($yaml)) {
            throw new LogicException('Yaml file description is not in array format: '.$filePath);
        }

        if (count($yaml) !== 1) {
            throw new LogicException('Yaml data must be one data per file filePath: '.$filePath);
        }

        // Rule that there is always one data in Yaml data
        return reset($yaml);
    }

    /**
     * Extract the file extension from a file path.
     *
     * @param  string  $path
     * @return string
     * @see \Illuminate\Filesystem\Filesystem::extension
     */
    private function extension(string $path): string
    {
        return pathinfo($path, PATHINFO_EXTENSION);
    }

    /**
     * Whether it is a multidimensional array.
     *
     * @param  mixed[]  $array
     * @return bool
     */
    private function isMultidimensional(array $array): bool
    {
        return count($array) !== count($array, 1);
    }
}
