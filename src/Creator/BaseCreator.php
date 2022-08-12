<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Creator;

use Illuminate\Contracts\View\Factory;
use StepUpDream\Blueprint\Creator\Foundations\Base;
use StepUpDream\Blueprint\Creator\Foundations\OutputDirectoryInterface;
use StepUpDream\Blueprint\Creator\Supports\File\FileOperation;
use StepUpDream\Blueprint\Creator\Supports\File\YamlFileOperation;
use StepUpDream\Blueprint\Creator\Supports\TextSupport;
use StepUpDream\SpreadSheetConverter\DefinitionDocument\Supports\LineMessage;

abstract class BaseCreator extends LineMessage
{
    /**
     * BaseCreator constructor.
     *
     * @param  \StepUpDream\Blueprint\Creator\Supports\File\FileOperation  $fileCreator
     * @param  \StepUpDream\Blueprint\Creator\Supports\File\YamlFileOperation  $yamlReader
     * @param  \StepUpDream\Blueprint\Creator\Supports\TextSupport  $textSupport
     */
    public function __construct(
        protected FileOperation $fileCreator,
        protected YamlFileOperation $yamlReader,
        protected TextSupport $textSupport
    ) {
    }

    /**
     * Read blade file for Individual file.
     *
     * @param  \StepUpDream\Blueprint\Creator\Foundations\Base  $foundation
     * @param  string  $classFilePath
     * @param  string  $fileName
     * @param  mixed[]  $yamlFile
     * @param  mixed[]  $yamlFileCommon
     * @return string
     */
    protected function readBladeIndividual(
        Base $foundation,
        string $classFilePath,
        string $fileName,
        array $yamlFile,
        array $yamlFileCommon
    ): string {
        $arguments = $this->argumentsToView($foundation, $classFilePath, $yamlFileCommon, $fileName, $yamlFile);
        $arguments['yamlFile'] = $yamlFile;

        return app(Factory::class)->make($foundation->templateBladeFile(), $arguments)->render();
    }

    /**
     * Arguments to view.
     *
     * @param  \StepUpDream\Blueprint\Creator\Foundations\Base  $foundation
     * @param  string  $classFilePath
     * @param  string  $fileName
     * @param  mixed[]  $yamlFile
     * @param  mixed[]  $yamlFileCommon
     * @return mixed[]
     */
    protected function argumentsToView(
        Base $foundation,
        string $classFilePath,
        array $yamlFileCommon,
        string $fileName,
        array $yamlFile
    ): array {
        return [
            'yamlCommonFile' => $yamlFileCommon,
            'namespace'      => $this->textSupport->convertFileFullPathToNamespace($classFilePath),
            'className'      => pathinfo($classFilePath, PATHINFO_FILENAME),
            'options'        => $foundation->optionsForBlade($fileName, $yamlFile),
        ];
    }

    /**
     * Read blade file.
     *
     * @param  \StepUpDream\Blueprint\Creator\Foundations\Base  $foundation
     * @param  string  $classFilePath
     * @param  mixed[]  $yamlFiles
     * @param  mixed[]  $yamlFileCommon
     * @return string
     */
    protected function readBladeFileLump(
        Base $foundation,
        string $classFilePath,
        array $yamlFiles,
        array $yamlFileCommon
    ): string {
        $fileName = pathinfo($classFilePath, PATHINFO_FILENAME);
        $yamlFile = array_values($yamlFiles)[0];
        $arguments = $this->argumentsToView($foundation, $classFilePath, $yamlFileCommon, $fileName, $yamlFile);
        $arguments['yamlFiles'] = $yamlFiles;

        return app(Factory::class)->make($foundation->templateBladeFile(), $arguments)->render();
    }

    /**
     * Generate the full path of the output file.
     *
     * @param  string  $fileName
     * @param  \StepUpDream\Blueprint\Creator\Foundations\OutputDirectoryInterface  $foundation
     * @param  mixed[]  $yamlFile
     * @return string
     */
    protected function generateOutputFileFullPath(
        string $fileName,
        OutputDirectoryInterface $foundation,
        array $yamlFile
    ): string {
        $outputDirectoryPath = $foundation->replacedOutputDirectoryPath($fileName, $yamlFile);
        $prefix = $foundation->prefix();
        $suffix = $foundation->suffix();
        $extension = $foundation->extension();

        return $outputDirectoryPath.DIRECTORY_SEPARATOR.$prefix.$fileName.$suffix.'.'.$extension;
    }
}
