<?php

namespace StepUpDream\Blueprint\Foundation\Supports;

use Illuminate\Support\Str;
use LogicException;

/**
 * Class TextSupport
 */
class TextSupport
{
    /**
     * convert name by convert type.
     *
     * @param  string  $convertType
     * @param  string  $name
     * @return string
     */
    public function convertNameByConvertType(string $convertType, string $name): string
    {
        if (empty($convertType)) {
            return $name;
        }

        switch ($convertType) {
            case 'studly':
            case 'upper_camel':
                $result = Str::studly($name);
                break;
            case 'camel':
                $result = Str::camel($name);
                break;
            case 'snake':
                $result = Str::snake($name);
                break;
            case 'kebab':
                $result = Str::kebab($name);
                break;
            case 'singular_studly':
            case 'singular_upper_camel':
                $result = Str::studly(snake_singular($name));
                break;
            case 'singular_camel':
                $result = Str::camel(snake_singular($name));
                break;
            case 'singular_snake':
                $result = Str::snake(snake_singular($name));
                break;
            case 'singular_kebab':
                $result = Str::kebab(snake_singular($name));
                break;
            case 'plural_studly':
            case 'plural_upper_camel':
                $result = Str::studly(Str::plural($name));
                break;
            case 'plural_camel':
                $result = Str::camel(Str::plural($name));
                break;
            case 'plural_snake':
                $result = Str::snake(Str::plural($name));
                break;
            case 'plural_kebab':
                $result = Str::kebab(Str::plural($name));
                break;
            default:
                throw new LogicException('The data in convert_class_name_type is incorrect');
        }

        return $result;
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
