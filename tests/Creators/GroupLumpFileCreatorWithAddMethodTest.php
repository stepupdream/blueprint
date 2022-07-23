<?php

namespace StepUpDream\Blueprint\Test\Creators;

use Illuminate\Support\Facades\View;
use Mockery;
use StepUpDream\Blueprint\Foundation\Creators\GroupLumpFileCreatorWithAddMethod;
use StepUpDream\Blueprint\Foundation\Foundation;
use StepUpDream\Blueprint\Foundation\Supports\Yaml\Reader;
use StepUpDream\Blueprint\Test\TestCase;

/**
 * Class GroupLumpFileCreatorWithAddMethodTest.
 */
class GroupLumpFileCreatorWithAddMethodTest extends TestCase
{
    /**
     * @test
     */
    public function groupLumpFileCreatorWithAddMethod(): void
    {
        $foundationAttributes = [
            'read_path'                => __DIR__.'/TestFiles/Yaml',
            'extension'                => 'php',
            'template_blade_file'      => 'sample',
            'add_template_blade_file'  => 'sample2',
            'is_override'              => false,
            'output_directory_path'    => __DIR__.'/TestResult',
            'convert_class_name_type'  => 'studly',
            'group_key_name'           => 'database',
            'method_key_name'          => 'name',
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
                'name'                    => 'Sample1',
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
                'name'                    => 'Sample2',
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

        $before = file_get_contents(__DIR__.'/TestFiles/before_file.blade.php');
        $add = file_get_contents(__DIR__.'/TestFiles/add_file.blade.php');
        $result = file_get_contents(__DIR__.'/TestFiles/result_file.blade.php');

        View::shouldReceive('make->render')->twice()->andReturn($before, $add);
        $readerMock = Mockery::mock(Reader::class)->makePartial();
        $readerMock->shouldReceive('readFileByDirectoryPath')->andReturn($readFileByDirectoryPathMock);
        $readerMock->shouldReceive('readFileByFileName')->andReturn();
        $creator = $this->app->make(GroupLumpFileCreatorWithAddMethod::class, [
            'yamlReader' => $readerMock,
        ]);

        $foundation = $this->app->make(Foundation::class, ['foundation' => $foundationAttributes]);
        $creator->run($foundation);

        $testResult = file_get_contents($foundationAttributes['output_directory_path'].'/User.php');
        self::assertEquals($result, $testResult);

        if (is_file($foundationAttributes['output_directory_path'].'/User.php')) {
            unlink($foundationAttributes['output_directory_path'].'/User.php');
        }
    }
}
