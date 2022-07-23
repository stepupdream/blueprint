@php
use Illuminate\Support\Str;
echo '<?php' . PHP_EOL . PHP_EOL .'declare(strict_types=1);'
@endphp


class {{ Str::studly($className) }}
{
    public function {{ Str::camel($yamlFile['api_name']) }}()
    {
        // {{ Str::snake($yamlFile['name']) }}
        // {{ $className }}
        // {{ $yamlCommonFile['name'] }}
        // {{ $options['sample'] }}
    }
}
