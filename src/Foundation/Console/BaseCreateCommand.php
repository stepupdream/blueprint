<?php

namespace StepUpDream\Blueprint\Foundation\Console;

use Illuminate\Console\Command;

/**
 * Class BaseCreateCommand.
 */
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
}
