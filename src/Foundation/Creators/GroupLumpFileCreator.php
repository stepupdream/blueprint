<?php

namespace StepUpDream\Blueprint\Foundation\Creators;

use LogicException;

/**
 * Class GroupLumpFileCreator
 *
 * @package StepUpDream\Blueprint\Foundation\Creators
 */
class GroupLumpFileCreator extends BaseCreator implements FoundationCreatorInterface
{
    /**
     * Execution of processing
     *
     * @param array $foundation
     */
    public function run(array $foundation) : void
    {
        // Read yaml file
        if (is_dir($foundation['read_path'])) {
            $read_yaml_files = $this->readYamlFile($foundation);
        } else {
            throw new LogicException($foundation['read_path'] . ': read path must be a directory');
        }
        
        if (empty($foundation['output_directory_path'])) {
            throw new LogicException('output_directory_path is not found');
        }
        
        // create class file
        $read_yaml_files_groups = collect($read_yaml_files)->groupBy($foundation['group_key_name'])->all();
        foreach ($read_yaml_files_groups as $key => $read_yaml_files_group) {
            $class_file_path = $foundation['output_directory_path'] . DIRECTORY_SEPARATOR . $key . '.php';
            $blade_file = $this->readBladeFileLump($foundation, $class_file_path, $read_yaml_files_group);
            $this->file_operation->createFile($blade_file, $class_file_path, $foundation['is_override']);
        }
    }
}
