<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Creator\Foundations;

interface NeedReadYamlInterface
{
    /**
     * Get groupKeyName.
     *
     * @return string
     */
    public function groupKeyName(): string;

    /**
     * Get readPath.
     *
     * @return string
     */
    public function readPath(): string;

    /**
     * Get exceptFileNames.
     *
     * @return string[]
     */
    public function exceptFileNames(): array;

    /**
     * Get commonFileName.
     *
     * @return string
     */
    public function commonFileName(): string;

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
