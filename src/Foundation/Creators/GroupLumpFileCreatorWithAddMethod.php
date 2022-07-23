<?php

namespace StepUpDream\Blueprint\Foundation\Creators;

use Illuminate\Support\Str;
use LogicException;

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
     * Output the read yaml contents as a group
     * Assuming one method per Yaml
     *
     * [Keys that can be set : required]
     * - read_path : string
     * - output_directory_path : string
     * - extension : string
     * - method_key_name : string
     * - add_template_blade_file : string
     * - group_key_name : string
     * - template_blade_file : string
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
        $this->verifyKeys($foundation, ['read_path', 'output_directory_path', 'extension', 'template_blade_file']);
        if (is_dir($foundation['read_path'])) {
            $readYamlFiles = $this->readYamlFile($foundation);
        } else {
            throw new LogicException($foundation['read_path'].': read path must be a directory');
        }
        
        foreach ($readYamlFiles as $readYamlFile) {
            $fileName = $readYamlFile[$foundation['group_key_name']];
            $classFilePath = $this->convertClassFilePath($foundation, $fileName, $readYamlFile);
            
            // Only add methods if you already have a class
            if (file_exists($classFilePath) &&
                !method_exists($this->convertFileFullPathToClassPath($classFilePath), Str::camel($readYamlFile[$foundation['method_key_name']]))) {
                
                // Replace } at the end of file with new method
                $bladeFile = $this->readBladeFileAddTemplate($foundation, $readYamlFile);
                $newFile = $this->replaceClassFile($bladeFile, $classFilePath);
                $this->yamlFileOperation->createFile($newFile, $classFilePath, true);
            } else {
                $commonYamlFile = $this->readCommonYamlFile($foundation);
                $bladeFile = $this->readBladeFileIndividual($foundation, $classFilePath, $fileName, $readYamlFile, $commonYamlFile);
                $this->yamlFileOperation->createFile($bladeFile, $classFilePath);
            }
        }
    }
    
    /**
     * Replace class file
     *
     * @param  string  $bladeFile
     * @param  string  $classFilePath
     * @return array|string|string[]|null
     */
    protected function replaceClassFile(string $bladeFile, string $classFilePath)
    {
        return preg_replace('/}[^}]*$\n/', PHP_EOL.$this->yamlFileOperation->addTabSpace().$bladeFile.'}'.PHP_EOL,
            $this->yamlFileOperation->getFile($classFilePath));
    }
}
