<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Test\Creators;

use Illuminate\Filesystem\Filesystem;
use StepUpDream\Blueprint\Creator\Foundations\Lump;
use StepUpDream\Blueprint\Creator\LumpCreator;
use StepUpDream\Blueprint\Test\TestCase;
use StepUpDream\Blueprint\Test\ViewLoadServiceProvider;

class LumpCreatorTest extends TestCase
{
    /**
     * @test
     */
    public function lumpCreator(): void
    {
        // config mock
        $configPath = __DIR__.'/../Config.php';
        $configMock = require $configPath;
        $foundationConfig = $configMock['foundations']['lump'];

        // load resources
        $mock = new ViewLoadServiceProvider($this->app);
        $mock->run();

        // initialize
        $filesystem = new Filesystem();
        $filesystem->deleteDirectory(__DIR__.'/../Result/Lump', true);

        // test
        $foundation = app()->make(Lump::class, ['foundationConfig' => $foundationConfig]);
        $lumpCreator = $this->app->make(LumpCreator::class);
        $lumpCreator->run($foundation);

        // assertion
        $testResult = file_get_contents(__DIR__.'/../Result/Lump/sample.php');
        $expectedResult = file_get_contents(__DIR__.'/../Expected/Lump/sample.php');
        self::assertSame($testResult, $expectedResult);
    }
}
