<?php

namespace StepUpDream\Blueprint\Foundation\Creators;

use File;
use LogicException;
use Str;

/**
 * Class GroupLumpFileCreatorWithAddMethod
 *
 * @package StepUpDream\Blueprint\Foundation\Creators
 */
class GroupLumpFileCreatorWithAddMethod extends BaseCreator implements FoundationCreatorInterface
{
    /**
     * Execution of processing
     *
     * @param array $foundation
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function run(array $foundation) : void
    {
        // Read yaml file
        if (is_dir($foundation['read_path'])) {
            $common_yaml_file = $this->readCommonYamlFile($foundation);
            $read_yaml_files = $this->readYamlFile($foundation);
        } else {
            throw new LogicException($foundation['read_path'] . ': read path must be a directory');
        }
        
        if (empty($foundation['output_directory_path'])) {
            throw new LogicException('output_directory_path is not found');
        }
        
        // create class file
        foreach ($read_yaml_files as $file_path => $read_yaml_file) {
            // Exclude from creation
            if (!empty($foundation['key_name_by_except']) && $read_yaml_file[$foundation['key_name_by_except']] === true) {
                continue;
            }
            
            $file_name = basename($file_path, '.yml');
            $class_file_path = $this->convertClassFilePathGroupKey($foundation, $file_name, $read_yaml_file);
            
            // Only add methods if you already have a class
            if (File::exists($class_file_path) && !method_exists($this->convertFileFullPathToClassPath($class_file_path), Str::camel($read_yaml_file[$foundation['method_key_name']]))) {
                $blade_file = view($foundation['add_template_blade_file'],
                    [
                        'model' => $read_yaml_file,
                    ])->render();
                
                // Replace } at the end of file with new method
                $new_file = preg_replace('/}[^}]*$\n/', PHP_EOL . $this->file_operation->addTabSpace() . $blade_file . '}' . PHP_EOL, File::get($class_file_path));
                $this->file_operation->createFile($new_file, $class_file_path, true);
            } else {
                $blade_file = $this->readBladeFileIndividual($foundation, $class_file_path, $file_name, $read_yaml_file, $common_yaml_file);
                $this->file_operation->createFile($blade_file, $class_file_path, false);
            }
        }
    }
}
