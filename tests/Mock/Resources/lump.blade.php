@php
echo '<?php' . PHP_EOL . PHP_EOL .'declare(strict_types=1);'
@endphp


/*
|--------------------------------------------------------------------------
| route
|--------------------------------------------------------------------------
|
| It is a file that defines the route
| No need for manual editing as it is output automatically
|
*/

@foreach ($yamlFiles as $yamlFile)
// {{ Str::snake($yamlFile['name']) }}
@endforeach

// {{ $requestDirectoryPath }}
// {{ $responseDirectoryPath }}
// {{ $useExtendsClass }}
// {{ $extendsClassName }}
// {{ $useInterfaceClass }}
// {{ $interfaceClassName }}
// {{ $namespace }}
// {{ $className }}
// {{ $yamlCommonFile['name'] }}

@foreach ($options as $option)
// {{ $option }}
@endforeach
