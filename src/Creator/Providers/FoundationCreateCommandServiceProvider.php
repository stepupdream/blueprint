<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Creator\Providers;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use StepUpDream\Blueprint\Creator\Console\FoundationCreateCommand;

class FoundationCreateCommandServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * The commands to be registered.
     *
     * @var string[]
     */
    protected array $commands = [
        'BlueprintCreateCommand' => 'blueprint.create.command',
    ];

    /**
     * Register the service provider.
     */
    public function register(): void
    {
        if ($this->app->runningInConsole()) {
            $this->mergeConfigFrom(__DIR__.'/../Config/stepupdream/blueprint.php', 'stepupdream.blueprint');

            $this->loadViewsFrom(__DIR__.'/../../../resources', 'blueprint');

            $this->publishes([
                __DIR__.'/../Config/stepupdream/blueprint.php' => config_path('stepupdream/blueprint.php'),
                __DIR__.'/../../../resources' => $this->app->resourcePath('views/vendor/blueprint'),
            ], 'blueprint');

            $this->app->singleton('blueprint.create.command', function () {
                return new FoundationCreateCommand();
            });

            $this->commands(array_values($this->commands));
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return mixed[]
     */
    public function provides(): array
    {
        return array_values($this->commands);
    }
}
