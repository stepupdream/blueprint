<?php

namespace StepUpDream\Blueprint\Foundation\Creators;

use Illuminate\Support\Str;
use LogicException;
use StepUpDream\Blueprint\Foundation\Supports\FileOperation;
use YamlFileReader;

/**
 * Class BaseCreator
 *
 * @package StepUpDream\Blueprint\Foundation\Creators
 */
abstract class BaseCreator
{
    /**
     * @var \StepUpDream\Blueprint\Foundation\Supports\FileOperation
     */
    protected $file_operation;
    
    /**
     * BaseCreator constructor.
     *
     * @param \StepUpDream\Blueprint\Foundation\Supports\FileOperation $file_operation
     */
    public function __construct(
        FileOperation $file_operation
    ) {
        $this->file_operation = $file_operation;
    }
    
    /**
     * Convert file path to namespace
     *
     * @param string $file_full_path
     * @return string
     */
    protected function convertFileFullPathToNamespace(string $file_full_path) : string
    {
        return str_replace([
            base_path('app'),
            DIRECTORY_SEPARATOR . basename($file_full_path),
            DIRECTORY_SEPARATOR,
        ], [
            'App',
            '',
            '\\',
        ], $file_full_path);
    }
    
    /**
     * Convert file path to class path
     *
     * @param string $file_full_path
     * @return string
     */
    protected function convertFileFullPathToClassPath(string $file_full_path) : string
    {
        $temp = str_replace([
            base_path('app'),
            DIRECTORY_SEPARATOR,
        ], [
            'App',
            '\\',
        ], $file_full_path);
        
        return pathinfo($temp)['filename'];
    }
    
    /**
     * Read blade file
     *
     * @param array $foundation
     * @param string $class_file_path
     * @param string $file_name
     * @param array $read_yaml_file
     * @param array $common_yaml_file
     * @return string
     */
    protected function readBladeFileIndividual(array $foundation, string $class_file_path, string $file_name, array $read_yaml_file, array $common_yaml_file) : string
    {
        $file_name = $this->convertFileName($foundation, $file_name);
        
        $foundation['use_extends_class'] = $this->organizeFilesIntoSpecifiedDirectory($foundation, $read_yaml_file, 'use_extends_class');
        $use_extends_class = $this->addFileNameToFormat($foundation, $file_name, 'use_extends_class');
        $foundation['use_interface_class'] = $this->addFileNameToFormat($foundation, $file_name, 'use_interface_class');
        $foundation['option'] = $this->addFileNameToFormat($foundation, $file_name, 'option');
        
        return view($foundation['template_blade_file'],
            [
                'namespace'            => $this->convertFileFullPathToNamespace($class_file_path),
                'class_name'           => basename($class_file_path, '.' . $foundation['extension']),
                'extends_class_name'   => empty($foundation['extends_class_name']) ? '' : ' extends ' . $foundation['extends_class_name'],
                'use_extends_class'    => empty($use_extends_class) ? '' : 'use ' . $use_extends_class,
                'interface_class_name' => empty($foundation['interface_class_name']) ? '' : ' implements ' . $foundation['interface_class_name'],
                'use_interface_class'  => empty($foundation['use_interface_class']) ? '' : $foundation['use_interface_class'],
                'model'                => $read_yaml_file,
                'common_model'         => $common_yaml_file,
                'option'               => empty($foundation['option']) ? '' : $foundation['option'],
            ])->render();
    }
    
    /**
     * convert class file path
     *
     * @param array $foundation
     * @param string $file_name
     * @param array $read_yaml_file
     * @return string
     */
    protected function convertClassFilePath(array $foundation, string $file_name, array $read_yaml_file) : string
    {
        $file_name = $this->convertFileName($foundation, $file_name);
        
        if (isset($foundation['output_directory_path'])) {
            $foundation['output_directory_path'] = $this->organizeFilesIntoSpecifiedDirectory($foundation, $read_yaml_file, 'output_directory_path');
            $output_directory_path = $this->addFileNameToFormat($foundation, $file_name, 'output_directory_path');
            
            $prefix = $foundation['prefix'] ?? '';
            $suffix = $foundation['suffix'] ?? '';
            return $output_directory_path . DIRECTORY_SEPARATOR . $prefix . $file_name . $suffix . '.' . $foundation['extension'];
        }
        
        return $foundation['output_path'];
    }
    
    /**
     * Add file name to format
     *
     * @param array $foundation
     * @param string $file_name
     * @param string $key
     * @return string
     */
    protected function addFileNameToFormat(array $foundation, string $file_name, string $key) : string
    {
        if (isset($foundation[$key])) {
            return str_replace('%s', $file_name, $foundation[$key]);
        }
        
        return '';
    }
    
    /**
     * Organize files into specified directory
     *
     * @param array $foundation
     * @param array $read_yaml_file
     * @param string $key
     * @return string
     */
    protected function organizeFilesIntoSpecifiedDirectory(array $foundation, array $read_yaml_file, string $key) : string
    {
        if (isset($foundation['directory_group_key_name'])) {
            return str_replace('%g', $read_yaml_file[$foundation['directory_group_key_name']], $foundation[$key]);
        }
        
        return $foundation[$key] ?? '';
    }
    
    /**
     * Add file name to output path
     *
     * @param array $foundation
     * @param string $file_name
     * @return string
     */
    protected function convertFileName(array $foundation, string $file_name) : string
    {
        if (empty($foundation['convert_class_name_type'])) {
            return $file_name;
        }
        
        switch ($foundation['convert_class_name_type']) {
            case 'studly':
            case 'upper_camel':
                $result = Str::studly($file_name);
                break;
            case 'camel':
                $result = Str::camel($file_name);
                break;
            case 'snake':
                $result = Str::snake($file_name);
                break;
            case 'kebab':
                $result = Str::kebab($file_name);
                break;
            case 'singular_studly':
            case 'singular_upper_camel':
                $result = Str::studly(Str::singular($file_name));
                break;
            case 'singular_camel':
                $result = Str::camel(Str::singular($file_name));
                break;
            case 'singular_snake':
                $result = Str::snake(Str::singular($file_name));
                break;
            case 'singular_kebab':
                $result = Str::kebab(Str::singular($file_name));
                break;
            case 'plural_studly':
            case 'plural_upper_camel':
                $result = Str::studly(Str::plural($file_name));
                break;
            case 'plural_camel':
                $result = Str::camel(Str::plural($file_name));
                break;
            case 'plural_snake':
                $result = Str::snake(Str::plural($file_name));
                break;
            case 'plural_kebab':
                $result = Str::kebab(Str::plural($file_name));
                break;
            default:
                throw new LogicException('The data in convert_class_name_type is incorrect');
        }
    
        return $result;
    }
    
    /**
     * convert class file path
     *
     * @param array $foundation
     * @param string $file_name
     * @param array $read_yaml_file
     * @return string
     */
    protected function convertClassFilePathGroupKey(array $foundation, string $file_name, array $read_yaml_file) : string
    {
        $foundation['output_directory_path'] = $this->addFileNameToFormat($foundation, $file_name, 'output_directory_path');
        
        $prefix = $foundation['prefix'] ?? '';
        $suffix = $foundation['suffix'] ?? '';
        
        return $foundation['output_directory_path'] . DIRECTORY_SEPARATOR . $prefix . $read_yaml_file[$foundation['group_key_name']] . $suffix . '.' . $foundation['extension'];
    }
    
    /**
     * Read blade file
     *
     * @param array $foundation
     * @param string $class_file_path
     * @param array $read_yaml_files
     * @return string
     */
    protected function readBladeFileLump(array $foundation, string $class_file_path, array $read_yaml_files) : string
    {
        return view($foundation['template_blade_file'],
            [
                'namespace'            => $this->convertFileFullPathToNamespace($class_file_path),
                'class_name'           => basename($class_file_path, '.' . $foundation['extension']),
                'extends_class_name'   => empty($foundation['extends_class_name']) ? '' : ' extends ' . $foundation['extends_class_name'],
                'use_extends_class'    => empty($foundation['use_extends_class']) ? '' : 'use ' . $foundation['use_extends_class'],
                'interface_class_name' => empty($foundation['interface_class_name']) ? '' : ' implements ' . $foundation['interface_class_name'],
                'use_interface_class'  => empty($foundation['use_interface_class']) ? '' : $foundation['use_interface_class'],
                'models'               => $read_yaml_files,
                'option'               => $foundation['option'] ?? '',
            ])->render();
    }
    
    /**
     * Read yaml files
     *
     * @param array $foundation
     * @param bool $is_except_file
     * @return array
     */
    protected function readYamlFile(array $foundation, bool $is_except_file = true) : array
    {
        $read_yaml_files = YamlFileReader::readByDirectoryPath($foundation['read_path']);

        // Exclude from creation
        if ($is_except_file && isset($foundation['except_file_names'])) {
            $read_yaml_files = collect($read_yaml_files)->filter(function ($key) use ($foundation) {
                return !in_array(Str::studly(basename($key, '.yml')), $foundation['except_file_names'], false);
            })->all();
        }
        
        return $read_yaml_files;
    }
    
    /**
     * Read common yaml files
     *
     * @param array $foundation
     * @return array
     */
    protected function readCommonYamlFile(array $foundation) : array
    {
        $common_yaml_file = [];
        if (isset($foundation['common_file_name'])) {
            $read_yaml_files = $this->readYamlFile($foundation, false);
            
            foreach ($read_yaml_files as $file_name => $read_yaml_file) {
                if (basename($file_name, '.yml') === $foundation['common_file_name']) {
                    $common_yaml_file = $read_yaml_file;
                    break;
                }
            }
        }
        
        return $common_yaml_file;
    }
}
