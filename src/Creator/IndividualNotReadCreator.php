<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Creator;

use StepUpDream\Blueprint\Creator\Foundations\IndividualNotRead;

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
        $this->fileCreator->createFile($bladeFile, $classFilePath, $foundation->isOverride());
        $this->write($classFilePath, 'COMPLETE');
    }
}
