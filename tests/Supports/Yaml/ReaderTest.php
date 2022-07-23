<?php

namespace StepUpDream\Blueprint\Test\Supports\Yaml;

use StepUpDream\Blueprint\Foundation\Supports\Yaml\Reader;
use StepUpDream\Blueprint\Test\TestCase;

/**
 * Class ReaderTest
 */
class ReaderTest extends TestCase
{
    protected $testResult = [
        '/work/packages/stepupdream/blueprint/tests/Supports/TestFiles/Yaml/Temp/character_details.yml' => [
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
        '/work/packages/stepupdream/blueprint/tests/Supports/TestFiles/Yaml/characters.yml'             => [
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
        '/work/packages/stepupdream/blueprint/tests/Supports/TestFiles/Yaml/common.yml'                 => [
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
        $parseAllYaml = $reader->readFileByDirectoryPath($textDirectory);

        self::assertEquals($parseAllYaml, $this->testResult);

        $parseAllYaml2 = $reader->readFileByDirectoryPath($textDirectory, ['common']);
        $testResult2 = collect($this->testResult)->take(2)->all();
        self::assertEquals($parseAllYaml2, $testResult2);
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
