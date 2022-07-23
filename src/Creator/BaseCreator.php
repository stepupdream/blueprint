<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Creator;

use StepUpDream\Blueprint\Creator\Foundations\Base;
use StepUpDream\Blueprint\Creator\Foundations\OutputDirectory;
use StepUpDream\Blueprint\Creator\Supports\File\FileOperation;
use StepUpDream\Blueprint\Creator\Supports\File\YamlFileOperation;
use StepUpDream\Blueprint\Creator\Supports\TextSupport;

abstract class BaseCreator
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

        return view($foundation->templateBladeFile(), $arguments)->render();
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
        string $fileName = '',
        array $yamlFile = []
    ): array {
        return [
            'yamlCommonFile'        => $yamlFileCommon,
            'namespace'             => $this->textSupport->convertFileFullPathToNamespace($classFilePath),
            'className'             => pathinfo($classFilePath, PATHINFO_FILENAME),
            'extendsClassName'      => $foundation->extendsClassNameForBlade($fileName, $yamlFile),
            'useExtendsClass'       => $foundation->useExtendsClassForBlade($fileName, $yamlFile),
            'interfaceClassName'    => $foundation->interfaceClassNameForBlade($fileName, $yamlFile),
            'useInterfaceClass'     => $foundation->useInterfaceClassForBlade($fileName, $yamlFile),
            'requestDirectoryPath'  => $foundation->requestDirectoryPathForBlade($fileName, $yamlFile),
            'responseDirectoryPath' => $foundation->responseDirectoryPathForBlade($fileName, $yamlFile),
            'options'               => $foundation->optionsForBlade($fileName, $yamlFile),
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
        $arguments = $this->argumentsToView($foundation, $classFilePath, $yamlFileCommon);
        $arguments['yamlFiles'] = $yamlFiles;

        return view($foundation->templateBladeFile(), $arguments)->render();
    }

    /**
     * Generate the full path of the output file.
     *
     * @param  string  $fileName
     * @param  \StepUpDream\Blueprint\Creator\Foundations\OutputDirectory  $foundation
     * @param  mixed[]  $yamlFile
     * @return string
     */
    protected function generateOutputFileFullPath(
        string $fileName,
        OutputDirectory $foundation,
        array $yamlFile
    ): string {
        $outputDirectoryPath = $foundation->replacedOutputDirectoryPath($fileName, $yamlFile);
        $prefix = $foundation->prefix();
        $suffix = $foundation->suffix();
        $extension = $foundation->extension();

        return $outputDirectoryPath.DIRECTORY_SEPARATOR.$prefix.$fileName.$suffix.'.'.$extension;
    }
}