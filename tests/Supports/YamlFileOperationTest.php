<?php

namespace StepUpDream\Blueprint\Test\Supports;

use StepUpDream\Blueprint\Foundation\Supports\YamlFileOperation;
use StepUpDream\Blueprint\Test\TestCase;

/**
 * Class YamlFileOperation
 *
 * @package StepUpDream\Blueprint\Test\Supports
 */
class YamlFileOperationTest extends TestCase
{
    public function testGetTitleArray(): void
    {
        $yamlFileOperation = $this->app->make(YamlFileOperation::class);
        $space = $yamlFileOperation->addTabSpace(2);
        $testResult = '        ';
        
        self::assertEquals($space, $testResult);
    }
    
    public function testReadByDirectoryPath(): void
    {
        $yamlFileOperation = $this->app->make(YamlFileOperation::class);
        $textDirectory = __DIR__.'/TestFiles/Yaml/';
        $parseAllYaml = $yamlFileOperation->readByDirectoryPath($textDirectory);
        $testResult = [
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
                ]
            ],
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
                ]
            ]
        ];
        
        self::assertEquals($parseAllYaml, $testResult);
    }
}
