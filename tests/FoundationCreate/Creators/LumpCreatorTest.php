<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Test\FoundationCreate\Creators;

use Illuminate\Console\OutputStyle;
use Mockery;
use StepUpDream\Blueprint\Creator\Foundations\Lump;
use StepUpDream\Blueprint\Creator\LumpCreator;
use StepUpDream\Blueprint\Creator\Supports\File\FileOperation;
use StepUpDream\Blueprint\Creator\Supports\File\YamlFileOperation;
use StepUpDream\Blueprint\Creator\Supports\TextSupport;
use StepUpDream\Blueprint\Test\TestCase;
use StepUpDream\Blueprint\Test\ViewLoad;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;

class LumpCreatorTest extends TestCase
{
    /**
     * @test
     * @noinspection UsingInclusionReturnValueInspection
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
        $viewLoad = new ViewLoad($this->app);
        $viewLoad->run(__DIR__.'/../Mock/Resources');

        // test
        $foundation = app()->make(Lump::class, ['foundationConfig' => $foundationConfig]);
        $fileCreator = new FileOperation();
        $yamlReader = new YamlFileOperation();
        $textSupport = new TextSupport();
        $bufferedOutput = new BufferedOutput();
        $style = new OutputStyle(new ArrayInput([]), $bufferedOutput);
        $lumpCreatorMock = Mockery::mock(LumpCreator::class, [
            $fileCreator,
            $yamlReader,
            $textSupport,
        ])->makePartial();
        $lumpCreatorMock->allows('write')->andReturns();
        $lumpCreatorMock->setOutput($style)->run($foundation);

        // assertion
        $testResult = file_get_contents(__DIR__.'/../Result/Lump/sample.php');
        $expectedResult = file_get_contents(__DIR__.'/../Expected/Lump/sample.php');
        self::assertSame($expectedResult, $testResult);

        // end
        $this->resultReset();
    }
}
