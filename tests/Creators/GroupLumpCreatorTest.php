<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Test\Creators;

use Illuminate\Filesystem\Filesystem;
use StepUpDream\Blueprint\Creator\Foundations\GroupLump;
use StepUpDream\Blueprint\Creator\Foundations\Individual;
use StepUpDream\Blueprint\Creator\GroupLumpCreator;
use StepUpDream\Blueprint\Creator\IndividualCreator;
use StepUpDream\Blueprint\Test\TestCase;
use StepUpDream\Blueprint\Test\ViewLoadServiceProvider;

class GroupLumpCreatorTest extends TestCase
{
    /**
     * @test
     */
    public function groupLumpCreator(): void
    {
        // config mock
        $configPath = __DIR__.'/../Config.php';
        $configMock = require $configPath;
        $foundationConfig = $configMock['foundations']['group_lump'];

        // load resources
        $mock = new ViewLoadServiceProvider($this->app);
        $mock->run();

        // initialize
        $filesystem = new Filesystem();
        $filesystem->deleteDirectory(__DIR__.'/../Result/GroupLump', true);

        // test
        $foundation = app()->make(GroupLump::class, ['foundationConfig' => $foundationConfig]);
        $individualCreator = $this->app->make(GroupLumpCreator::class);
        $individualCreator->run($foundation);

        // assertion
        $testResult = file_get_contents(__DIR__.'/../Result/GroupLump/PrefixCharacterSuffix.php');
        $expectedResult = file_get_contents(__DIR__.'/../Expected/GroupLump/PrefixCharacterSuffix.php');
        self::assertSame($testResult, $expectedResult);
        $testResult2 = file_get_contents(__DIR__.'/../Result/GroupLump/PrefixCharacter2Suffix.php');
        $expectedResult2 = file_get_contents(__DIR__.'/../Expected/GroupLump/PrefixCharacter2Suffix.php');
        self::assertSame($testResult2, $expectedResult2);
    }
}
