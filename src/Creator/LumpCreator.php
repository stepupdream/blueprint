<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Creator;

use StepUpDream\Blueprint\Creator\Foundations\Lump;

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
        $yamlFiles = $this->yamlReader->readByDirectoryPath($foundation->readPath(), $foundation->exceptFileNames());
        $yamlFileCommon = $this->yamlReader->readByFileName($foundation->readPath(), $foundation->commonFileName());
        $bladeFile = $this->readBladeFileLump($foundation, $foundation->outputPath(), $yamlFiles, $yamlFileCommon);
        $this->fileCreator->createFile($bladeFile, $foundation->outputPath(), $foundation->isOverride());
        $this->write($foundation->outputPath(), 'COMPLETE');
    }
}
