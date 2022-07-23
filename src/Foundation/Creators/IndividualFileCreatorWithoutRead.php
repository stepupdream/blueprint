<?php

namespace StepUpDream\Blueprint\Foundation\Creators;

/**
 * Class IndividualFileCreatorWithoutRead
 *
 * @package StepUpDream\Blueprint\Foundation\Creators
 */
class IndividualFileCreatorWithoutRead extends BaseCreator implements FoundationCreatorInterface
{
    /**
     * Execution of processing
     *
     * @param array $foundation
     */
    public function run(array $foundation) : void
    {
        // create class file
        $class_file_path = $foundation['output_path'];
        $blade_file = $this->readBladeFileIndividual($foundation, $class_file_path, '', [], []);
        $this->file_operation->createFile($blade_file, $class_file_path, $foundation['is_override']);
    }
}
