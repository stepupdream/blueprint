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
     * Output file full path.
     *
     * The argument is the directory path to be sent after the substitution.
     *
     * @param  string  $fileName
     * @param  string  $newOutputDirectoryPath
     * @return string
     * @see \StepUpDream\Blueprint\Creator\Foundations\Base::replaceAtSign
     */
    public function outputFileFullPath(string $fileName, string $newOutputDirectoryPath): string
    {
        $prefix = $this->prefix();
        $suffix = $this->suffix();
        $extension = $this->extension();

        return $newOutputDirectoryPath.DIRECTORY_SEPARATOR.$prefix.$fileName.$suffix.'.'.$extension;
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

    /**
     * Get outputDirectoryPath.
     *
     * @return string
     */
    public function outputDirectoryPath(): string
    {
        return $this->outputDirectoryPath;
    }
}
