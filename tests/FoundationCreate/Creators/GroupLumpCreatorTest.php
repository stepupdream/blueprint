<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Test\FoundationCreate\Creators;

use Illuminate\Console\OutputStyle;
use Mockery;
use StepUpDream\Blueprint\Creator\Foundations\GroupLump;
use StepUpDream\Blueprint\Creator\GroupLumpCreator;
use StepUpDream\Blueprint\Creator\Supports\File\FileOperation;
use StepUpDream\Blueprint\Creator\Supports\File\YamlFileOperation;
use StepUpDream\Blueprint\Creator\Supports\TextSupport;
use StepUpDream\Blueprint\Test\TestCase;
use StepUpDream\Blueprint\Test\ViewLoad;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;

class GroupLumpCreatorTest extends TestCase
{
    /**
     * @test
     * @noinspection UsingInclusionReturnValueInspection
     */
    public function groupLumpCreator(): void
    {
        // initialize
        $this->resultReset();

        // config mock
        $configPath = __DIR__.'/../Config.php';
        $configMock = require $configPath;
        $foundationConfig = $configMock['foundations']['group_lump'];

        // load resources
        $viewLoad = new ViewLoad($this->app);
        $viewLoad->run(__DIR__.'/../Mock/Resources');

        // test
        $foundation = app()->make(GroupLump::class, ['foundationConfig' => $foundationConfig]);
        $fileCreator = new FileOperation();
        $yamlReader = new YamlFileOperation();
        $textSupport = new TextSupport();
        $bufferedOutput = new BufferedOutput();
        $style = new OutputStyle(new ArrayInput([]), $bufferedOutput);
        $groupLumpCreatorMock = Mockery::mock(GroupLumpCreator::class, [
            $fileCreator,
            $yamlReader,
            $textSupport,
        ])->makePartial();
        $groupLumpCreatorMock->allows('write')->andReturns();
        $groupLumpCreatorMock->setOutput($style)->run($foundation);

        // assertion
        $testResult = file_get_contents(__DIR__.'/../Result/GroupLump/PrefixSampleGroup1Suffix.php');
        $expectedResult = file_get_contents(__DIR__.'/../Expected/GroupLump/PrefixSampleGroup1Suffix.php');
        self::assertSame($expectedResult, $testResult);
        $testResult2 = file_get_contents(__DIR__.'/../Result/GroupLump/PrefixSampleGroup2Suffix.php');
        $expectedResult2 = file_get_contents(__DIR__.'/../Expected/GroupLump/PrefixSampleGroup2Suffix.php');
        self::assertSame($expectedResult2, $testResult2);

        // end
        $this->resultReset();
    }
}
