<?php

namespace StepUpDream\Blueprint\Foundation\Creators;

/**
 * Interface FoundationCreatorInterface
 *
 * @package StepUpDream\Blueprint\Foundation\Creators
 */
interface FoundationCreatorInterface
{
    /**
     * Execution of processing
     *
     * @param  array  $foundation
     */
    public function run(array $foundation);
}
