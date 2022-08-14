<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Creator;

use Illuminate\Contracts\View\Factory;
use StepUpDream\Blueprint\Creator\Foundations\GroupLumpAddMethod;
use StepUpDream\SpreadSheetConverter\DefinitionDocument\Supports\Task;

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
        $task = new Task($this->output);
        $yamlFiles = $this->yamlReader->readByDirectoryPath($foundation->readPath(), $foundation->exceptFileNames());

        if (empty($yamlFiles)) {
            $task->render('No file to load : '.$foundation->readPath(), fn () => 'ERROR');
        }

        foreach ($yamlFiles as $yamlFile) {
            $fileName = $yamlFile[$foundation->groupKeyName()];
            $fileName = $this->textSupport->convertName($foundation->convertClassNameType(), $fileName);
            $classPath = $this->generateOutputFileFullPath($fileName, $foundation, $yamlFile);
            $task->render($classPath, fn () => $this->createFile($foundation, $fileName, $classPath, $yamlFile));
        }
    }

    /**
     * Generate various files used in the project based on the Yaml file.
     *
     * @param  \StepUpDream\Blueprint\Creator\Foundations\GroupLumpAddMethod  $foundation
     * @param  string  $fileName
     * @param  string  $classPath
     * @param  mixed[]  $yamlFile
     * @return string
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function createFile(
        GroupLumpAddMethod $foundation,
        string $fileName,
        string $classPath,
        array $yamlFile
    ): string {
        $yamlFileCommon = $this->yamlReader->readByFileName($foundation->readPath(), $foundation->commonFileName());
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

            return $this->fileCreator->create($newFile, $classPath, true);
        }

        $blade = $this->readBladeIndividual($foundation, $classPath, $fileName, $yamlFile, $yamlFileCommon);

        return $this->fileCreator->create($blade, $classPath);
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

        return app(Factory::class)->make($foundation->addTemplateBladeFile(), $arguments)->render();
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

        return (string) preg_replace('/}[^}]*$/', $replacement, $this->fileCreator->get($classFilePath));
    }
}
