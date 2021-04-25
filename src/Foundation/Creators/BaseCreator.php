<?php

namespace StepUpDream\Blueprint\Foundation\Creators;

use Illuminate\Support\Str;
use LogicException;
use StepUpDream\Blueprint\Foundation\Supports\YamlFileOperation;

/**
 * Class BaseCreator
 *
 * @package StepUpDream\Blueprint\Foundation\Creators
 */
class BaseCreator
{
    /**
     * @var \StepUpDream\Blueprint\Foundation\Supports\YamlFileOperation
     */
    protected YamlFileOperation $yamlFileOperation;
    
    /**
     * BaseCreator constructor.
     *
     * @param  \StepUpDream\Blueprint\Foundation\Supports\YamlFileOperation  $yamlFileOperation
     */
    public function __construct(
        YamlFileOperation $yamlFileOperation
    ) {
        $this->yamlFileOperation = $yamlFileOperation;
    }
    
    /**
     * Convert file path to namespace
     *
     * @param  string  $fileFullPath
     * @return string
     */
    protected function convertFileFullPathToNamespace(string $fileFullPath): string
    {
        return str_replace([
            base_path('app'),
            DIRECTORY_SEPARATOR.basename($fileFullPath),
            DIRECTORY_SEPARATOR,
        ], [
            'App',
            '',
            '\\',
        ], $fileFullPath);
    }
    
    /**
     * Convert file path to class path
     *
     * @param  string  $fileFullPath
     * @return string
     */
    protected function convertFileFullPathToClassPath(string $fileFullPath): string
    {
        $temp = str_replace([
            base_path('app'),
            DIRECTORY_SEPARATOR,
        ], [
            'App',
            '\\',
        ], $fileFullPath);
        
        return pathinfo($temp)['filename'];
    }
    
    /**
     * Read blade file for Individual file
     *
     * @param  array  $foundation
     * @param  string  $classFilePath
     * @param  string  $fileName
     * @param  array  $readYamlFile
     * @param  array  $commonYamlFile
     * @return string
     */
    protected function readBladeFileIndividual(
        array $foundation,
        string $classFilePath,
        string $fileName,
        array $readYamlFile,
        array $commonYamlFile
    ): string {
        $fileName = $this->convertFileNameByConvertClassNameType($foundation, $fileName);
        $foundation['use_extends_class'] = $this->organizeFilesIntoSpecifiedDirectory($foundation, $readYamlFile, 'use_extends_class');
        $useExtendsClass = $this->replaceTargetKeyTextWithFileName($foundation, $fileName, 'use_extends_class');
        $foundation['use_interface_class'] = $this->replaceTargetKeyTextWithFileName($foundation, $fileName, 'use_interface_class');
        $foundation['option'] = $this->replaceTargetKeyTextWithFileName($foundation, $fileName, 'option');

        return view($foundation['template_blade_file'],
            [
                'namespace'               => $this->convertFileFullPathToNamespace($classFilePath),
                'class_name'              => basename($classFilePath, '.'.$foundation['extension']),
                'extends_class_name'      => empty($foundation['extends_class_name']) ? '' : ' extends '.$foundation['extends_class_name'],
                'use_extends_class'       => empty($useExtendsClass) ? '' : 'use '.$useExtendsClass,
                'interface_class_name'    => empty($foundation['interface_class_name']) ? '' : ' implements '.$foundation['interface_class_name'],
                'use_interface_class'     => empty($foundation['use_interface_class']) ? '' : $foundation['use_interface_class'],
                'yaml'                    => $readYamlFile,
                'common_model'            => $commonYamlFile,
                'request_directory_path'  => empty($foundation['request_directory_path']) ? '' : $foundation['request_directory_path'],
                'response_directory_path' => empty($foundation['response_directory_path']) ? '' : $foundation['response_directory_path'],
                'option'                  => empty($foundation['option']) ? '' : $foundation['option'],
            ])->render();
    }
    
    /**
     * Read blade file for add template file
     *
     * @param  array  $foundation
     * @param  array  $readYamlFile
     * @return string
     */
    protected function readBladeFileAddTemplate(
        array $foundation,
        array $readYamlFile
    ): string {
        return view($foundation['add_template_blade_file'],
            [
                'yaml'                    => $readYamlFile,
                'request_directory_path'  => $foundation['request_directory_path'] ?? '',
                'response_directory_path' => $foundation['response_directory_path'] ?? '',
            ])->render();
    }
    
    /**
     * convert class file path
     *
     * @param  array  $foundation
     * @param  string  $fileName
     * @param  array  $readYamlFile
     * @return string
     */
    protected function convertClassFilePath(array $foundation, string $fileName, array $readYamlFile): string
    {
        $fileName = $this->convertFileNameByConvertClassNameType($foundation, $fileName);
        
        $foundation['output_directory_path'] = $this->organizeFilesIntoSpecifiedDirectory($foundation, $readYamlFile, 'output_directory_path');
        $outputDirectoryPath = $this->replaceTargetKeyTextWithFileName($foundation, $fileName, 'output_directory_path');
        $prefix = $foundation['prefix'] ?? '';
        $suffix = $foundation['suffix'] ?? '';
        
        return $outputDirectoryPath.DIRECTORY_SEPARATOR.$prefix.$fileName.$suffix.'.'.$foundation['extension'];
    }
    
    /**
     * Replaces %s in the specified text with the file name
     *
     * @param  array  $foundation
     * @param  string  $fileName
     * @param  string  $key
     * @return string
     */
    protected function replaceTargetKeyTextWithFileName(array $foundation, string $fileName, string $key): string
    {
        if (isset($foundation[$key])) {
            return str_replace('%s', $fileName, $foundation[$key]);
        }
        
        return '';
    }
    
    /**
     * Organize files into specified directory
     *
     * @param  array  $foundation
     * @param  array  $readYamlFile
     * @param  string  $key
     * @return string
     */
    protected function organizeFilesIntoSpecifiedDirectory(array $foundation, array $readYamlFile, string $key): string
    {
        if (isset($foundation['directory_group_key_name'])) {
            return str_replace('%g', $readYamlFile[$foundation['directory_group_key_name']], $foundation[$key]);
        }
        
        return $foundation[$key] ?? '';
    }
    
    /**
     * convert file name by convert class name type
     *
     * @param  array  $foundation
     * @param  string  $fileName
     * @return string
     */
    protected function convertFileNameByConvertClassNameType(array $foundation, string $fileName): string
    {
        if (empty($foundation['convert_class_name_type'])) {
            return $fileName;
        }
        
        switch ($foundation['convert_class_name_type']) {
            case 'studly':
            case 'upper_camel':
                $result = Str::studly($fileName);
                break;
            case 'camel':
                $result = Str::camel($fileName);
                break;
            case 'snake':
                $result = Str::snake($fileName);
                break;
            case 'kebab':
                $result = Str::kebab($fileName);
                break;
            case 'singular_studly':
            case 'singular_upper_camel':
                $result = Str::studly(snake_singular($fileName));
                break;
            case 'singular_camel':
                $result = Str::camel(snake_singular($fileName));
                break;
            case 'singular_snake':
                $result = Str::snake(snake_singular($fileName));
                break;
            case 'singular_kebab':
                $result = Str::kebab(snake_singular($fileName));
                break;
            case 'plural_studly':
            case 'plural_upper_camel':
                $result = Str::studly(Str::plural($fileName));
                break;
            case 'plural_camel':
                $result = Str::camel(Str::plural($fileName));
                break;
            case 'plural_snake':
                $result = Str::snake(Str::plural($fileName));
                break;
            case 'plural_kebab':
                $result = Str::kebab(Str::plural($fileName));
                break;
            default:
                throw new LogicException('The data in convert_class_name_type is incorrect');
        }
        
        return $result;
    }
    
    /**
     * Read blade file
     *
     * @param  array  $foundation
     * @param  string  $classFilePath
     * @param  array  $readYamlFiles
     * @return string
     */
    protected function readBladeFileLump(array $foundation, string $classFilePath, array $readYamlFiles): string
    {
        return view($foundation['template_blade_file'],
            [
                'namespace'            => $this->convertFileFullPathToNamespace($classFilePath),
                'class_name'           => basename($classFilePath, '.'.$foundation['extension']),
                'extends_class_name'   => empty($foundation['extends_class_name']) ? '' : ' extends '.$foundation['extends_class_name'],
                'use_extends_class'    => empty($foundation['use_extends_class']) ? '' : 'use '.$foundation['use_extends_class'],
                'interface_class_name' => empty($foundation['interface_class_name']) ? '' : ' implements '.$foundation['interface_class_name'],
                'use_interface_class'  => empty($foundation['use_interface_class']) ? '' : $foundation['use_interface_class'],
                'yamls'                => $readYamlFiles,
                'option'               => $foundation['option'] ?? '',
            ])->render();
    }
    
    /**
     * Read yaml files
     *
     * @param  array  $foundation
     * @param  bool  $isExceptFile
     * @return array
     */
    protected function readYamlFile(array $foundation, bool $isExceptFile = true): array
    {
        $readYamlFiles = $this->yamlFileOperation->readByDirectoryPath($foundation['read_path']);
        
        // Exclude from creation
        if ($isExceptFile && isset($foundation['except_file_names'])) {
            $readYamlFiles = collect($readYamlFiles)->filter(function ($value, $key) use ($foundation) {
                return !in_array(Str::studly(basename($key, '.yml')), $foundation['except_file_names'], false);
            })->all();
        }
        
        return $readYamlFiles;
    }
    
    /**
     * Read common yaml files
     *
     * @param  array  $foundation
     * @return array
     */
    protected function readCommonYamlFile(array $foundation): array
    {
        $commonYamlFile = [];
        if (isset($foundation['common_file_name'])) {
            $readYamlFiles = $this->readYamlFile($foundation, false);
            
            foreach ($readYamlFiles as $fileName => $readYamlFile) {
                if (basename($fileName, '.yml') === $foundation['common_file_name']) {
                    $commonYamlFile = $readYamlFile;
                    break;
                }
            }
        }
        
        return $commonYamlFile;
    }
    
    /**
     * Verify if there is a required key
     *
     * @param  array  $foundation
     * @param  array  $requiredKeys
     * @param  array  $prohibitionKeys
     */
    protected function verifyKeys(array $foundation, array $requiredKeys, array $prohibitionKeys = []): void
    {
        foreach ($requiredKeys as $requiredKey) {
            if (!array_key_exists($requiredKey, $foundation)) {
                throw new LogicException($requiredKey.' is required');
            }
        }
        
        foreach ($prohibitionKeys as $prohibitionKey) {
            if (array_key_exists($prohibitionKey, $foundation)) {
                throw new LogicException(' Do not need : '.$prohibitionKey);
            }
        }
    }
}
