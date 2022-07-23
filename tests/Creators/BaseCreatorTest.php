<?php

namespace StepUpDream\Blueprint\Test\Creators;

use LogicException;
use StepUpDream\Blueprint\Foundation\Creators\BaseCreator;
use StepUpDream\Blueprint\Foundation\Foundation;
use StepUpDream\Blueprint\Test\TestCase;

/**
 * Class BaseCreatorTest
 */
class BaseCreatorTest extends TestCase
{
    /**
     * @test
     * @dataProvider dataProviderCheckKey
     */
    public function verifyKeys($checkKey): void
    {
        $this->expectException(LogicException::class);
        $foundation = [
            'except_file_names' => ['Get'],
            'read_path'         => __DIR__.'/TestFiles/Yaml/Temp',
        ];
        $foundation = app()->make(Foundation::class, ['foundation' => $foundation]);

        /* @see BaseCreator::verifyKeys */
        $this->executePrivateFunction(
            $this->app->make(BaseCreator::class),
            'verifyKeys',
            [$foundation, [$checkKey]]
        );
    }

    /**
     * dataProvider
     */
    public function dataProviderCheckKey()
    {
        return [
            ['studly'],
            ['output_path'],
        ];
    }
}
