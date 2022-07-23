<?php

namespace StepUpDream\Blueprint\Test\Supports\File;

use StepUpDream\Blueprint\Foundation\Supports\File\Creator;
use StepUpDream\Blueprint\Test\TestCase;

/**
 * Class CreatorTest
 */
class CreatorTest extends TestCase
{
    /**
     * @test
     */
    public function addTabSpace(): void
    {
        $creator = $this->app->make(Creator::class);
        $space = $creator->addTabSpace(2);
        $testResult = '        ';

        self::assertEquals($space, $testResult);
    }

    /**
     * @test
     */
    public function createFile(): void
    {
        $outputPath = __DIR__.'/../TestFiles/Temp/test.yml';
        $outputDirectoryPath = __DIR__.'/../TestFiles/Temp';
        $testFilePath = __DIR__.'/../TestFiles/test.yml';

        $creator = $this->app->make(Creator::class);
        $creator->createFile('aaa', $outputPath);
        self::assertFileEquals($outputPath, $testFilePath);

        $creator = $this->app->make(Creator::class);
        $creator->createFile('aaa', $outputPath, true);
        self::assertFileEquals($outputPath, $testFilePath);

        if (is_file($outputPath)) {
            unlink($outputPath);
            rmdir($outputDirectoryPath);
        }
    }
}
