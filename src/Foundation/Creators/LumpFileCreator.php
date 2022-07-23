<?php

namespace StepUpDream\Blueprint\Foundation\Creators;

use StepUpDream\Blueprint\Foundation\Foundation;

/**
 * Class LumpFileCreator.
 */
class LumpFileCreator extends BaseCreator implements FoundationCreatorInterface
{
    /**
     * Execution of processing.
     *
     * Combine the contents of the read Yaml into one file.
     *
     * @param  \StepUpDream\Blueprint\Foundation\Foundation  $foundation
     * @see \StepUpDream\Blueprint\Foundation\Console\FoundationCreateCommand::handle()
     */
    public function run(Foundation $foundation): void
    {
        $requiredKey = ['readPath', 'outputPath', 'extension', 'templateBladeFile', 'isOverride'];
        $this->verifyKeys($foundation, $requiredKey);
        $yamlFiles = $this->yamlReader->readFileByDirectoryPath($foundation->readPath(), $foundation->exceptFileNames());
        $yamlFileCommon = $this->yamlReader->readFileByFileName($foundation->readPath(), $foundation->commonFileName());
        $bladeFile = $this->readBladeFileLump($foundation, $foundation->outputPath(), $yamlFiles, $yamlFileCommon);
        $this->fileCreator->createFile($bladeFile, $foundation->outputPath(), $foundation->isOverride());
    }
}
