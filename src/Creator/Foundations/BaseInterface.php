<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Creator\Foundations;

interface BaseInterface
{
    /**
     * Options for blade.
     *
     * @param  string  $fileName
     * @param  mixed  $yamlFile
     * @return mixed[]
     */
    public function optionsForBlade(string $fileName, mixed $yamlFile): array;
}
