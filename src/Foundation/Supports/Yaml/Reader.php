<?php

namespace StepUpDream\Blueprint\Foundation\Supports\Yaml;

use Illuminate\Filesystem\Filesystem;
use LogicException;
use Symfony\Component\Yaml\Yaml;

/**
 * Class Reader.
 */
class Reader
{
    /**
     * @var \Symfony\Component\Yaml\Yaml
     */
    protected $yaml;

    /**
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $file;

    /**
     * Reader constructor.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $file
     * @param  \Symfony\Component\Yaml\Yaml  $yaml
     */
    public function __construct(
        Filesystem $file,
        Yaml $yaml
    ) {
        $this->yaml = $yaml;
        $this->file = $file;
    }

    /**
     * Read yaml files.
     *
     * @param  string  $directoryPath
     * @param  array  $exceptFileNames
     * @return array
     */
    public function readFileByDirectoryPath(string $directoryPath, array $exceptFileNames = []): array
    {
        $yamlFiles = $this->readByDirectoryPath($directoryPath);

        // Exclude from creation
        if (! empty($exceptFileNames) && ! empty($yamlFiles)) {
            $yamlFiles = collect($yamlFiles)->filter(function ($value, $key) use ($exceptFileNames) {
                return ! in_array(basename($key, '.yml'), $exceptFileNames, false);
            })->all();
        }

        return $yamlFiles;
    }

    /**
     * Read yaml files.
     *
     * @param  string  $directoryPath
     * @param  string  $findFileName
     * @return array
     */
    public function readFileByFileName(string $directoryPath, string $findFileName): array
    {
        $yamlFiles = $this->readFileByDirectoryPath($directoryPath);

        foreach ($yamlFiles as $fileName => $yamlFile) {
            if (basename($fileName, '.yml') === $findFileName) {
                return $yamlFile;
            }
        }

        return [];
    }

    /**
     * Reading definition data.
     *
     * @param  string  $targetDirectoryPath
     * @return array
     */
    protected function readByDirectoryPath(string $targetDirectoryPath): array
    {
        if (! $this->file->isDirectory($targetDirectoryPath)) {
            throw new LogicException($targetDirectoryPath.': read path must be a directory');
        }

        $filePaths = $this->getAllFilePath($targetDirectoryPath);

        return $this->parseAllYaml($filePaths);
    }

    /**
     * Recursively get a list of file paths from a directory.
     *
     * @param  string  $directoryPath
     * @return array
     */
    protected function getAllFilePath(string $directoryPath): array
    {
        $filePaths = [];

        if (! $this->file->isDirectory($directoryPath)) {
            throw new LogicException('Not a Directory');
        }

        $files = $this->file->allFiles($directoryPath);
        foreach ($files as $file) {
            $realPath = (string) $file->getRealPath();
            $filePaths[$realPath] = $realPath;
        }

        return $filePaths;
    }

    /**
     * Parse all definition Yaml files.
     *
     * @param  array  $filePaths
     * @return mixed
     */
    protected function parseAllYaml(array $filePaths): array
    {
        $yamlParseTexts = [];

        foreach ($filePaths as $filePath) {
            if (count($this->parseYaml($filePath)) >= 2) {
                throw new LogicException('Yaml data must be one data per file filePath: '.$filePath);
            }

            // Rule that there is always one data in Yaml data
            $yamlParseTexts[$filePath] = collect($this->parseYaml($filePath))->first();
        }

        return $yamlParseTexts;
    }

    /**
     * Parse Yaml files.
     *
     * @param  string  $filePath
     * @return mixed
     */
    protected function parseYaml(string $filePath)
    {
        $extension = $this->file->extension($filePath);
        if ($extension !== 'yml') {
            throw new LogicException('Could not parse because it is not Yaml data filePath: '.$filePath);
        }

        return $this->yaml::parse(file_get_contents($filePath));
    }
}
