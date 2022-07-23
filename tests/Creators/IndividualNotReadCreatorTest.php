<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Test\Creators;

use StepUpDream\Blueprint\Creator\Foundations\IndividualNotRead;
use StepUpDream\Blueprint\Creator\IndividualNotReadCreator;
use StepUpDream\Blueprint\Test\TestCase;
use StepUpDream\Blueprint\Test\ViewLoadServiceProvider;

class IndividualNotReadCreatorTest extends TestCase
{
    /**
     * @test
     */
    public function individualNotReadCreator(): void
    {
        // initialize
        $this->resultReset();

        // config mock
        $configPath = __DIR__.'/../Config.php';
        $configMock = require $configPath;
        $foundationConfig = $configMock['foundations']['individual_not_read'];

        // load resources
        $mock = new ViewLoadServiceProvider($this->app);
        $mock->run();

        // test
        $foundation = app()->make(IndividualNotRead::class, ['foundationConfig' => $foundationConfig]);
        $lumpCreator = $this->app->make(IndividualNotReadCreator::class);
        $lumpCreator->run($foundation);

        // assertion
        $testResult = file_get_contents(__DIR__.'/../Result/IndividualNotRead/sample.php');
        $expectedResult = file_get_contents(__DIR__.'/../Expected/IndividualNotRead/sample.php');
        self::assertSame($testResult, $expectedResult);

        // end
        $this->resultReset();
    }
}
