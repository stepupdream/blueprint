<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Test;

use Illuminate\Support\ServiceProvider;

class ViewLoadServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function run(): void
    {
        $this->loadViewsFrom(__DIR__.'/Mock/Resources', 'blueprint');
    }
}
