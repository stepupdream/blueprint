<?php

namespace StepUpDream\Blueprint\Foundation\Creators;

use LogicException;
use StepUpDream\Blueprint\Foundation\Foundation;
use StepUpDream\Blueprint\Foundation\Supports\File\Creator;
use StepUpDream\Blueprint\Foundation\Supports\TextSupport;
use StepUpDream\Blueprint\Foundation\Supports\Yaml\Reader;

/**
 * Class BaseCreator.
 */
class BaseCreator
{
    /**
     * @var \StepUpDream\Blueprint\Foundation\Supports\File\Creator
     */
    protected $fileCreator;

    /**
     * @var \StepUpDream\Blueprint\Foundation\Supports\TextSupport
     */
    protected $textSupport;

    /**
     * @var \StepUpDream\Blueprint\Foundation\Supports\Yaml\Reader
     */
    protected $yamlReader;

    /**
     * BaseCreator constructor.
     *
     * @param  \StepUpDream\Blueprint\Foundation\Supports\File\Creator  $fileCreator
     * @param  \StepUpDream\Blueprint\Foundation\Supports\Yaml\Reader  $yamlReader
     * @param  \StepUpDream\Blueprint\Foundation\Supports\TextSupport  $textSupport
     */
    public function __construct(
        Creator $fileCreator,
        Reader $yamlReader,
        TextSupport $textSupport
    ) {
        $this->fileCreator = $fileCreator;
        $this->textSupport = $textSupport;
        $this->yamlReader = $yamlReader;
    }

    /**
     * Read blade file for Individual file.
     *
     * @param  \StepUpDream\Blueprint\Foundation\Foundation  $foundation
     * @param  string  $classFilePath
     * @param  string  $fileName
     * @param  array  $yamlFile
     * @param  array  $yamlFileCommon
     * @return string
     */
    protected function readBladeFileIndividual(
        Foundation $foundation,
        string $classFilePath,
        string $fileName,
        array $yamlFile,
        array $yamlFileCommon
    ): string {
        $arguments = $this->argumentsToView($foundation, $classFilePath, $yamlFileCommon, $fileName, $yamlFile);
        $arguments['yaml'] = $yamlFile;

        return view($foundation->templateBladeFile(), $arguments)->render();
    }

    /**
     * Read blade file for add template file.
     *
     * @param  \StepUpDream\Blueprint\Foundation\Foundation  $foundation
     * @param  string  $classFilePath
     * @param  string  $fileName
     * @param  array  $yamlFile
     * @param  array  $yamlFileCommon
     * @return string
     */
    protected function readBladeFileAddTemplate(
        Foundation $foundation,
        string $classFilePath,
        string $fileName,
        array $yamlFile,
        array $yamlFileCommon
    ): string {
        $arguments = $this->argumentsToView($foundation, $classFilePath, $yamlFileCommon, $fileName, $yamlFile);
        $arguments['yaml'] = $yamlFile;

        return view($foundation->addTemplateBladeFile(), $arguments)->render();
    }

    /**
     * Read blade file.
     *
     * @param  \StepUpDream\Blueprint\Foundation\Foundation  $foundation
     * @param  string  $classFilePath
     * @param  array  $yamlFiles
     * @param  array  $yamlFileCommon
     * @return string
     */
    protected function readBladeFileLump(
        Foundation $foundation,
        string $classFilePath,
        array $yamlFiles,
        array $yamlFileCommon
    ): string {
        $arguments = $this->argumentsToView($foundation, $classFilePath, $yamlFileCommon);
        $arguments['yamls'] = $yamlFiles;

        return view($foundation->templateBladeFile(), $arguments)->render();
    }

    /**
     * Arguments to view.
     *
     * @param  \StepUpDream\Blueprint\Foundation\Foundation  $foundation
     * @param  string  $classFilePath
     * @param  string  $fileName
     * @param  array  $yamlFile
     * @param  array  $yamlFileCommon
     * @return array
     */
    protected function argumentsToView(
        Foundation $foundation,
        string $classFilePath,
        array $yamlFileCommon,
        string $fileName = '',
        array $yamlFile = []
    ): array {
        return [
            'yamlCommon'            => $yamlFileCommon,
            'namespace'             => $this->textSupport->convertFileFullPathToNamespace($classFilePath),
            'className'             => basename($classFilePath, '.'.$foundation->extension()),
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
     * Verify if there is a required key.
     *
     * @param  \StepUpDream\Blueprint\Foundation\Foundation  $foundation
     * @param  array  $requiredKeys
     */
    protected function verifyKeys(Foundation $foundation, array $requiredKeys): void
    {
        $foundationArray = $foundation->toArray();
        foreach ($requiredKeys as $requiredKey) {
            if (! array_key_exists($requiredKey, $foundationArray) || $foundation->{$requiredKey}() === '') {
                throw new LogicException($requiredKey.': Check if the specified key is correct');
            }
        }
    }

    /**
     * Generate the full path of the output file.
     *
     * @param  string  $fileName
     * @param  \StepUpDream\Blueprint\Foundation\Foundation  $foundation
     * @param  array  $yamlFile
     * @return string
     */
    protected function generateOutputFileFullPath(string $fileName, Foundation $foundation, array $yamlFile): string
    {
        $outputDirectoryPath = $foundation->replacedOutputDirectoryPath($fileName, $yamlFile);
        $prefix = $foundation->prefix();
        $suffix = $foundation->suffix();
        $extension = $foundation->extension();

        return $outputDirectoryPath.DIRECTORY_SEPARATOR.$prefix.$fileName.$suffix.'.'.$extension;
    }
}
