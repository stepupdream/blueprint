<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Test\FoundationCreate\Supports\File;

use StepUpDream\Blueprint\Creator\Supports\File\ColumnVersionMigration;
use StepUpDream\Blueprint\Creator\Supports\File\FileOperation;
use StepUpDream\Blueprint\Test\TestCase;

class FileOperationTest extends TestCase
{
    /**
     * @test
     */
    public function getColumnVersionByTable(): void
    {
        $migrationDirectoryPath = __DIR__.'/../../../MigrationCreate/Mock/Migration';
        $fileOperation = $this->app->make(FileOperation::class);
        $columnVersion = $fileOperation->getColumnVersionByTable($migrationDirectoryPath, 'samples');

        // MockData
        $columnVersionMigration = new ColumnVersionMigration();
        $attributes = [];
        $attributes['name'] = '1_0_1_0';
        $attributes['email'] = '1_0_0_0';
        $attributes['email_verified_at'] = '1_0_0_0';
        $attributes['password'] = '1_0_0_0';
        $attributes['name2'] = '1_0_1_0';
        $columnVersionMigration->addColumnVersions($attributes);

        self::assertEquals($columnVersionMigration, $columnVersion);
    }

    /**
     * @test
     */
    public function addTabSpace(): void
    {
        $fileOperation = $this->app->make(FileOperation::class);
        $space = $fileOperation->addTabSpace(2);
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

        $fileOperation = $this->app->make(FileOperation::class);
        $fileOperation->createFile("aaa\n", $outputPath);
        self::assertFileEquals($outputPath, $testFilePath);

        $fileOperation = $this->app->make(FileOperation::class);
        $fileOperation->createFile("aaa\n", $outputPath, true);
        self::assertFileEquals($outputPath, $testFilePath);

        if (is_file($outputPath)) {
            unlink($outputPath);
            rmdir($outputDirectoryPath);
        }
    }
}
