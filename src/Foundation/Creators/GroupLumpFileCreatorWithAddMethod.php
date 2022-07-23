<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Foundation\Creators;

use StepUpDream\Blueprint\Foundation\Foundation;

class GroupLumpFileCreatorWithAddMethod extends BaseCreator implements FoundationCreatorInterface
{
    /**
     * Execution of processing.
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
        $yamlFiles = $this->yamlReader->readByDirectoryPath($foundation->readPath(), $foundation->exceptFileNames());
        $yamlFileCommon = $this->yamlReader->readFileByFileName($foundation->readPath(), $foundation->commonFileName());

        foreach ($yamlFiles as $yamlFile) {
            $fileName = $yamlFile[$foundation->groupKeyName()];
            $fileName = $this->textSupport->convertName($foundation->convertClassNameType(), $fileName);
            $classPath = $this->generateOutputFileFullPath($fileName, $foundation, $yamlFile);
            $methodName = $this->textSupport->convertName(
                $foundation->convertMethodNameType(),
                $yamlFile[$foundation->methodKeyName()]
            );

            // Only add methods if you already have a class
            if (file_exists($classPath) &&
                ! method_exists($this->textSupport->convertFileFullPathToClassPath($classPath), $methodName)) {
                // Replace } at the end of file with new method
                $blade = $this->readBladeAddTemplate($foundation, $classPath, $fileName, $yamlFile, $yamlFileCommon);
                $newFile = $this->replaceClassFile($blade, $classPath);
                $this->fileCreator->createFile($newFile, $classPath, true);
            } else {
                $blade = $this->readBladeIndividual($foundation, $classPath, $fileName, $yamlFile, $yamlFileCommon);
                $this->fileCreator->createFile($blade, $classPath, $foundation->isOverride());
            }
        }
    }

    /**
     * Replace class file.
     *
     * @param  string  $bladeFile
     * @param  string  $classFilePath
     * @return string
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function replaceClassFile(string $bladeFile, string $classFilePath): string
    {
        $replacement = PHP_EOL.$this->fileCreator->addTabSpace().$bladeFile.'}'.PHP_EOL;

        return preg_replace('/}[^}]*$/', $replacement, $this->fileCreator->getFile($classFilePath));
    }
}
