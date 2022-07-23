<?php

namespace StepUpDream\Blueprint\Foundation\Console;

use LogicException;
use StepUpDream\Blueprint\Foundation\Creators\GroupLumpFileCreator;
use StepUpDream\Blueprint\Foundation\Creators\GroupLumpFileCreatorWithAddMethod;
use StepUpDream\Blueprint\Foundation\Creators\IndividualFileCreator;
use StepUpDream\Blueprint\Foundation\Creators\IndividualFileCreatorWithoutRead;
use StepUpDream\Blueprint\Foundation\Creators\LumpFileCreator;

/**
 * Class FoundationCreateCommand
 *
 * @package StepUpDream\Blueprint\Foundation\Console
 */
class FoundationCreateCommand extends BaseCreateCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blueprint:foundation_create {--target=}';
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates design basic data';
    
    /**
     * run method in order
     */
    public function handle(): void
    {
        $target = $this->option('target');
        
        $foundationCreateClasses = config('foundation.create_classes');
        if (empty($foundationCreateClasses) || $this->arrayDepth($foundationCreateClasses) !== 2) {
            throw new LogicException('read error foundation enumerations');
        }
        
        foreach ($foundationCreateClasses as $foundationName => $foundation) {
            if (isset($target) && $foundationName !== $target) {
                continue;
            }
            
            switch ($foundation['create_type']) {
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
                    throw new LogicException('read error foundation_enumeration[create_type]');
            }
            
            $this->info('Completed: '.$foundationName);
        }
    }
    
    /**
     * Get array depth
     *
     * @param  mixed  $array
     * @param  bool  $blank
     * @param  int  $depth
     * @return int
     */
    protected function arrayDepth($array, bool $blank = false, int $depth = 0): int
    {
        if (!is_array($array)) {
            return $depth;
        }
        
        $depth++;
        $tmp = ($blank) ? [$depth] : [0];
        foreach ($array as $key => $value) {
            if ($key === 'except_file_names') {
                continue;
            }
            
            $tmp[] = $this->arrayDepth($value, $blank, $depth);
        }
        return max($tmp);
    }
}
