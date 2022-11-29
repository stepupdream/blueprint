<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Test\FoundationCreate\Creators;

use Illuminate\Console\OutputStyle;
use Illuminate\Filesystem\Filesystem;
use Mockery;
use StepUpDream\Blueprint\Creator\Foundations\GroupLumpAddMethod;
use StepUpDream\Blueprint\Creator\GroupLumpAddMethodCreator;
use StepUpDream\Blueprint\Creator\Supports\File\FileOperation;
use StepUpDream\Blueprint\Creator\Supports\File\YamlFileOperation;
use StepUpDream\Blueprint\Creator\Supports\TextSupport;
use StepUpDream\Blueprint\Test\TestCase;
use StepUpDream\Blueprint\Test\ViewLoad;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;

class GroupLumpAddMethodTest extends TestCase
{
    /**
     * @test
     * @noinspection UsingInclusionReturnValueInspection
     */
    public function groupLumpAddMethod(): void
    {
        // initialize
        $this->resultReset();

        // config mock
        $configPath = __DIR__.'/../Config.php';
        $configMock = require $configPath;
        $foundationConfig = $configMock['foundations']['group_lump_add_method'];

        // load resources
        $viewLoad = new ViewLoad($this->app);
        $viewLoad->run(__DIR__.'/../Mock/Resources');

        // initialize
        $filesystem = new Filesystem();
        $filesystem->deleteDirectory(__DIR__.'/../Result/GroupLumpAddMethod', true);

        // test
        $foundation = app()->make(GroupLumpAddMethod::class, ['foundationConfig' => $foundationConfig]);
        $fileCreator = new FileOperation();
        $yamlReader = new YamlFileOperation();
        $textSupport = new TextSupport();
        $bufferedOutput = new BufferedOutput();
        $style = new OutputStyle(new ArrayInput([]), $bufferedOutput);
        $groupLumpAddMethodCreatorMock = Mockery::mock(GroupLumpAddMethodCreator::class, [
            $fileCreator,
            $yamlReader,
            $textSupport,
        ])->makePartial();
        $groupLumpAddMethodCreatorMock->allows('write')->andReturns();
        $groupLumpAddMethodCreatorMock->setOutput($style)->run($foundation);

        // assertion
        $testResult = file_get_contents(__DIR__.'/../Result/GroupLumpAddMethod/PrefixSampleGroup1Suffix.php');
        $expectedResult = file_get_contents(__DIR__.'/../Expected/GroupLumpAddMethod/PrefixSampleGroup1Suffix.php');
        self::assertSame($expectedResult, $testResult);
        $testResult = file_get_contents(__DIR__.'/../Result/GroupLumpAddMethod/PrefixSampleGroup2Suffix.php');
        $expectedResult = file_get_contents(__DIR__.'/../Expected/GroupLumpAddMethod/PrefixSampleGroup2Suffix.php');
        self::assertSame($expectedResult, $testResult);

        // end
        $this->resultReset();
    }
}
