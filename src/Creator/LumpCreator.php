<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Creator;

use Illuminate\Contracts\View\Factory;
use StepUpDream\Blueprint\Creator\Foundations\Lump;
use StepUpDream\SpreadSheetConverter\DefinitionDocument\Supports\Task;

class LumpCreator extends BaseCreator
{
    /**
     * Execution of processing.
     *
     * Combine the contents of the read Yaml into one file.
     *
     * @param  \StepUpDream\Blueprint\Creator\Foundations\Lump  $foundation
     * @see \StepUpDream\Blueprint\Creator\Console\FoundationCreateCommand::handle()
     */
    public function run(Lump $foundation): void
    {
        $task = new Task($this->output);
        $yamlFiles = $this->yamlReader->readByDirectoryPath($foundation->readPath(), $foundation->exceptFileNames());

        if (empty($yamlFiles)) {
            $task->render('No file to load : '.$foundation->readPath(), fn () => 'ERROR');

            return;
        }
        $outputPath = $foundation->outputPath();
        $yamlFileCommon = $this->yamlReader->readByFileName($foundation->readPath(), $foundation->commonFileName());
        $fileName = pathinfo($outputPath, PATHINFO_FILENAME);
        $yamlFile = array_values($yamlFiles)[0];
        $renderText = [];
        $renderText['yamlFile'] = $yamlFile;
        $renderText['yamlCommonFile'] = $yamlFileCommon;
        $renderText['namespace'] = $this->textSupport->convertFileFullPathToNamespace($outputPath);
        $renderText['className'] = pathinfo($outputPath, PATHINFO_FILENAME);
        $renderText['options'] = $foundation->optionsForBlade($fileName, $yamlFile);
        $renderText['yamlFiles'] = $yamlFiles;
        $bladeFile = app(Factory::class)->make($foundation->templateBladeFile(), $renderText)->render();

        $task->render(
            $outputPath,
            fn () => $this->fileCreator->create($bladeFile, $outputPath, $foundation->isOverride())
        );
    }
}
