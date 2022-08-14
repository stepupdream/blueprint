<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Creator;

use StepUpDream\Blueprint\Creator\Foundations\Individual;
use StepUpDream\SpreadSheetConverter\DefinitionDocument\Supports\Task;

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
        $task = new Task($this->output);
        $yamlFiles = $this->yamlReader->readByDirectoryPath($foundation->readPath(), $foundation->exceptFileNames());

        if (empty($yamlFiles)) {
            $task->render('No file to load : '.$foundation->readPath(), fn () => 'ERROR');
        }

        foreach ($yamlFiles as $filePath => $yamlFile) {
            $fileName = basename($filePath, '.yml');
            $fileName = $this->textSupport->convertName($foundation->convertClassNameType(), $fileName);
            $classFilePath = $this->generateOutputFileFullPath($fileName, $foundation, $yamlFile);
            $yamlFileCommon = $this->yamlReader->readByFileName($foundation->readPath(), $foundation->commonFileName());
            $bladeFile = $this->readBladeIndividual($foundation, $classFilePath, $fileName, $yamlFile, $yamlFileCommon);

            $task->render(
                $classFilePath,
                fn () => $this->fileCreator->create($bladeFile, $classFilePath, $foundation->isOverride())
            );
        }
    }
}
