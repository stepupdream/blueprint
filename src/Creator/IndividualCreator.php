<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Creator;

use StepUpDream\Blueprint\Creator\Foundations\Individual;

class IndividualCreator extends BaseCreator
{
    /**
     * Execution of processing.
     *
     * Output the file according to the read yaml file.
     *
     * @param  \StepUpDream\Blueprint\Creator\Foundations\Individual  $foundation
     */
    public function run(Individual $foundation): void
    {
        $yamlFiles = $this->yamlReader->readByDirectoryPath($foundation->readPath(), $foundation->exceptFileNames());
        $yamlFileCommon = $this->yamlReader->readByFileName($foundation->readPath(), $foundation->commonFileName());

        foreach ($yamlFiles as $filePath => $yamlFile) {
            $fileName = basename($filePath, '.yml');

            $fileName = $this->textSupport->convertName($foundation->convertClassNameType(), $fileName);
            $classFilePath = $this->generateOutputFileFullPath($fileName, $foundation, $yamlFile);
            $bladeFile = $this->readBladeIndividual($foundation, $classFilePath, $fileName, $yamlFile, $yamlFileCommon);
            $this->fileCreator->createFile($bladeFile, $classFilePath, $foundation->isOverride());
            $this->write($classFilePath, 'COMPLETE');
        }
    }
}
