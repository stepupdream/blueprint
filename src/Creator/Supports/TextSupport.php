<?php

declare(strict_types=1);

namespace StepUpDream\Blueprint\Creator\Supports;

use Illuminate\Support\Str;
use LogicException;

class TextSupport
{
    /**
     * convert name by convert type.
     *
     * @param  string  $convertType
     * @param  string  $name
     * @return string
     */
    public function convertName(string $convertType, string $name): string
    {
        if (empty($convertType)) {
            return $name;
        }

        return match ($convertType) {
            'studly', 'upper_camel' => Str::studly($name),
            'camel' => Str::camel($name),
            'snake' => Str::snake($name),
            'kebab' => Str::kebab($name),
            'singular_studly', 'singular_upper_camel' => Str::studly(snake_singular($name)),
            'singular_camel' => Str::camel(snake_singular($name)),
            'singular_snake' => Str::snake(snake_singular($name)),
            'singular_kebab' => Str::kebab(snake_singular($name)),
            'plural_studly', 'plural_upper_camel' => Str::studly(Str::plural($name)),
            'plural_camel' => Str::camel(Str::plural($name)),
            'plural_snake' => Str::snake(Str::plural($name)),
            'plural_kebab' => Str::kebab(Str::plural($name)),
            default => throw new LogicException('The data in convert_class_name_type is incorrect'),
        };
    }

    /**
     * Convert file path to namespace.
     *
     * @param  string  $fileFullPath
     * @return string
     */
    public function convertFileFullPathToNamespace(string $fileFullPath): string
    {
        return str_replace([
            base_path('app'),
            DIRECTORY_SEPARATOR.basename($fileFullPath),
            DIRECTORY_SEPARATOR,
        ], [
            'App',
            '',
            '\\',
        ], $fileFullPath);
    }

    /**
     * Convert file path to class path.
     *
     * @param  string  $fileFullPath
     * @return string
     */
    public function convertFileFullPathToClassPath(string $fileFullPath): string
    {
        $temp = str_replace([
            base_path('app'),
            DIRECTORY_SEPARATOR,
        ], [
            'App',
            '\\',
        ], $fileFullPath);

        return pathinfo($temp)['filename'];
    }
}
