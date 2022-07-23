@php
use Illuminate\Support\Str;
echo '<?php' . PHP_EOL . PHP_EOL .'declare(strict_types=1);'
@endphp


@foreach($yamlFile['columns'] as $column)
//'{!! $column['name'] !!}' => '{!! $column['data_type'] !!}',
@endforeach

// {{ $className }}
// {{ $yamlCommonFile['name'] }}
// {{ $options['request_directory_path'] }}
// {{ $options['response_directory_path'] }}
// {{ $options['use_extends_class'] }}
// {{ $options['extends_class_name'] }}
// {{ $options['use_interface_class'] }}
// {{ $options['interface_class_name'] }}

@foreach($yamlCommonFile['columns'] as $column)
//'{!! $column['name'] !!}' => '{!! $column['data_type'] !!}',
@endforeach
