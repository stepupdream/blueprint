<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Creator\Supports\File;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use LogicException;
use StepUpDream\SpreadSheetConverter\DefinitionDocument\Supports\FileOperation as SpreadSheetConverterFileOperation;

class FileOperation extends SpreadSheetConverterFileOperation
{
    /**
     * Add Tab Space.
     *
     * @param  int  $tabCount
     * @return string
     */
    public function addTabSpace(int $tabCount = 1): string
    {
        $result = '';

        for ($i = 1; $i <= $tabCount; $i++) {
            $result .= '    ';
        }

        return $result;
    }

    /**
     * Get the contents of a file.
     *
     * @param  string  $path
     * @return string
     */
    public function get(string $path): string
    {
        if (is_file($path)) {
            $contents = file_get_contents($path);

            if (! $contents) {
                throw new LogicException('Failed to get the file. : '.$path);
            }

            return $contents;
        }

        throw new FileNotFoundException("File does not exist at path {$path}.");
    }
}
