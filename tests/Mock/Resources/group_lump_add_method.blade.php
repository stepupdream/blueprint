@php
use Illuminate\Support\Str;
echo '<?php' . PHP_EOL . PHP_EOL .'declare(strict_types=1);'
@endphp


namespace StepUpDream\Blueprint\Test\Result\GroupLumpAddMethod;

/**
 * Class {{ Str::studly($className) }}
 */
class {{ Str::studly($className) }}
{
    /**
     * {!! $yamlFile['description'] !!}
     */
    {!! sprintf('public function %s()', Str::camel($yamlFile['name'])) !!}
    {
        // {{ $className }}
        // {{ $yamlCommonFile['name'] }}
        // {{ $options['use_extends_class'] }}
    }
}
