<?php

namespace StepUpDream\Blueprint\Foundation\Creators;

use StepUpDream\Blueprint\Foundation\Foundation;

/**
 * Class IndividualFileCreatorWithoutRead
 */
class IndividualFileCreatorWithoutRead extends BaseCreator implements FoundationCreatorInterface
{
    /**
     * Execution of processing
     *
     * Output the contents of blade as a file regardless of the contents of Yaml file
     *
     * @param  \StepUpDream\Blueprint\Foundation\Foundation  $foundation
     */
    public function run(Foundation $foundation): void
    {
        $requiredKey = ['outputPath', 'extension', 'templateBladeFile', 'isOverride'];
        $this->verifyKeys($foundation, $requiredKey);
        $classFilePath = $foundation->outputPath();
        $bladeFile = $this->readBladeFileIndividual($foundation, $classFilePath, '', [], []);
        $this->fileCreator->createFile($bladeFile, $classFilePath, $foundation->isOverride());
    }
}
