<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Foundation\Creators;

use StepUpDream\Blueprint\Foundation\Foundation;

class IndividualFileCreator extends BaseCreator implements FoundationCreatorInterface
{
    /**
     * Execution of processing.
     *
     * Output the file according to the read yaml file.
     *
     * @param  \StepUpDream\Blueprint\Foundation\Foundation  $foundation
     */
    public function run(Foundation $foundation): void
    {
        $requiredKey = ['readPath', 'outputDirectoryPath', 'extension', 'templateBladeFile', 'isOverride'];
        $this->verifyKeys($foundation, $requiredKey);
        $yamlFiles = $this->yamlReader->readByDirectoryPath($foundation->readPath(), $foundation->exceptFileNames());
        $yamlFileCommon = $this->yamlReader->readFileByFileName($foundation->readPath(), $foundation->commonFileName());

        foreach ($yamlFiles as $filePath => $yamlFile) {
            $fileName = basename($filePath, '.yml');

            $fileName = $this->textSupport->convertName($foundation->convertClassNameType(), $fileName);
            $classFilePath = $this->generateOutputFileFullPath($fileName, $foundation, $yamlFile);
            $bladeFile = $this->readBladeIndividual($foundation, $classFilePath, $fileName, $yamlFile, $yamlFileCommon);
            $this->fileCreator->createFile($bladeFile, $classFilePath, $foundation->isOverride());
        }
    }
}
