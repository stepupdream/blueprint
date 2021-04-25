<?php

namespace StepUpDream\Blueprint\Test;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use ReflectionClass;

/**
 * Class TestCase
 *
 * @package StepUpDream\Blueprint\Test
 */
abstract class TestCase extends OrchestraTestCase
{
    /**
     * Execute private function test
     *
     * @param $class
     * @param  string  $methodName
     * @param  array  $argument
     * @return mixed
     * @throws \ReflectionException
     */
    protected function executePrivateFunction($class, string $methodName, array $argument)
    {
        $reflection = new ReflectionClass($class);
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);
        
        return $method->invokeArgs($class, $argument);
    }
}
