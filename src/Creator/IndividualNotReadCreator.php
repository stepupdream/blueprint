<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Creator;

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
        $bladeFile = $this->readBladeIndividual($foundation, $classFilePath, '', [], []);
        (new Task($this->output))->render($classFilePath, function () use ($bladeFile, $classFilePath, $foundation) {
            return $this->fileCreator->create($bladeFile, $classFilePath, $foundation->isOverride());
        });
    }
}
