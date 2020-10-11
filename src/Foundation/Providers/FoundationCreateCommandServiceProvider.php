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
    public function register()
    {
        if ($this->app->runningInConsole()) {
            $this->mergeConfigFrom(__DIR__ . '/../config/foundation.php', 'foundation');
            
            $this->loadViewsFrom(__DIR__ . '/../../../resources', 'foundation');
            
            $this->publishes([
                __DIR__ . '/../../../resources' => $this->app->resourcePath('views/vendor/foundation'),
            ], 'foundation');
            
            $this->app->singleton('command.foundation_create_command', function () {
                return new FoundationCreateCommand();
            });
            
            $this->commands(['command.foundation_create_command']);
        }
    }
    
    /**
     * Get the services provided by the provider.
     */
    public function provides()
    {
        return ['command.foundation_create_command'];
    }
}
