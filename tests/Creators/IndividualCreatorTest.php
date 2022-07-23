<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Test\Creators;

use Illuminate\Filesystem\Filesystem;
use StepUpDream\Blueprint\Creator\Foundations\Individual;
use StepUpDream\Blueprint\Creator\IndividualCreator;
use StepUpDream\Blueprint\Test\TestCase;
use StepUpDream\Blueprint\Test\ViewLoadServiceProvider;

class IndividualCreatorTest extends TestCase
{
    /**
     * @test
     */
    public function individualCreator(): void
    {
        // config mock
        $configPath = __DIR__.'/../Config.php';
        $configMock = require $configPath;
        $foundationConfig = $configMock['foundations']['individual'];

        // load resources
        $mock = new ViewLoadServiceProvider($this->app);
        $mock->run();

        // initialize
        $filesystem = new Filesystem();
        $filesystem->deleteDirectory(__DIR__.'/../Result/Individual', true);

        // test
        $foundation = app()->make(Individual::class, ['foundationConfig' => $foundationConfig]);
        $individualCreator = $this->app->make(IndividualCreator::class);
        $individualCreator->run($foundation);

        // assertion
        $testResult = file_get_contents(__DIR__.'/../Result/Individual/PrefixCharacterSuffix.php');
        $expectedResult = file_get_contents(__DIR__.'/../Expected/Individual/PrefixCharacterSuffix.php');
        self::assertSame($testResult, $expectedResult);
    }
}
