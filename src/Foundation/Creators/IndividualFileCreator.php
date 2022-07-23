<?php

namespace StepUpDream\Blueprint\Foundation\Creators;

use YamlFileReader;

/**
 * Class IndividualFileCreator
 *
 * @package StepUpDream\Blueprint\Foundation\Creators
 */
class IndividualFileCreator extends BaseCreator implements FoundationCreatorInterface
{
    /**
     * Execution of processing
     *
     * @param array $foundation
     */
    public function run(array $foundation)
    {
        // Read yaml file
        $common_yaml_file = $this->readCommonYamlFile($foundation);
        if (is_dir($foundation['read_path'])) {
            $read_yaml_files = $this->readYamlFile($foundation);
        } else {
            $read_yaml_files = [$foundation['read_path'] => YamlFileReader::readByFilePath($foundation['read_path'])];
        }
        
        // create class file
        foreach ($read_yaml_files as $file_path => $read_yaml_file) {
            // Exclude from creation
            if (!empty($foundation['key_name_by_except']) && $read_yaml_file[$foundation['key_name_by_except']] === true) {
                continue;
            }
            
            $file_name = basename($file_path, '.yml');
            $class_file_path = $this->convertClassFilePath($foundation, $file_name, $read_yaml_file);
            $blade_file = $this->readBladeFileIndividual($foundation, $class_file_path, $file_name, $read_yaml_file, $common_yaml_file);
            $this->file_operation->createFile($blade_file, $class_file_path, $foundation['is_override']);
        }
    }
}
