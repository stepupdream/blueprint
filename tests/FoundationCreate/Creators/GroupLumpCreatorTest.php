<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Test\FoundationCreate\Creators;

use Mockery;
use StepUpDream\Blueprint\Creator\Foundations\GroupLump;
use StepUpDream\Blueprint\Creator\GroupLumpCreator;
use StepUpDream\Blueprint\Creator\Supports\File\FileOperation;
use StepUpDream\Blueprint\Creator\Supports\File\YamlFileOperation;
use StepUpDream\Blueprint\Creator\Supports\TextSupport;
use StepUpDream\Blueprint\Test\TestCase;
use StepUpDream\Blueprint\Test\ViewLoadServiceProvider;

class GroupLumpCreatorTest extends TestCase
{
    /**
     * @test
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
        $mock = new ViewLoadServiceProvider($this->app);
        $mock->run();

        // test
        $foundation = app()->make(GroupLump::class, ['foundationConfig' => $foundationConfig]);
        $fileCreator = new FileOperation();
        $yamlReader = new YamlFileOperation();
        $textSupport = new TextSupport();
        $groupLumpCreatorMock = Mockery::mock(GroupLumpCreator::class, [
            $fileCreator,
            $yamlReader,
            $textSupport,
        ])->makePartial();
        $groupLumpCreatorMock->allows('write')->andReturns();

        /** @var GroupLumpCreator $groupLumpCreatorMock */
        $groupLumpCreatorMock->run($foundation);

        // assertion
        $testResult = file_get_contents(__DIR__.'/../Result/GroupLump/PrefixSampleGroup1Suffix.php');
        $expectedResult = file_get_contents(__DIR__.'/../Expected/GroupLump/PrefixSampleGroup1Suffix.php');
        self::assertSame($testResult, $expectedResult);
        $testResult2 = file_get_contents(__DIR__.'/../Result/GroupLump/PrefixSampleGroup2Suffix.php');
        $expectedResult2 = file_get_contents(__DIR__.'/../Expected/GroupLump/PrefixSampleGroup2Suffix.php');
        self::assertSame($testResult2, $expectedResult2);

        // end
        $this->resultReset();
    }
}
