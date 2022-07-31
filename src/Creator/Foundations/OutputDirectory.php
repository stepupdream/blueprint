<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Creator\Foundations;

trait OutputDirectory
{
    /**
     * @var string
     */
    protected string $outputDirectoryPath;

    /**
     * @var string
     */
    protected string $extension;

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
    protected string $convertClassNameType;

    /**
     * Get extension.
     *
     * @return string
     */
    public function extension(): string
    {
        return $this->extension;
    }

    /**
     * Get prefix.
     *
     * @return string
     */
    public function prefix(): string
    {
        return $this->prefix;
    }

    /**
     * Get suffix.
     *
     * @return string
     */
    public function suffix(): string
    {
        return $this->suffix;
    }

    /**
     * Get convertClassNameType.
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

    /**
     * Set output directory value.
     *
     * @param  mixed[]  $foundationConfig
     * @return void
     */
    protected function setOutputDirectory(array $foundationConfig): void
    {
        $this->outputDirectoryPath = (string) $foundationConfig['output_directory_path'];
        $this->extension = (string) $foundationConfig['extension'];
        $this->prefix = $foundationConfig['prefix'] ?? '';
        $this->suffix = $foundationConfig['suffix'] ?? '';
        $this->convertClassNameType = $foundationConfig['convert_class_name_type'] ?? '';
    }
}
