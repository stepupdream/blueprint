<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Foundation\Console;

use LogicException;
use StepUpDream\Blueprint\Foundation\Creators\GroupLumpFileCreator;
use StepUpDream\Blueprint\Foundation\Creators\GroupLumpFileCreatorWithAddMethod;
use StepUpDream\Blueprint\Foundation\Creators\IndividualFileCreator;
use StepUpDream\Blueprint\Foundation\Creators\IndividualFileCreatorWithoutRead;
use StepUpDream\Blueprint\Foundation\Creators\LumpFileCreator;
use StepUpDream\Blueprint\Foundation\Foundation;

class FoundationCreateCommand extends BaseCreateCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blueprint:foundation-create {--target=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates design basic data';

    /**
     * Run method in order.
     */
    public function handle(): void
    {
        $target = $this->option('target');
        $foundationCreateClasses = config('step-up-dream.blueprint.create_classes');

        foreach ($foundationCreateClasses as $foundationName => $foundation) {
            if (isset($target) && $foundationName !== $target) {
                continue;
            }

            $foundation = app()->make(Foundation::class, ['foundation' => $foundation]);
            switch ($foundation->createType()) {
                case 'Individual':
                    $individualFileCreator = app()->make(IndividualFileCreator::class);
                    $individualFileCreator->run($foundation);
                    break;
                case 'IndividualWithoutRead':
                    $individualFileCreatorWithoutRead = app()->make(IndividualFileCreatorWithoutRead::class);
                    $individualFileCreatorWithoutRead->run($foundation);
                    break;
                case 'Lump':
                    $lumpFileCreator = app()->make(LumpFileCreator::class);
                    $lumpFileCreator->run($foundation);
                    break;
                case 'GroupLumpWithAddMethod':
                    $groupLumpFileCreatorWithAddMethod = app()->make(GroupLumpFileCreatorWithAddMethod::class);
                    $groupLumpFileCreatorWithAddMethod->run($foundation);
                    break;
                case 'GroupLumpFileCreator':
                    $groupLumpFileCreator = app()->make(GroupLumpFileCreator::class);
                    $groupLumpFileCreator->run($foundation);
                    break;
                default:
                    throw new LogicException('read error create_type: name '.$foundationName);
            }

            $this->info('Completed: '.$foundationName);
        }
    }
}
