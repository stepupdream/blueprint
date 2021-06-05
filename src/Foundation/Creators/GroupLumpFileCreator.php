<?php

namespace StepUpDream\Blueprint\Foundation\Creators;

use StepUpDream\Blueprint\Foundation\Foundation;

/**
 * Class GroupLumpFileCreator.
 */
class GroupLumpFileCreator extends BaseCreator implements FoundationCreatorInterface
{
    /**
     * Execution of processing.
     *
     * Output the read yaml contents as a group
     *
     * @param  \StepUpDream\Blueprint\Foundation\Foundation  $foundation
     */
    public function run(Foundation $foundation): void
    {
        $requiredKey = [
            'readPath', 'outputDirectoryPath', 'groupKeyName', 'extension', 'templateBladeFile', 'isOverride',
        ];
        $this->verifyKeys($foundation, $requiredKey);
        $yamlFiles = $this->yamlReader->readFileByDirectoryPath($foundation->readPath(), $foundation->exceptFileNames());
        $yamlFileCommon = $this->yamlReader->readFileByFileName($foundation->readPath(), $foundation->commonFileName());

        $yamlFilesGroups = collect($yamlFiles)->groupBy($foundation->groupKeyName())->toArray();
        foreach ($yamlFilesGroups as $groupKeyName => $yamlFilesGroup) {
            $fileName = $this->textSupport->convertNameByConvertType($foundation->convertClassNameType(), $groupKeyName);
            $classFilePath = $this->generateOutputFileFullPath($fileName, $foundation, []);
            $bladeFile = $this->readBladeFileLump($foundation, $classFilePath, $yamlFilesGroup, $yamlFileCommon);
            $this->fileCreator->createFile($bladeFile, $classFilePath, $foundation->isOverride());
        }
    }
}
