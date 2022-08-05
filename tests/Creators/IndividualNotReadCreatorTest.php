<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Test\Creators;

use Mockery;
use StepUpDream\Blueprint\Creator\Foundations\IndividualNotRead;
use StepUpDream\Blueprint\Creator\IndividualNotReadCreator;
use StepUpDream\Blueprint\Creator\Supports\File\FileOperation;
use StepUpDream\Blueprint\Creator\Supports\File\YamlFileOperation;
use StepUpDream\Blueprint\Creator\Supports\TextSupport;
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
        $fileCreator = new FileOperation();
        $yamlReader = new YamlFileOperation();
        $textSupport = new TextSupport();
        $individualNotReadCreatorMock = Mockery::mock(IndividualNotReadCreator::class, [
            $fileCreator,
            $yamlReader,
            $textSupport,
        ])->makePartial();
        $individualNotReadCreatorMock->allows('write')->andReturns();

        /** @var IndividualNotReadCreator $individualNotReadCreatorMock */
        $individualNotReadCreatorMock->run($foundation);

        // assertion
        $testResult = file_get_contents(__DIR__.'/../Result/IndividualNotRead/sample.php');
        $expectedResult = file_get_contents(__DIR__.'/../Expected/IndividualNotRead/sample.php');
        self::assertSame($testResult, $expectedResult);

        // end
        $this->resultReset();
    }
}
