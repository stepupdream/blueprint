<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Test\Migration\Creators;

use Illuminate\Console\OutputStyle;
use Illuminate\Filesystem\Filesystem;
use Mockery;
use StepUpDream\Blueprint\Creator\Foundations\Migration;
use StepUpDream\Blueprint\Creator\MigrationCreator;
use StepUpDream\Blueprint\Creator\Supports\File\FileOperation;
use StepUpDream\Blueprint\Creator\Supports\File\YamlFileOperation;
use StepUpDream\Blueprint\Creator\Supports\TextSupport;
use StepUpDream\Blueprint\Test\TestCase;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;

class MigrationCreatorTest extends TestCase
{
    protected string $outputDirectoryPath = __DIR__.'/../Mock/TestOutput';

    /**
     * @test
     * @dataProvider migrationCreatorDataProvider
     * @param $foundationConfig
     * @param  MigrationCreator  $migrationCreator
     */
    public function migrationCreatorRun($foundationConfig, MigrationCreator $migrationCreator): void
    {
        $this->resultReset();

        $bufferedOutput = new BufferedOutput();
        $style = new OutputStyle(new ArrayInput([]), $bufferedOutput);
        $migrationCreator->setOutput($style);
        $foundation = app()->make(Migration::class, ['foundationConfig' => $foundationConfig]);

        $migrationCreator->run($foundation, '1_0_0_0');
        $expectedResult = file_get_contents($this->outputDirectoryPath.'/1_0_0_0/user_db/samples.php');
        self::assertSame("->string('name')", $expectedResult);

        $migrationCreator->run($foundation, '1_0_1_0');
        $expectedResult = file_get_contents($this->outputDirectoryPath.'/1_0_1_0/user_db/samples.php');
        self::assertSame("->string('name')", $expectedResult);

        // If null is specified, it will be the maximum version.
        // If the same version is specified, it will be placed in tmp.
        $migrationCreator->run($foundation, null);
        $expectedResult = file_get_contents($this->outputDirectoryPath.'/tmp/user_db/samples.php');
        self::assertSame("->string('name')", $expectedResult);

        $this->resultReset();
    }

    /**
     * @return mixed[]
     */
    public function migrationCreatorDataProvider(): array
    {
        $fileCreator = new FileOperation();
        $yamlReader = new YamlFileOperation();
        $textSupport = new TextSupport();
        $migrationCreator = Mockery::mock(MigrationCreator::class, [
            $fileCreator,
            $yamlReader,
            $textSupport,
        ])->makePartial();
        $migrationCreator->allows('readBlade')->andReturns("->string('name')");

        return [
            [
                $foundationConfig = [
                    'read_path'                  => __DIR__.'/../Mock/YamlFile',
                    'connection'                 => 'user_db',
                    'except_file_names'          => [],
                    'output_directory_path'      => $this->outputDirectoryPath,
                    'template_blade_file'        => 'blueprint::Foundation.Migration.create',
                    'template_update_blade_file' => 'blueprint::Foundation.Migration.update',
                    'options'                    => [
                        'connection' => 'user_db',
                    ],
                ],
                $migrationCreator,
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
