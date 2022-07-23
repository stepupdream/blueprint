<?php

namespace StepUpDream\Blueprint\Test\Creators;

use Illuminate\Support\Facades\View;
use Mockery;
use StepUpDream\Blueprint\Foundation\Creators\LumpFileCreator;
use StepUpDream\Blueprint\Foundation\Foundation;
use StepUpDream\Blueprint\Foundation\Supports\Yaml\Reader;
use StepUpDream\Blueprint\Test\TestCase;

/**
 * Class LumpFileCreatorTest.
 */
class LumpFileCreatorTest extends TestCase
{
    /**
     * @test
     */
    public function lumpFileCreator(): void
    {
        $foundationAttributes = [
            'read_path'                => __DIR__.'/TestFiles/Yaml/',
            'output_path'              => __DIR__.'/TestResult/test.php',
            'extension'                => 'php',
            'template_blade_file'      => 'sample',
            'is_override'              => false,
            'output_directory_path'    => 'app/Http/Controllers/NewsWatchController/@groupName/@fileName',
            'extends_class_name'       => 'orange/@groupName/@fileName',
            'use_extends_class'        => 'orange/@groupName/@fileName',
            'interface_class_name'     => 'orange/@groupName/@fileName',
            'use_interface_class'      => 'orange/@groupName/@fileName',
            'request_directory_path'   => 'orange/@groupName/@fileName',
            'response_directory_path'  => 'orange/@groupName/@fileName',
            'options'                  => ['orange/@groupName/@fileName', 'banana'],
            'directory_group_key_name' => 'domain_group',
        ];

        View::shouldReceive('make->render')->once()->andReturn('sample');
        $readerMock = Mockery::mock(Reader::class)->makePartial();
        $readerMock->shouldReceive('readByDirectoryPath')->andReturn();
        $readerMock->shouldReceive('readFileByFileName')->andReturn();
        $creator = $this->app->make(LumpFileCreator::class, [
            'yamlReader' => $readerMock,
        ]);

        $foundation = $this->app->make(Foundation::class, ['foundation' => $foundationAttributes]);
        $creator->run($foundation);

        $testResult = file_get_contents($foundationAttributes['output_path']);
        self::assertEquals('sample', $testResult);

        if (is_file($foundationAttributes['output_path'])) {
            unlink($foundationAttributes['output_path']);
        }
    }
}
