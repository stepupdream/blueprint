<?php

namespace StepUpDream\Blueprint\Test\Creators;

use Illuminate\Support\Facades\View;
use Mockery;
use StepUpDream\Blueprint\Foundation\Creators\GroupLumpFileCreator;
use StepUpDream\Blueprint\Foundation\Foundation;
use StepUpDream\Blueprint\Foundation\Supports\Yaml\Reader;
use StepUpDream\Blueprint\Test\TestCase;

/**
 * Class GroupLumpFileCreatorTest
 */
class GroupLumpFileCreatorTest extends TestCase
{
    /**
     * @test
     */
    public function individualFileCreator(): void
    {
        $foundationAttributes = [
            'read_path'                => __DIR__.'/TestFiles/Yaml',
            'extension'                => 'php',
            'template_blade_file'      => 'sample',
            'is_override'              => false,
            'output_directory_path'    => __DIR__.'/TestResult',
            'convert_class_name_type'  => 'studly',
            'group_key_name'           => 'database',
            'extends_class_name'       => 'orange/@groupName/@fileName',
            'use_extends_class'        => 'orange/@groupName/@fileName',
            'interface_class_name'     => 'orange/@groupName/@fileName',
            'use_interface_class'      => 'orange/@groupName/@fileName',
            'request_directory_path'   => 'orange/@groupName/@fileName',
            'response_directory_path'  => 'orange/@groupName/@fileName',
            'options'                  => ['orange/@groupName/@fileName', 'banana'],
            'directory_group_key_name' => 'domain_group',
        ];

        $readFileByDirectoryPathMock = [
            '/work/packages/stepupdream/blueprint/tests/Supports/TestFiles/Yaml/Temp/sample.yml' => [
                'database_directory_name' => 'MasterData',
                'domain_group'            => 'Character',
                'database'                => 'user',
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
            '/work/packages/stepupdream/blueprint/tests/Supports/TestFiles/Yaml/sample2.yml'     => [
                'database_directory_name' => 'MasterData',
                'domain_group'            => 'Character',
                'database'                => 'user',
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

        View::shouldReceive('make->render')->once()->andReturn('sample');
        $readerMock = Mockery::mock(Reader::class)->makePartial();
        $readerMock->shouldReceive('readFileByDirectoryPath')->andReturn($readFileByDirectoryPathMock);
        $readerMock->shouldReceive('readFileByFileName')->andReturn();
        $creator = $this->app->make(GroupLumpFileCreator::class, [
            'yamlReader' => $readerMock,
        ]);

        $foundation = $this->app->make(Foundation::class, ['foundation' => $foundationAttributes]);
        $creator->run($foundation);

        $testResult = file_get_contents($foundationAttributes['output_directory_path'].'/User.php');
        self::assertEquals('sample', $testResult);

        if (is_file($foundationAttributes['output_directory_path'].'/User.php')) {
            unlink($foundationAttributes['output_directory_path'].'/User.php');
        }
    }
}
