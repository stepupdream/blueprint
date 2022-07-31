<?php

declare(strict_types=1);

if (! function_exists('blade_phpdoc_support')) {
    /**
     * blade_phpdoc_support.
     *
     * @param  string  $text
     * @param  string  $type
     * @return string
     */
    function blade_phpdoc_support(string $text, string $type): string
    {
        return '@'.$type.sprintf(' %s', $text);
    }
}

if (! function_exists('snake_singular')) {
    /**
     * If you change ***_***es to singular, it will not behave as intended, so create it separately.
     *
     * @param  string  $name
     * @return string
     */
    function snake_singular(string $name): string
    {
        $nameExplode = explode('_', $name);
        if (count($nameExplode) === 1) {
            return Str::singular($name);
        }

        $result = '';
        foreach ($nameExplode as $key => $item) {
            if ($key !== 0) {
                $result .= '_';
            }
            $result .= Str::singular($item);
        }

        return $result;
    }
}
