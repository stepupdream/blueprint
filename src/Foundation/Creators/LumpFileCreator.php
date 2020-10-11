<?php

namespace StepUpDream\Blueprint\Foundation\Creators;

use LogicException;

/**
 * Class LumpFileCreator
 *
 * @package StepUpDream\Blueprint\Foundation\Creators
 */
class LumpFileCreator extends BaseCreator implements FoundationCreatorInterface
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
        
        // create class file
        $class_file_path = $foundation['output_path'];
        $blade_file = $this->readBladeFileLump($foundation, $class_file_path, $read_yaml_files);
        $this->file_operation->createFile($blade_file, $class_file_path, $foundation['is_override']);
    }
}
