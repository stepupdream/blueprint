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

// {{ $className }}
// {{ $yamlCommonFile['name'] }}
// {{ $options['request_directory_path'] }}
// {{ $options['response_directory_path'] }}
// {{ $options['use_extends_class'] }}
// {{ $options['extends_class_name'] }}
// {{ $options['use_interface_class'] }}
// {{ $options['interface_class_name'] }}
