<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Creator\Foundations;

use StepUpDream\Blueprint\Creator\Supports\TextSupport;

abstract class OutputDirectory extends Base
{
    /**
     * @var string
     */
    protected string $readPath;

    /**
     * @var string
     */
    protected string $outputDirectoryPath;

    /**
     * @var string
     */
    protected string $extension;

    /**
     * @var string[]
     */
    protected array $exceptFileNames;

    /**
     * @var string
     */
    protected string $prefix;

    /**
     * @var string
     */
    protected string $suffix;

    /**
     * @var string
     */
    protected string $commonFileName;

    /**
     * @var string
     */
    protected string $convertClassNameType;

    /**
     * OutputDirectoryCommon constructor.
     *
     * @param  mixed[]  $foundationConfig
     * @param  \StepUpDream\Blueprint\Creator\Supports\TextSupport  $textSupport
     */
    public function __construct(
        array $foundationConfig,
        TextSupport $textSupport
    ) {
        parent::__construct($foundationConfig, $textSupport);

        $this->readPath = (string) $foundationConfig['read_path'];
        $this->outputDirectoryPath = (string) $foundationConfig['output_directory_path'];
        $this->extension = (string) $foundationConfig['extension'];
        $this->exceptFileNames = $foundationConfig['except_file_names'] ?? [];
        $this->prefix = $foundationConfig['prefix'] ?? '';
        $this->suffix = $foundationConfig['suffix'] ?? '';
        $this->commonFileName = $foundationConfig['common_file_name'] ?? '';
        $this->convertClassNameType = $foundationConfig['convert_class_name_type'] ?? '';
    }

    /**
     * Get readPath
     *
     * @return string
     */
    public function readPath(): string
    {
        return $this->readPath;
    }

    /**
     * Get exceptFileNames
     *
     * @return string[]
     */
    public function exceptFileNames(): array
    {
        return $this->exceptFileNames;
    }

    /**
     * Get extension
     *
     * @return string
     */
    public function extension(): string
    {
        return $this->extension;
    }

    /**
     * Get prefix
     *
     * @return string
     */
    public function prefix(): string
    {
        return $this->prefix;
    }

    /**
     * Get suffix
     *
     * @return string
     */
    public function suffix(): string
    {
        return $this->suffix;
    }

    /**
     * Get commonFileName
     *
     * @return string
     */
    public function commonFileName(): string
    {
        return $this->commonFileName;
    }

    /**
     * Get convertClassNameType
     *
     * @return string
     */
    public function convertClassNameType(): string
    {
        return $this->convertClassNameType;
    }

    /**
     * Replaced output directory path.
     *
     * @param  mixed[]  $yamlFile
     * @param  string  $fileName
     * @return string
     */
    public function replacedOutputDirectoryPath(string $fileName, array $yamlFile): string
    {
        return $this->replaceForBlade($fileName, $this->outputDirectoryPath, $yamlFile);
    }
}
