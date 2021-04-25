<?php

namespace StepUpDream\Blueprint\Test\Creators;

use StepUpDream\Blueprint\Foundation\Creators\GroupLumpFileCreatorWithAddMethod;
use StepUpDream\Blueprint\Test\TestCase;

/**
 * Class GroupLumpFileCreatorWithAddMethodTest
 *
 * @package StepUpDream\Blueprint\Test\Creators
 */
class GroupLumpFileCreatorWithAddMethodTest extends TestCase
{
    public function testReplaceClassFile(): void
    {
        $bladeFile = file_get_contents(__DIR__.'/TestFiles/add_file.blade.php');
        $classFilePath = __DIR__.'/GroupLumpFileCreatorWithAddMethodTest.php';
        
        /* @see GroupLumpFileCreatorWithAddMethod::replaceClassFile */
        $response = $this->executePrivateFunction(
            $this->app->make(GroupLumpFileCreatorWithAddMethod::class),
            'replaceClassFile',
            [$bladeFile, $classFilePath]
        );
        
        $testResult = file_get_contents(__DIR__.'/TestFiles/result_file.blade.php');
        
        self::assertEquals($response, $testResult);
    }

    /**
     * Sample
     */
    public function()
    {
        // sample
    }
}
