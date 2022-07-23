<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Creator;

use Illuminate\Http\File;
use LogicException;
use StepUpDream\Blueprint\Creator\Foundations\GroupLumpAddMethod;

class GroupLumpAddMethodCreator extends BaseCreator
{
    /**
     * Execution of processing.
     *
     * Output the read yaml contents as a group. Assuming one method per Yaml.
     *
     * @param  \StepUpDream\Blueprint\Creator\Foundations\GroupLumpAddMethod  $foundation
     */
    public function run(GroupLumpAddMethod $foundation): void
    {
        $yamlFiles = $this->yamlReader->readByDirectoryPath($foundation->readPath(), $foundation->exceptFileNames());
        $yamlFileCommon = $this->yamlReader->readByFileName($foundation->readPath(), $foundation->commonFileName());

        foreach ($yamlFiles as $yamlFile) {
            $fileName = $yamlFile[$foundation->groupKeyName()];
            $fileName = $this->textSupport->convertName($foundation->convertClassNameType(), $fileName);
            $classPath = $this->generateOutputFileFullPath($fileName, $foundation, $yamlFile);
            $methodName = $this->textSupport->convertName(
                $foundation->methodNameType(),
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
                $this->fileCreator->createFile($blade, $classPath, false);
            }
        }
    }

    /**
     * Read blade file for add template file.
     *
     * @param  \StepUpDream\Blueprint\Creator\Foundations\GroupLumpAddMethod  $foundation
     * @param  string  $classFilePath
     * @param  string  $fileName
     * @param  mixed[]  $yamlFile
     * @param  mixed[]  $yamlFileCommon
     * @return string
     */
    protected function readBladeAddTemplate(
        GroupLumpAddMethod $foundation,
        string $classFilePath,
        string $fileName,
        array $yamlFile,
        array $yamlFileCommon
    ): string {
        $arguments = $this->argumentsToView($foundation, $classFilePath, $yamlFileCommon, $fileName, $yamlFile);
        $arguments['yamlFile'] = $yamlFile;

        return view($foundation->addTemplateBladeFile(), $arguments)->render();
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

        return preg_replace('/}[^}]*$/', $replacement, $this->fileCreator->get($classFilePath));
    }
}
