<?php

namespace StepUpDream\Blueprint\Foundation\Providers;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use StepUpDream\Blueprint\Foundation\Console\FoundationCreateCommand;

/**
 * Class FoundationCreateCommandServiceProvider
 *
 * @package StepUpDream\Blueprint\Foundation\Providers
 */
class FoundationCreateCommandServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register the service provider.
     */
    public function register(): void
    {
        if ($this->app->runningInConsole()) {
            $this->mergeConfigFrom(__DIR__.'/../Config/foundation.php', 'foundation');
            
            $this->loadViewsFrom(__DIR__.'/../../../resources', 'foundation');
            
            $this->publishes([
                __DIR__.'/../Config/foundation.php' => config_path('step_up_dream/foundation.php'),
            ]);
            $this->publishes([
                __DIR__.'/../../../resources' => $this->app->resourcePath('views/vendor/blueprint'),
            ], 'blueprint');
            
            $this->app->singleton('command.foundation_create_command', function () {
                return new FoundationCreateCommand();
            });
            
            $this->commands(['command.foundation_create_command']);
        }
    }
    
    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return ['command.foundation_create_command'];
    }
}
