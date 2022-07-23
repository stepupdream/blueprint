<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Creator\Console;

use LogicException;
use StepUpDream\Blueprint\Creator\Foundations\GroupLump;
use StepUpDream\Blueprint\Creator\Foundations\GroupLumpAddMethod;
use StepUpDream\Blueprint\Creator\Foundations\Individual;
use StepUpDream\Blueprint\Creator\Foundations\IndividualNotRead;
use StepUpDream\Blueprint\Creator\Foundations\Lump;
use StepUpDream\Blueprint\Creator\GroupLumpAddMethodCreator;
use StepUpDream\Blueprint\Creator\GroupLumpCreator;
use StepUpDream\Blueprint\Creator\IndividualCreator;
use StepUpDream\Blueprint\Creator\IndividualNotReadCreator;
use StepUpDream\Blueprint\Creator\LumpCreator;

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
     * @var \StepUpDream\Blueprint\Creator\IndividualCreator
     */
    protected IndividualCreator $individualCreator;

    /**
     * @var \StepUpDream\Blueprint\Creator\IndividualNotReadCreator
     */
    protected IndividualNotReadCreator $individualNotReadCreator;

    /**
     * @var \StepUpDream\Blueprint\Creator\LumpCreator
     */
    protected LumpCreator $lumpCreator;

    /**
     * @var \StepUpDream\Blueprint\Creator\GroupLumpCreator
     */
    protected GroupLumpCreator $groupLumpCreator;

    /**
     * @var \StepUpDream\Blueprint\Creator\GroupLumpAddMethodCreator
     */
    protected GroupLumpAddMethodCreator $groupLumpAddMethodCreator;

    /**
     * Run method in order.
     */
    public function handle(): void
    {
        $target = $this->targetOption();
        $foundationsConfig = $this->foundationsConfig();
        $this->individualCreator = app()->make(IndividualCreator::class);
        $this->individualNotReadCreator = app()->make(IndividualNotReadCreator::class);
        $this->lumpCreator = app()->make(LumpCreator::class);
        $this->groupLumpCreator = app()->make(GroupLumpCreator::class);
        $this->groupLumpAddMethodCreator = app()->make(GroupLumpAddMethodCreator::class);

        foreach ($foundationsConfig as $foundationName => $foundationConfig) {
            if ($target !== null && $foundationName !== $target) {
                continue;
            }

            if (! isset($foundationConfig['create_type'])) {
                throw new LogicException('create_type was not found in the definition.');
            }

            if (! is_string($foundationConfig['create_type'])) {
                throw new LogicException('create_type must be specified as a string');
            }

            $createType = $foundationConfig['create_type'];
            $this->createFoundation($createType, $foundationConfig);
            $this->info('Completed: '.$foundationName);
        }
    }

    /**
     * Target.
     *
     * @return string|null
     */
    private function targetOption(): string|null
    {
        $target = $this->option('target');
        if ($target === null) {
            return null;
        }

        if (is_string($target)) {
            return $target;
        }

        throw new LogicException('The option specification is incorrect: target');
    }

    /**
     * Create classes config.
     *
     * @return mixed[][]
     */
    private function foundationsConfig(): array
    {
        $foundations = config('stepupdream.blueprint.foundations');

        if (! is_array($foundations) || ! $this->isMultidimensional($foundations)) {
            throw new LogicException('Must be a two-dimensional array:foundations');
        }

        return $foundations;
    }

    /**
     * Whether it is a multidimensional array.
     *
     * @param  mixed[]  $array
     * @return bool
     */
    private function isMultidimensional(array $array): bool
    {
        return count($array) !== count($array, 1);
    }

    /**
     * Generate the underlying class.
     *
     * @param  string  $createType
     * @param  mixed[]  $foundationConfig
     */
    private function createFoundation(string $createType, array $foundationConfig): void
    {
        switch ($createType) {
            case 'Individual':
                $foundation = app()->make(Individual::class, ['foundationConfig' => $foundationConfig]);
                $this->individualCreator->run($foundation);
                break;
            case 'IndividualNotRead':
                $foundation = app()->make(IndividualNotRead::class, ['foundationConfig' => $foundationConfig]);
                $this->individualNotReadCreator->run($foundation);
                break;
            case 'Lump':
                $foundation = app()->make(Lump::class, ['foundationConfig' => $foundationConfig]);
                $this->lumpCreator->run($foundation);
                break;
            case 'GroupLump':
                $foundation = app()->make(GroupLump::class, ['foundationConfig' => $foundationConfig]);
                $this->groupLumpCreator->run($foundation);
                break;
            case 'GroupLumpAddMethod':
                $foundation = app()->make(GroupLumpAddMethod::class, ['foundationConfig' => $foundationConfig]);
                $this->groupLumpAddMethodCreator->run($foundation);
                break;
            default:
                throw new LogicException('read error create_type: name '.$createType);
        }
    }
}
