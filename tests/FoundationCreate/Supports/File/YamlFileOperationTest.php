<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Test\FoundationCreate\Supports\File;

use StepUpDream\Blueprint\Creator\Supports\File\YamlFileOperation;
use StepUpDream\Blueprint\Test\TestCase;

class YamlFileOperationTest extends TestCase
{
    /**
     * @var mixed[]
     */
    protected array $testResult = [
        [
            'database_directory_name' => 'MasterData',
            'domain_group'            => 'Common',
            'columns'                 => [
                [
                    'name'        => 'id',
                    'description' => 'id',
                ],
                [
                    'name'        => 'name',
                    'description' => 'name',
                ],
                [
                    'name'        => 'level',
                    'description' => 'level',
                ],
            ],
        ],
        [
            'database_directory_name' => 'MasterData',
            'domain_group'            => 'Test',
            'columns'                 => [
                [
                    'name'        => 'id',
                    'description' => 'id',
                ],
                [
                    'name'        => 'name',
                    'description' => 'name',
                ],
                [
                    'name'        => 'level',
                    'description' => 'level',
                ],
            ],
        ],
    ];

    /**
     * @test
     */
    public function readFileByDirectoryPath(): void
    {
        $yamlFileOperation = $this->app->make(YamlFileOperation::class);
        $textDirectory = __DIR__.'/../TestFiles/Yaml';
        $parseAllYaml = $yamlFileOperation->readByDirectoryPath($textDirectory, []);
        $testResult = collect($parseAllYaml)->values()->all();
        self::assertSame($this->testResult, $testResult);

        $parseAllYaml2 = $yamlFileOperation->readByDirectoryPath($textDirectory, ['common']);
        $parseAllYaml2 = collect($parseAllYaml2)->values()->all();
        $yamlFile = collect($this->testResult)->take(2)->values()->all();
        self::assertSame($yamlFile, $parseAllYaml2);
    }

    /**
     * @test
     */
    public function readFileByFileName(): void
    {
        $textDirectory = __DIR__.'/../TestFiles/Yaml';
        $yamlFileOperation = $this->app->make(YamlFileOperation::class);
        $yamlFile = $yamlFileOperation->readByFileName($textDirectory, 'sample');
        $testResult = collect($this->testResult)->first();

        self::assertSame($yamlFile, $testResult);
    }

    /**
     * @test
     */
    public function readColumnVersionByFileName(): void
    {
        $migrationDirectoryPath = __DIR__.'/../../../Migration/Mock/YamlFile';
        $yamlFileOperation = $this->app->make(YamlFileOperation::class);
        $result = $yamlFileOperation->readColumnVersionByFileName($migrationDirectoryPath, 'samples', null);
        $yamlFile = $yamlFileOperation->readByFileName($migrationDirectoryPath, 'samples');
        self::assertEquals($result->readYamlFile(), $yamlFile);
        self::assertEquals('1_0_1_0', $result->targetVersion());
        self::assertEquals(['user_id'], $result->versionMatchColumns());

        $result2 = $yamlFileOperation->readColumnVersionByFileName($migrationDirectoryPath, 'samples', '1_0_0_0');
        self::assertEquals($result2->readYamlFile(), $yamlFile);
        self::assertEquals('1_0_0_0', $result2->targetVersion());
        self::assertEquals(['id'], $result2->versionMatchColumns());
    }
}
