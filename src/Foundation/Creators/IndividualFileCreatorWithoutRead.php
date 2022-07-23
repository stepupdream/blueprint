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
     * Output the contents of blade as a file regardless of the contents of Yaml file
     *
     * [Keys that can be set : required]
     * - output_path : string
     * - extension : string
     * - template_blade_file : string
     * - is_override : bool
     *
     * [Keys that can be set : option]
     * - extends_class_name : string
     * - use_extends_class : string
     * - interface_class_name : string
     * - use_interface_class : string
     * - request_directory_path : string
     * - response_directory_path : string
     * - option : string
     *
     * @param  array  $foundation
     */
    public function run(array $foundation): void
    {
        $this->verifyKeys($foundation, ['output_path', 'extension', 'template_blade_file', 'is_override']);
        $classFilePath = $foundation['output_path'];
        $bladeFile = $this->readBladeFileIndividual($foundation, $classFilePath, '', [], []);
        $this->yamlFileOperation->createFile($bladeFile, $classFilePath, $foundation['is_override']);
    }
}
