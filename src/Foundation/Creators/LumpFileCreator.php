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
     * Combine the contents of the read Yaml into one file
     *
     * [Keys that can be set : required]
     * - read_path : string
     * - output_path : string
     * - extension : string
     * - template_blade_file : string
     * - is_override : bool
     *
     * [Keys that can be set : option]
     * - except_file_names : array
     * - extends_class_name : string
     * - use_extends_class : string
     * - interface_class_name : string
     * - use_interface_class : string
     * - option : string
     *
     * @param  array  $foundation
     */
    public function run(array $foundation): void
    {
        $this->verifyKeys($foundation, ['read_path', 'output_path', 'extension', 'template_blade_file', 'is_override']);
        if (is_dir($foundation['read_path'])) {
            $readYamlFiles = $this->readYamlFile($foundation);
        } else {
            throw new LogicException($foundation['read_path'].': read path must be a directory');
        }
        
        $outputPath = $foundation['output_path'];
        $bladeFile = $this->readBladeFileLump($foundation, $outputPath, $readYamlFiles);
        $this->yamlFileOperation->createFile($bladeFile, $outputPath, $foundation['is_override']);
    }
}
