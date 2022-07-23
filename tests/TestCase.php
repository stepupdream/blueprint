<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Test;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use ReflectionClass;

abstract class TestCase extends OrchestraTestCase
{
    /**
     * Execute private function test.
     *
     * @param $class
     * @param  string  $methodName
     * @param  array  $arguments
     * @return mixed
     */
    protected function executePrivateFunction($class, string $methodName, array $arguments = []): mixed
    {
        $reflection = new ReflectionClass($class);
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($class, $arguments);
    }
}
