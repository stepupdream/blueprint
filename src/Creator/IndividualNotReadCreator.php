<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Creator;

use Illuminate\Contracts\View\Factory;
use StepUpDream\Blueprint\Creator\Foundations\IndividualNotRead;
use StepUpDream\SpreadSheetConverter\DefinitionDocument\Supports\Task;

class IndividualNotReadCreator extends BaseCreator
{
    /**
     * Execution of processing.
     *
     * Output the contents of blade as a file regardless of the contents of Yaml file
     *
     * @param  \StepUpDream\Blueprint\Creator\Foundations\IndividualNotRead  $foundation
     */
    public function run(IndividualNotRead $foundation): void
    {
        $classFilePath = $foundation->outputPath();
        $renderText = [];
        $renderText['namespace'] = $this->textSupport->convertFileFullPathToNamespace($classFilePath);
        $renderText['className'] = pathinfo($classFilePath, PATHINFO_FILENAME);
        $renderText['options'] = $foundation->optionsForBlade();
        $bladeFile = app(Factory::class)->make($foundation->templateBladeFile(), $renderText)->render();

        (new Task($this->output))->render($classFilePath, function () use ($bladeFile, $classFilePath, $foundation) {
            return $this->fileCreator->create($bladeFile, $classFilePath, $foundation->isOverride());
        });
    }
}
