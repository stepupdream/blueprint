<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Creator;

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
        $yamlFiles = $this->yamlReader->readByDirectoryPath($foundation->readPath(), $foundation->exceptFileNames());
        $yamlFileCommon = $this->yamlReader->readByFileName($foundation->readPath(), $foundation->commonFileName());
        $bladeFile = $this->readBladeFileLump($foundation, $foundation->outputPath(), $yamlFiles, $yamlFileCommon);

        $task->render(
            $foundation->outputPath(),
            fn () => $this->fileCreator->create($bladeFile, $foundation->outputPath(), $foundation->isOverride())
        );
    }
}
