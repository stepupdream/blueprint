<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Creator\Foundations;

interface OutputDirectoryInterface
{
    /**
     * Get extension
     *
     * @return string
     */
    public function extension(): string;

    /**
     * Get prefix
     *
     * @return string
     */
    public function prefix(): string;

    /**
     * Get suffix
     *
     * @return string
     */
    public function suffix(): string;

    /**
     * Get convertClassNameType
     *
     * @return string
     */
    public function convertClassNameType(): string;

    /**
     * Replaced output directory path.
     *
     * @param  mixed[]  $yamlFile
     * @param  string  $fileName
     * @return string
     */
    public function replacedOutputDirectoryPath(string $fileName, array $yamlFile): string;

    /**
     * Replace key for replacement.
     *
     * @param  string  $fileName
     * @param  string  $value
     * @param  mixed  $yamlFile
     * @return string
     */
    public function replaceForBlade(string $fileName, string $value, mixed $yamlFile): string;
}
