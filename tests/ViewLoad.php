<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Test;

use Illuminate\Contracts\Foundation\Application;

class ViewLoad
{
    /**
     * Create a new service provider instance.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     */
    public function __construct(protected Application $app)
    {
    }

    /**
     * @param  string  $directoryPath
     * @return void
     */
    public function run(string $directoryPath): void
    {
        $this->loadViewsFrom($directoryPath, 'blueprint');
    }

    /**
     * Set up an after resolving listener, or fire immediately if already resolved.
     *
     * @param  string  $name
     * @param  callable  $callback
     * @return void
     *
     * @see \Illuminate\Support\ServiceProvider::callAfterResolving()
     */
    protected function callAfterResolving(string $name, callable $callback): void
    {
        $this->app->afterResolving($name, $callback);

        if ($this->app->resolved($name)) {
            $callback($this->app->make($name), $this->app);
        }
    }

    /**
     * Register a view file namespace.
     *
     * @param  string  $path
     * @param  string  $namespace
     * @return void
     *
     * @see \Illuminate\Support\ServiceProvider::loadViewsFrom()
     */
    protected function loadViewsFrom(string $path, string $namespace): void
    {
        $this->callAfterResolving('view', function ($view) use ($path, $namespace) {
            if (isset($this->app->config['view']['paths']) &&
                is_array($this->app->config['view']['paths'])) {
                foreach ($this->app->config['view']['paths'] as $viewPath) {
                    if (is_dir($appPath = $viewPath.'/vendor/'.$namespace)) {
                        $view->addNamespace($namespace, $appPath);
                    }
                }
            }

            $view->addNamespace($namespace, $path);
        });
    }
}
