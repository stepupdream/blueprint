<?php

namespace StepUpDream\Blueprint\Foundation\Creators;

use LogicException;

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
     * Output the file according to the read yaml file
     *
     * [Keys that can be set : required]
     * - read_path : string
     * - output_directory_path : string
     * - extension : string
     * - template_blade_file : string
     * - is_override : bool
     *
     * [Keys that can be set : option]
     * - common_file_name : string
     * - except_file_names : array
     * - convert_class_name_type : string
     * - prefix : string
     * - suffix : string
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
        $this->verifyKeys($foundation, ['read_path', 'output_directory_path', 'extension', 'template_blade_file', 'is_override']);
        $commonYamlFile = $this->readCommonYamlFile($foundation);
        if (is_dir($foundation['read_path'])) {
            $readYamlFiles = $this->readYamlFile($foundation);
        } else {
            throw new LogicException($foundation['read_path'].': read path must be a directory');
        }
        
        foreach ($readYamlFiles as $filePath => $readYamlFile) {
            $fileName = basename($filePath, '.yml');
            $classFilePath = $this->convertClassFilePath($foundation, $fileName, $readYamlFile);
            $bladeFile = $this->readBladeFileIndividual($foundation, $classFilePath, $fileName, $readYamlFile, $commonYamlFile);
            $this->yamlFileOperation->createFile($bladeFile, $classFilePath, $foundation['is_override']);
        }
    }
}
