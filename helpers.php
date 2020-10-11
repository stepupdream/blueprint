<?php

if (!function_exists('blade_phpdoc_support')) {
    /**
     * blade_phpdoc_support
     *
     * @param string $text
     * @param string $type
     * @return string
     */
    function blade_phpdoc_support(string $text, string $type)
    {
        return '@' . $type . sprintf(' %s', $text);
    }
}
