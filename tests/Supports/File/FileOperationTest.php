<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Test\Supports\File;

use StepUpDream\Blueprint\Creator\Supports\File\FileOperation;
use StepUpDream\Blueprint\Test\TestCase;

class FileOperationTest extends TestCase
{
    /**
     * @test
     */
    public function addTabSpace(): void
    {
        $creator = $this->app->make(FileOperation::class);
        $space = $creator->addTabSpace(2);
        $testResult = '        ';

        self::assertSame($space, $testResult);
    }

    /**
     * @test
     */
    public function createFile(): void
    {
        $outputPath = __DIR__.'/../TestFiles/Sample/test.yml';
        $outputDirectoryPath = __DIR__.'/../TestFiles/Sample';
        $testFilePath = __DIR__.'/../TestFiles/sample3.yml';

        $creator = $this->app->make(FileOperation::class);
        $creator->createFile("aaa\n", $outputPath);
        self::assertFileEquals($outputPath, $testFilePath);

        $creator = $this->app->make(FileOperation::class);
        $creator->createFile("aaa\n", $outputPath, true);
        self::assertFileEquals($outputPath, $testFilePath);

        if (is_file($outputPath)) {
            unlink($outputPath);
            rmdir($outputDirectoryPath);
        }
    }
}
