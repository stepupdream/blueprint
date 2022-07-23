<?php

namespace StepUpDream\Blueprint\Foundation\Supports;

use LogicException;

/**
 * Class FileOperation
 *
 * @package StepUpDream\Blueprint\Foundation\Supports
 */
class FileOperation
{
    /**
     * Create the same file as the first argument at the position specified by the second argument
     *
     * @param string $content
     * @param string $file_path
     * @param bool $is_overwrite
     */
    public function createFile(string $content, string $file_path, bool $is_overwrite = false)
    {
        $dir_path = dirname($file_path);
        
        if (!is_dir($dir_path)) {
            $result_mkdir = mkdir($dir_path, 0777, true);
            if (!$result_mkdir) {
                throw new LogicException($file_path . ': Failed to directory create');
            }
        }
        
        if (!file_exists($file_path)) {
            $result_create = file_put_contents($file_path, $content);
            if ($result_create === false) {
                throw new LogicException($file_path . ': Failed to create');
            }
            return;
        }
        
        if ($is_overwrite && file_exists($file_path)) {
            // Hack:
            // An error occurred when overwriting, so always delete → create
            $result_delete = unlink($file_path);
            if (!$result_delete) {
                throw new LogicException($file_path . ': Failed to delete');
            }
            
            $result_create = file_put_contents($file_path, $content);
            if ($result_create === false) {
                throw new LogicException($file_path . ': Failed to create');
            }
        }
    }
    
    /**
     * Add Tab Space
     *
     * @param int $tab_count
     * @return string
     */
    public function addTabSpace(int $tab_count = 1)
    {
        $result = '';
        
        for ($i = 1; $i <= $tab_count; $i++) {
            $result .= '    ';
        }
        
        return $result;
    }
}
