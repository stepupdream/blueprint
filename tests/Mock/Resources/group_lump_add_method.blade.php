@php
use Illuminate\Support\Str;
echo '<?php' . PHP_EOL . PHP_EOL .'declare(strict_types=1);'
@endphp


namespace StepUpDream\Blueprint\Test\Result\GroupLumpAddMethod;

use Illuminate\Database\Schema\Blueprint;

/**
 * Class {{ Str::studly($className) }}
 */
class {{ Str::studly($className) }} {{ $options['extends_class_name'] }}
{
    /**
     * {!! $yamlFile['description'] !!}
     */
    {!! sprintf('public function %s()', Str::camel($yamlFile['name'])) !!}
    {
        // {{ $className }}
        // {{ $yamlCommonFile['name'] }}
        // {{ $options['request_directory_path'] }}
        // {{ $options['response_directory_path'] }}
        // {{ $options['use_extends_class'] }}
        // {{ $options['extends_class_name'] }}
        // {{ $options['use_interface_class'] }}
        // {{ $options['interface_class_name'] }}
    }
}
