<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Creator\Console;

use Illuminate\Console\Command;

abstract class BaseCreateCommand extends Command
{
    /**
     * Create a new console command instance.
     */
    public function __construct()
    {
        ini_set('memory_limit', '2056M');

        parent::__construct();
    }

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
     */
    public function handle(): void
    {
        // Describe common command execution processing here.
    }
}
