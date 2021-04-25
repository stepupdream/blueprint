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
     * Output the read yaml contents as a group
     *
     * [Keys that can be set : required]
     * - read_path : string
     * - output_directory_path : string
     * - group_key_name : string
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
        $this->verifyKeys($foundation, ['read_path', 'output_directory_path', 'group_key_name', 'extension', 'template_blade_file', 'is_override']);
        if (is_dir($foundation['read_path'])) {
            $readYamlFiles = $this->readYamlFile($foundation);
        } else {
            throw new LogicException($foundation['read_path'].': read path must be a directory');
        }
        
        $readYamlFilesGroups = collect($readYamlFiles)->groupBy($foundation['group_key_name'])->toArray();
        foreach ($readYamlFilesGroups as $groupKeyName => $readYamlFilesGroup) {
            $classFilePath = $foundation['output_directory_path'].DIRECTORY_SEPARATOR.$groupKeyName.'.php';
            $bladeFile = $this->readBladeFileLump($foundation, $classFilePath, $readYamlFilesGroup);
            $this->yamlFileOperation->createFile($bladeFile, $classFilePath, $foundation['is_override']);
        }
    }
}
