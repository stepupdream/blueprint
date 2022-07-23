@php
use Illuminate\Support\Str;
echo '<?php' . PHP_EOL . PHP_EOL .'declare(strict_types=1);'
@endphp


namespace StepUpDream\Blueprint\Test\Result\GroupLumpAddMethod;

use Illuminate\Database\Schema\Blueprint;

/**
 * Class {{ Str::studly($className) }}
 */
class {{ Str::studly($className) }} {{ $extendsClassName }}
{
    /**
     * {!! $yamlFile['description'] !!}
     */
    {!! sprintf('public function %s()', Str::camel($yamlFile['name'])) !!}
    {
        // {{ $requestDirectoryPath }}
        // {{ $responseDirectoryPath }}
        // {{ $useExtendsClass }}
        // {{ $extendsClassName }}
        // {{ $useInterfaceClass }}
        // {{ $interfaceClassName }}
        // {{ $namespace }}
        // {{ $className }}

@foreach ($options as $option)
        // {{ $option }}
@endforeach
    }
}
