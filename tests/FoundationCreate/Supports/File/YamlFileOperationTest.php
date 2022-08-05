<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Test\FoundationCreate\Supports\File;

use StepUpDream\Blueprint\Creator\Supports\File\YamlFileOperation;
use StepUpDream\Blueprint\Test\TestCase;

class YamlFileOperationTest extends TestCase
{
    /**
     * @var array[]
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
        $reader = $this->app->make(YamlFileOperation::class);
        $textDirectory = __DIR__.'/../TestFiles/Yaml';
        $parseAllYaml = $reader->readByDirectoryPath($textDirectory, []);
        $testResult = collect($parseAllYaml)->values()->all();
        self::assertSame($this->testResult, $testResult);

        $parseAllYaml2 = $reader->readByDirectoryPath($textDirectory, ['common']);
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

        $reader = $this->app->make(YamlFileOperation::class);
        $yamlFile = $reader->readByFileName($textDirectory, 'sample');
        $testResult = collect($this->testResult)->first();

        self::assertSame($yamlFile, $testResult);
    }
}
