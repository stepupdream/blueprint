<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Foundation\Supports\File;

use Illuminate\Filesystem\Filesystem;
use LogicException;

class Creator
{
    /**
     * Creator constructor.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $file
     */
    public function __construct(
        protected Filesystem $file
    ) {
    }

    /**
     * Create the same file as the first argument at the position specified by the second argument.
     *
     * @param  string  $content
     * @param  string  $filePath
     * @param  bool  $isOverwrite
     */
    public function createFile(string $content, string $filePath, bool $isOverwrite = false): void
    {
        $directoryPath = dirname($filePath);

        if (! is_dir($directoryPath)) {
            $resultMkdir = mkdir($directoryPath, 0777, true);
            if (! $resultMkdir) {
                throw new LogicException($filePath.': Failed to directory create');
            }
        }

        if (! file_exists($filePath)) {
            $resultCreate = file_put_contents($filePath, $content);
            if ($resultCreate === false) {
                throw new LogicException($filePath.': Failed to create');
            }

            return;
        }

        if ($isOverwrite && file_exists($filePath)) {
            // Hack:
            // An error occurred when overwriting, so always delete → create
            $resultDelete = unlink($filePath);
            if (! $resultDelete) {
                throw new LogicException($filePath.': Failed to delete');
            }

            $resultCreate = file_put_contents($filePath, $content);
            if ($resultCreate === false) {
                throw new LogicException($filePath.': Failed to create');
            }
        }
    }

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
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function getFile(string $path): string
    {
        return $this->file->get($path);
    }
}
