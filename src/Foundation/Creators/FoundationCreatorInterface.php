<?php

namespace StepUpDream\Blueprint\Foundation\Creators;

use StepUpDream\Blueprint\Foundation\Foundation;

/**
 * Interface FoundationCreatorInterface
 */
interface FoundationCreatorInterface
{
    /**
     * Execution of processing
     *
     * @param  \StepUpDream\Blueprint\Foundation\Foundation  $foundation
     */
    public function run(Foundation $foundation);
}
