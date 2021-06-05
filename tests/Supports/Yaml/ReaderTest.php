<?php

namespace StepUpDream\Blueprint\Test\Supports\Yaml;

use StepUpDream\Blueprint\Foundation\Supports\Yaml\Reader;
use StepUpDream\Blueprint\Test\TestCase;

/**
 * Class ReaderTest.
 */
class ReaderTest extends TestCase
{
    protected $testResult = [
        [
            'database_directory_name' => 'MasterData',
            'domain_group'            => 'Character',
            'columns'                 => [
                [
                    'name'        => 'id',
                    'description' => 'id',
                ],
                [
                    'name'        => 'name',
                    'description' => 'name',
                ],
            ],
        ],
        [
            'database_directory_name' => 'MasterData',
            'domain_group'            => 'Character',
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
            'domain_group'            => 'Common',
            'columns'                 => [
                [
                    'name'        => 'id',
                    'description' => 'id',
                ],
            ],
        ],
    ];

    /**
     * @test
     */
    public function readFileByDirectoryPath(): void
    {
        $reader = $this->app->make(Reader::class);
        $textDirectory = __DIR__.'/../TestFiles/Yaml/';
        $parseAllYaml = $reader->readFileByDirectoryPath($textDirectory, []);
        $testResult = collect($parseAllYaml)->values()->all();
        self::assertEquals($this->testResult, $testResult);

        $parseAllYaml2 = $reader->readFileByDirectoryPath($textDirectory, ['common']);
        $parseAllYaml2 = collect($parseAllYaml2)->values()->all();
        $yamlFile = collect($this->testResult)->take(2)->values()->all();
        self::assertEquals($yamlFile, $parseAllYaml2);
    }

    /**
     * @test
     */
    public function readFileByFileName()
    {
        $textDirectory = __DIR__.'/../TestFiles/Yaml/';

        $reader = $this->app->make(Reader::class);
        $yamlFile = $reader->readFileByFileName($textDirectory, 'common');
        $testResult = collect($this->testResult)->last();

        self::assertEquals($yamlFile, $testResult);
    }
}
