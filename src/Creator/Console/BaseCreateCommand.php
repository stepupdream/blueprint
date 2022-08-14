<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Creator\Console;

use StepUpDream\SpreadSheetConverter\DefinitionDocument\Console\BaseCreateCommand as BaseCommand;

abstract class BaseCreateCommand extends BaseCommand
{
    /**
     * Whether it is a multidimensional array.
     *
     * @param  mixed[]  $array
     * @return bool
     */
    protected function isMultidimensional(array $array): bool
    {
        return count($array) !== count($array, 1);
    }

    /**
     * Run method in order.
     *
     * Describe common command execution processing here.
     */
    public function handle(): void
    {
        $this->commandDetailLog();
    }
}
