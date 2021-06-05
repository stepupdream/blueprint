<?php

namespace StepUpDream\Blueprint\Foundation\Creators;

use StepUpDream\Blueprint\Foundation\Foundation;

/**
 * Class GroupLumpFileCreatorWithAddMethod
 */
class GroupLumpFileCreatorWithAddMethod extends BaseCreator implements FoundationCreatorInterface
{
    /**
     * Execution of processing
     *
     * Output the read yaml contents as a group. Assuming one method per Yaml.
     *
     * @param  \StepUpDream\Blueprint\Foundation\Foundation  $foundation
     */
    public function run(Foundation $foundation): void
    {
        $requiredKey = [
            'readPath', 'outputDirectoryPath', 'extension', 'methodKeyName',
            'addTemplateBladeFile', 'groupKeyName', 'templateBladeFile',
        ];
        $this->verifyKeys($foundation, $requiredKey);
        $yamlFiles = $this->yamlReader->readFileByDirectoryPath($foundation->readPath(), $foundation->exceptFileNames());
        $yamlFileCommon = $this->yamlReader->readFileByFileName($foundation->readPath(), $foundation->commonFileName());

        foreach ($yamlFiles as $yamlFile) {
            $fileName = $yamlFile[$foundation->groupKeyName()];
            $fileName = $this->textSupport->convertNameByConvertType($foundation->convertClassNameType(), $fileName);
            $classFilePath = $this->generateOutputFileFullPath($fileName, $foundation, $yamlFile);
            $methodName = $this->textSupport->convertNameByConvertType(
                $foundation->convertMethodNameType(),
                $yamlFile[$foundation->methodKeyName()]
            );

            // Only add methods if you already have a class
            if (file_exists($classFilePath) &&
                ! method_exists($this->textSupport->convertFileFullPathToClassPath($classFilePath), $methodName)) {

                // Replace } at the end of file with new method
                $bladeFile = $this->readBladeFileAddTemplate($foundation, $classFilePath, $fileName, $yamlFile, $yamlFileCommon);
                $newFile = $this->replaceClassFile($bladeFile, $classFilePath);
                $this->fileCreator->createFile($newFile, $classFilePath, true);
            } else {
                $bladeFile = $this->readBladeFileIndividual($foundation, $classFilePath, $fileName, $yamlFile, $yamlFileCommon);
                $this->fileCreator->createFile($bladeFile, $classFilePath, $foundation->isOverride());
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
        return preg_replace('/}[^}]*$\n/', PHP_EOL.$this->fileCreator->addTabSpace().$bladeFile.'}'.PHP_EOL,
            $this->fileCreator->getFile($classFilePath));
    }
}
