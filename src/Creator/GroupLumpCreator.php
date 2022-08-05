<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Creator;

use StepUpDream\Blueprint\Creator\Foundations\GroupLump;

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
        $yamlFiles = $this->yamlReader->readByDirectoryPath($foundation->readPath(), $foundation->exceptFileNames());
        $yamlFileCommon = $this->yamlReader->readByFileName($foundation->readPath(), $foundation->commonFileName());

        $yamlFilesGroups = collect($yamlFiles)->groupBy($foundation->groupKeyName())->toArray();
        foreach ($yamlFilesGroups as $groupKeyName => $yamlFilesGroup) {
            $fileName = $this->textSupport->convertName($foundation->convertClassNameType(), $groupKeyName);
            $classFilePath = $this->generateOutputFileFullPath($fileName, $foundation, []);
            $bladeFile = $this->readBladeFileLump($foundation, $classFilePath, $yamlFilesGroup, $yamlFileCommon);
            $this->fileCreator->createFile($bladeFile, $classFilePath, $foundation->isOverride());
            $this->write($classFilePath, 'COMPLETE');
        }
    }
}
