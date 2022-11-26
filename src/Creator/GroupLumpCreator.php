<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Creator;

use Illuminate\Contracts\View\Factory;
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
            $outputDirectoryPath = $foundation->replaceAtSign($fileName, $foundation->outputDirectoryPath(), '');
            $classFilePath = $foundation->outputFileFullPath($fileName, $outputDirectoryPath);
            $newFileName = pathinfo($classFilePath, PATHINFO_FILENAME);
            $yamlFileCommon = $this->yamlReader->readByFileName($foundation->readPath(), $foundation->commonFileName());
            $yamlFile = array_values($yamlFilesGroup)[0];
            $renderText = [];
            $renderText['yamlFile'] = $yamlFile;
            $renderText['yamlCommonFile'] = $yamlFileCommon;
            $renderText['namespace'] = $this->textSupport->convertFileFullPathToNamespace($classFilePath);
            $renderText['className'] = pathinfo($classFilePath, PATHINFO_FILENAME);
            $renderText['options'] = $foundation->optionsForBlade($newFileName, $yamlFile);
            $renderText['yamlFiles'] = $yamlFilesGroup;
            $bladeFile = app(Factory::class)->make($foundation->templateBladeFile(), $renderText)->render();

            $task->render(
                $classFilePath,
                fn () => $this->fileCreator->create($bladeFile, $classFilePath, $foundation->isOverride())
            );
        }
    }
}
