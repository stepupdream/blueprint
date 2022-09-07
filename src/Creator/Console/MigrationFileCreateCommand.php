<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Creator\Console;

use Illuminate\Console\View\Components\Info;
use LogicException;
use StepUpDream\Blueprint\Creator\Foundations\Migration;
use StepUpDream\Blueprint\Creator\MigrationCreator;
use StepUpDream\DreamAbilitySupport\Console\BaseCommand;

class MigrationFileCreateCommand extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blueprint:migration-create {--target-version=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates migration file';

    /**
     * Run method in order.
     * @noinspection DisconnectedForeachInstructionInspection
     */
    public function handle(): void
    {
        $version = $this->optionText('target-version');
        $foundationsConfig = $this->foundationsMigrationConfig();

        foreach ($foundationsConfig as $foundationConfig) {
            $foundation = app()->make(Migration::class, ['foundationConfig' => $foundationConfig]);
            $migrationCreator = app()->make(MigrationCreator::class);

            (new Info($this->output))->render(sprintf('%s file creating.', $foundation->connection()));
            $migrationCreator->setOutput($this->output)->run($foundation, $version);
            $this->output->newLine();
        }

        $this->commandDetailLog('command run detail');
    }

    /**
     * Create classes config.
     *
     * @return mixed[][]
     */
    private function foundationsMigrationConfig(): array
    {
        $foundations = config('stepupdream.blueprint.foundations_migration');

        if (! is_array($foundations) || ! $this->isMultidimensional($foundations)) {
            throw new LogicException('Must be a two-dimensional array:foundations');
        }

        return $foundations;
    }
}
