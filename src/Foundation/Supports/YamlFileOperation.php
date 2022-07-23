<?php

namespace StepUpDream\Blueprint\Foundation\Supports;

use File;
use Illuminate\Filesystem\Filesystem;
use LogicException;
use Symfony\Component\Yaml\Yaml;

/**
 * Class YamlFileOperation
 *
 * @package StepUpDream\Blueprint\Foundation\Supports
 */
class YamlFileOperation
{
    /**
     * @var \Symfony\Component\Yaml\Yaml
     */
    protected Yaml $yaml;
    
    /**
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected Filesystem $file;
    
    /**
     * YamlFileOperation constructor.
     */
    public function __construct(
        Filesystem $file,
        Yaml $yaml
    ) {
        $this->yaml = $yaml;
        $this->file = $file;
    }
    
    /**
     * Reading definition data
     *
     * @param  string  $targetDirectoryPath
     * @return array
     */
    public function readByDirectoryPath(string $targetDirectoryPath): array
    {
        if (!$this->file->isDirectory($targetDirectoryPath)) {
            return [];
        }
        
        $filePaths = $this->getAllFilePath($targetDirectoryPath);
        
        return $this->parseAllYaml($filePaths);
    }
    
    /**
     * Create the same file as the first argument at the position specified by the second argument
     *
     * @param  string  $content
     * @param  string  $filePath
     * @param  bool  $isOverwrite
     */
    public function createFile(string $content, string $filePath, bool $isOverwrite = false): void
    {
        $directoryPath = dirname($filePath);
        
        if (!is_dir($directoryPath)) {
            $resultMkdir = mkdir($directoryPath, 0777, true);
            if (!$resultMkdir) {
                throw new LogicException($filePath.': Failed to directory create');
            }
        }
        
        if (!file_exists($filePath)) {
            $resultCreate = file_put_contents($filePath, $content);
            if ($resultCreate === false) {
                throw new LogicException($filePath.': Failed to create');
            }
            return;
        }
        
        if ($isOverwrite && file_exists($filePath)) {
            // Hack:
            // An error occurred when overwriting, so always delete → create
            $resultDelete = unlink($filePath);
            if (!$resultDelete) {
                throw new LogicException($filePath.': Failed to delete');
            }
            
            $resultCreate = file_put_contents($filePath, $content);
            if ($resultCreate === false) {
                throw new LogicException($filePath.': Failed to create');
            }
        }
    }
    
    /**
     * Add Tab Space
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
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function getFile(string $path): string
    {
        return $this->file->get($path);
    }
    
    /**
     * Recursively get a list of file paths from a directory
     *
     * @param  string  $directoryPath
     * @return array
     */
    public function getAllFilePath(string $directoryPath): array
    {
        $filePaths = [];
        
        if (!$this->file->isDirectory($directoryPath)) {
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
     * Parse all definition Yaml files
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
     * Parse Yaml files
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
