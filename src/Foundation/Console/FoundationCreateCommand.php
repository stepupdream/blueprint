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
    public function handle()
    {
        $target = $this->option('target');
        
        $foundation_create_classes = config('foundation.create_classes');
        if (empty($foundation_create_classes) || $this->arrayDepth($foundation_create_classes) !== 2) {
            throw new LogicException('read error foundation enumerations');
        }
        
        foreach ($foundation_create_classes as $foundation_name => $foundation) {
            if (isset($target) && $foundation_name !== $target) {
                continue;
            }
            
            switch ($foundation['create_type']) {
                case 'Individual':
                    $individual_file_creator = app()->make(IndividualFileCreator::class);
                    $individual_file_creator->run($foundation);
                    break;
                case 'IndividualWithoutRead':
                    $individual_file_creator_without_read = app()->make(IndividualFileCreatorWithoutRead::class);
                    $individual_file_creator_without_read->run($foundation);
                    break;
                case 'Lump':
                    $lump_file_creator = app()->make(LumpFileCreator::class);
                    $lump_file_creator->run($foundation);
                    break;
                case 'GroupLumpWithAddMethod':
                    $group_lump_file_creator_with_add_method = app()->make(GroupLumpFileCreatorWithAddMethod::class);
                    $group_lump_file_creator_with_add_method->run($foundation);
                    break;
                case 'GroupLumpFileCreator':
                    $group_lump_file_creator = app()->make(GroupLumpFileCreator::class);
                    $group_lump_file_creator->run($foundation);
                    break;
                default:
                    throw new LogicException('read error foundation_enumeration[create_type]');
            }
            
            $this->info('Completed:: ' . $foundation_name);
        }
        
        $this->call('view:clear');
        $this->call('cache:clear');
        $this->call('clear-compiled');
        $this->call('route:clear');
    }
    
    /**
     * Get array depth
     *
     * @param mixed $array
     * @param bool $blank
     * @param int $depth
     * @return int
     */
    private function arrayDepth($array, bool $blank = false, int $depth = 0)
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
