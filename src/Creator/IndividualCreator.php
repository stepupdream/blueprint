<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Creator;

use Illuminate\Contracts\View\Factory;
use StepUpDream\Blueprint\Creator\Foundations\Individual;
use StepUpDream\SpreadSheetConverter\DefinitionDocument\Supports\Task;

class IndividualCreator extends BaseCreator
{
    /**
     * Execution of processing.
     *
     * Output the file according to the read yaml file.
     *
     * @param  \StepUpDream\Blueprint\Creator\Foundations\Individual  $foundation
     * @noinspection DuplicatedCode
     */
    public function run(Individual $foundation): void
    {
        $task = new Task($this->output);
        $yamlFiles = $this->yamlReader->readByDirectoryPath($foundation->readPath(), $foundation->exceptFileNames());

        if (empty($yamlFiles)) {
            $task->render('No file to load : '.$foundation->readPath(), fn () => 'ERROR');
        }

        foreach ($yamlFiles as $filePath => $yamlFile) {
            $fileName = basename($filePath, '.yml');
            $fileName = $this->textSupport->convertName($foundation->convertClassNameType(), $fileName);

            $outputDirectoryPath = $foundation->replaceAtSign($fileName, $foundation->outputDirectoryPath(), $yamlFile);
            $classFilePath = $foundation->outputFileFullPath($fileName, $outputDirectoryPath);
            $yamlFileCommon = $this->yamlReader->readByFileName($foundation->readPath(), $foundation->commonFileName());
            $renderText = [];
            $renderText['yamlFile'] = $yamlFile;
            $renderText['yamlCommonFile'] = $yamlFileCommon;
            $renderText['namespace'] = $this->textSupport->convertFileFullPathToNamespace($classFilePath);
            $renderText['className'] = pathinfo($classFilePath, PATHINFO_FILENAME);
            $renderText['options'] = $foundation->optionsForBlade($fileName, $yamlFile);
            $bladeFile = app(Factory::class)->make($foundation->templateBladeFile(), $renderText)->render();

            $task->render(
                $classFilePath,
                fn () => $this->fileCreator->create($bladeFile, $classFilePath, $foundation->isOverride())
            );
        }
    }
}
