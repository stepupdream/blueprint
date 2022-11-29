<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Test\MigrationCreate\Creators;

use Illuminate\Console\OutputStyle;
use Illuminate\Filesystem\Filesystem;
use Mockery;
use StepUpDream\Blueprint\Creator\Foundations\Migration;
use StepUpDream\Blueprint\Creator\MigrationCreator;
use StepUpDream\Blueprint\Creator\Supports\File\FileOperation;
use StepUpDream\Blueprint\Creator\Supports\File\YamlFileOperation;
use StepUpDream\Blueprint\Creator\Supports\TextSupport;
use StepUpDream\Blueprint\Test\TestCase;
use StepUpDream\Blueprint\Test\ViewLoad;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;

class MigrationCreatorTest extends TestCase
{
    protected string $outputDirectoryPath = __DIR__.'/../Result';

    /**
     * @test
     * @dataProvider migrationCreatorDataProvider
     * @param $diffPath
     * @param $endReset
     * @param $foundationConfig
     */
    public function migrationCreatorRun($diffPath, $endReset, $foundationConfig): void
    {
        // load resources
        $viewLoad = new ViewLoad($this->app);
        $viewLoad->run(__DIR__.'/../Mock/Resources');

        $fileCreator = new FileOperation();
        $yamlReader = new YamlFileOperation();
        $textSupport = new TextSupport();
        $bufferedOutput = new BufferedOutput();
        $style = new OutputStyle(new ArrayInput([]), $bufferedOutput);
        $foundation = app()->make(Migration::class, ['foundationConfig' => $foundationConfig]);
        $migrationCreator = Mockery::mock(MigrationCreator::class, [
            $fileCreator,
            $yamlReader,
            $textSupport,
        ])->makePartial();
        $migrationCreator->allows('write')->andReturns();

        $migrationCreator->setOutput($style)->run($foundation);
        $testResult = file_get_contents($this->outputDirectoryPath.$diffPath);
        $expectedResult = file_get_contents(__DIR__.'/../Expected'.$diffPath);
        self::assertSame($expectedResult, $testResult);

        if ($endReset) {
            $this->resultReset();
        }
    }

    /**
     * @return mixed[]
     * @noinspection PhpUnusedLocalVariableInspection
     * @noinspection PhpConditionAlreadyCheckedInspection
     */
    public function migrationCreatorDataProvider(): array
    {
        return [
            'test1' => [
                $diffPath = '/1_0_0_0/user_db/samples.php',
                $endReset = false,
                $foundationConfig = [
                    'read_path'                  => __DIR__.'/../Mock/Yaml/pattern1',
                    'connection'                 => 'user_db',
                    'except_file_names'          => [],
                    'output_directory_path'      => $this->outputDirectoryPath,
                    'template_blade_file'        => 'blueprint::create',
                    'template_update_blade_file' => 'blueprint::update',
                    'options'                    => [
                        'connection' => 'user_db',
                    ],
                ],
            ],
            'test2' => [
                $diffPath = '/tmp/user_db/samples.php',
                $endReset = false,
                $foundationConfig = [
                    'read_path'                  => __DIR__.'/../Mock/Yaml/pattern2',
                    'connection'                 => 'user_db',
                    'except_file_names'          => [],
                    'output_directory_path'      => $this->outputDirectoryPath,
                    'template_blade_file'        => 'blueprint::create',
                    'template_update_blade_file' => 'blueprint::update',
                    'options'                    => [
                        'connection' => 'user_db',
                    ],
                ],
            ],
            'test3' => [
                $diffPath = '/1_0_1_0/user_db/samples.php',
                $endReset = true,
                $foundationConfig = [
                    'read_path'                  => __DIR__.'/../Mock/Yaml/pattern3',
                    'connection'                 => 'user_db',
                    'except_file_names'          => [],
                    'output_directory_path'      => $this->outputDirectoryPath,
                    'template_blade_file'        => 'blueprint::create',
                    'template_update_blade_file' => 'blueprint::update',
                    'options'                    => [
                        'connection' => 'user_db',
                    ],
                ],
            ],
        ];
    }

    /**
     * Delete the directory for storing test results. Recursively delete a directory.
     */
    protected function resultReset(): void
    {
        $filesystem = $this->app->make(Filesystem::class);
        $filesystem->deleteDirectory($this->outputDirectoryPath);
    }
}
