<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Test\FoundationCreate\Creators;

use Mockery;
use StepUpDream\Blueprint\Creator\Foundations\Lump;
use StepUpDream\Blueprint\Creator\LumpCreator;
use StepUpDream\Blueprint\Creator\Supports\File\FileOperation;
use StepUpDream\Blueprint\Creator\Supports\File\YamlFileOperation;
use StepUpDream\Blueprint\Creator\Supports\TextSupport;
use StepUpDream\Blueprint\Test\TestCase;
use StepUpDream\Blueprint\Test\ViewLoadServiceProvider;

class LumpCreatorTest extends TestCase
{
    /**
     * @test
     */
    public function lumpCreator(): void
    {
        // initialize
        $this->resultReset();

        // config mock
        $configPath = __DIR__.'/../Config.php';
        $configMock = require $configPath;
        $foundationConfig = $configMock['foundations']['lump'];

        // load resources
        $mock = new ViewLoadServiceProvider($this->app);
        $mock->run();

        // test
        $foundation = app()->make(Lump::class, ['foundationConfig' => $foundationConfig]);
        $fileCreator = new FileOperation();
        $yamlReader = new YamlFileOperation();
        $textSupport = new TextSupport();
        $lumpCreatorMock = Mockery::mock(LumpCreator::class, [
            $fileCreator,
            $yamlReader,
            $textSupport,
        ])->makePartial();
        $lumpCreatorMock->allows('write')->andReturns();

        /** @var LumpCreator $lumpCreatorMock */
        $lumpCreatorMock->run($foundation);

        // assertion
        $testResult = file_get_contents(__DIR__.'/../Result/Lump/sample.php');
        $expectedResult = file_get_contents(__DIR__.'/../Expected/Lump/sample.php');
        self::assertSame($testResult, $expectedResult);

        // end
        $this->resultReset();
    }
}
