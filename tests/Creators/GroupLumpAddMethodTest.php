<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Test\Creators;

use Illuminate\Filesystem\Filesystem;
use StepUpDream\Blueprint\Creator\Foundations\GroupLumpAddMethod;
use StepUpDream\Blueprint\Creator\GroupLumpAddMethodCreator;
use StepUpDream\Blueprint\Test\TestCase;
use StepUpDream\Blueprint\Test\ViewLoadServiceProvider;

class GroupLumpAddMethodTest extends TestCase
{
    /**
     * @test
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
        $mock = new ViewLoadServiceProvider($this->app);
        $mock->run();

        // initialize
        $filesystem = new Filesystem();
        $filesystem->deleteDirectory(__DIR__.'/../Result/GroupLumpAddMethod', true);

        // test
        $foundation = app()->make(GroupLumpAddMethod::class, ['foundationConfig' => $foundationConfig]);
        $individualCreator = $this->app->make(GroupLumpAddMethodCreator::class);
        $individualCreator->run($foundation);

        // assertion
        $testResult = file_get_contents(__DIR__.'/../Result/GroupLumpAddMethod/PrefixSampleGroup1Suffix.php');
        $expectedResult = file_get_contents(__DIR__.'/../Expected/GroupLumpAddMethod/PrefixCharacter1Suffix.php');
        self::assertSame($testResult, $expectedResult);
        $testResult = file_get_contents(__DIR__.'/../Result/GroupLumpAddMethod/PrefixSampleGroup2Suffix.php');
        $expectedResult = file_get_contents(__DIR__.'/../Expected/GroupLumpAddMethod/PrefixCharacter2Suffix.php');
        self::assertSame($testResult, $expectedResult);

        // end
        $this->resultReset();
    }
}
