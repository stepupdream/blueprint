<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Creator;

use StepUpDream\Blueprint\Creator\Foundations\GroupLump;
use StepUpDream\SpreadSheetConverter\DefinitionDocument\Supports\Task;

class GroupLumpCreator extends BaseCreator
{
    /**
     * Execution of processing.
     *
     * Output the read yaml contents as a group
     *
     * @param  \StepUpDream\Blueprint\Creator\Foundations\GroupLump  $foundation
     */
    public function run(GroupLump $foundation): void
    {
        $task = new Task($this->output);
        $yamlFiles = $this->yamlReader->readByDirectoryPath($foundation->readPath(), $foundation->exceptFileNames());
        $yamlFilesGroups = collect($yamlFiles)->groupBy($foundation->groupKeyName())->toArray();

        if (empty($yamlFilesGroups)) {
            $task->render('No file to load : '.$foundation->readPath(), fn () => 'ERROR');
        }

        foreach ($yamlFilesGroups as $groupKeyName => $yamlFilesGroup) {
            $fileName = $this->textSupport->convertName($foundation->convertClassNameType(), $groupKeyName);
            $classFilePath = $this->generateOutputFileFullPath($fileName, $foundation, []);
            $yamlFileCommon = $this->yamlReader->readByFileName($foundation->readPath(), $foundation->commonFileName());
            $bladeFile = $this->readBladeFileLump($foundation, $classFilePath, $yamlFilesGroup, $yamlFileCommon);
            $task->render(
                $classFilePath,
                fn () => $this->fileCreator->create($bladeFile, $classFilePath, $foundation->isOverride())
            );
        }
    }
}
