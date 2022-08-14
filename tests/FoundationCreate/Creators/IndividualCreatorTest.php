<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Test\FoundationCreate\Creators;

use Illuminate\Console\OutputStyle;
use Mockery;
use StepUpDream\Blueprint\Creator\Foundations\Individual;
use StepUpDream\Blueprint\Creator\IndividualCreator;
use StepUpDream\Blueprint\Creator\Supports\File\FileOperation;
use StepUpDream\Blueprint\Creator\Supports\File\YamlFileOperation;
use StepUpDream\Blueprint\Creator\Supports\TextSupport;
use StepUpDream\Blueprint\Test\TestCase;
use StepUpDream\Blueprint\Test\ViewLoadServiceProvider;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;

class IndividualCreatorTest extends TestCase
{
    /**
     * @test
     */
    public function individualCreator(): void
    {
        // initialize
        $this->resultReset();

        // config mock
        $configPath = __DIR__.'/../Config.php';
        $configMock = require $configPath;
        $foundationConfig = $configMock['foundations']['individual'];

        // load resources
        $mock = new ViewLoadServiceProvider($this->app);
        $mock->run();

        // test
        $foundation = app()->make(Individual::class, ['foundationConfig' => $foundationConfig]);
        $fileCreator = new FileOperation();
        $yamlReader = new YamlFileOperation();
        $textSupport = new TextSupport();
        $bufferedOutput = new BufferedOutput();
        $style = new OutputStyle(new ArrayInput([]), $bufferedOutput);
        $individualCreatorMock = Mockery::mock(IndividualCreator::class, [
            $fileCreator,
            $yamlReader,
            $textSupport,
        ])->makePartial();
        $individualCreatorMock->allows('write')->andReturns();
        $individualCreatorMock->setOutput($style)->run($foundation);

        // assertion
        $testResult = file_get_contents(__DIR__.'/../Result/Individual/PrefixSample2Suffix.php');
        $expectedResult = file_get_contents(__DIR__.'/../Expected/Individual/PrefixSample2Suffix.php');
        self::assertSame($testResult, $expectedResult);

        $testResult = file_get_contents(__DIR__.'/../Result/Individual/PrefixSample3Suffix.php');
        $expectedResult = file_get_contents(__DIR__.'/../Expected/Individual/PrefixSample3Suffix.php');
        self::assertSame($testResult, $expectedResult);

        // end
        $this->resultReset();
    }
}
