<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Test\FoundationCreate\Console;

use Illuminate\Support\Facades\Config;
use StepUpDream\Blueprint\Creator\Console\FoundationCreateCommand;
use StepUpDream\Blueprint\Test\TestCase;

class SampleTest extends TestCase
{
    /**
     * Laravel's [this-> option ('target')] hindered the test, so test only where it's needed.
     *
     * @test
     * @doesNotPerformAssertions
     */
    public function foundationCreateCommand(): void
    {
        // config mock
        $configPath = __DIR__.'/../Config.php';
        $configMock = require $configPath;
        Config::set('stepupdream.blueprint', $configMock);

        /* @see FoundationCreateCommand::foundationsConfig() */
        $foundationCreateCommand = new FoundationCreateCommand();
        $this->executePrivateFunction($foundationCreateCommand, 'foundationsConfig');
    }
}
