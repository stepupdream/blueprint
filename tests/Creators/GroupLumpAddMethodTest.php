<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Test\Creators;

use ErrorException;
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
        $resultPath = __DIR__.'/../Result/GroupLumpAddMethod/PrefixCharacterSuffix.php';
        $this->initialize($resultPath);

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
        $testResult = file_get_contents($resultPath);
        $expectedResult = file_get_contents(__DIR__.'/../Expected/GroupLumpAddMethod/PrefixCharacterSuffix.php');
        self::assertSame($testResult, $expectedResult);
    }

    /**
     * Delete file.
     *
     * @param  string  $path
     * @return bool
     */
    protected function initialize(string $path): bool
    {
        $success = true;

        if (! @unlink($path)) {
            $success = false;
        }

        return $success;
    }
}
