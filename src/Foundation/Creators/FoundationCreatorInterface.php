<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Foundation\Creators;

use StepUpDream\Blueprint\Foundation\Foundation;

interface FoundationCreatorInterface
{
    /**
     * Execution of processing.
     *
     * @param  \StepUpDream\Blueprint\Foundation\Foundation  $foundation
     */
    public function run(Foundation $foundation);
}
