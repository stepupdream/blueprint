@php
use Illuminate\Support\Str;
echo '<?php' . PHP_EOL . PHP_EOL .'declare(strict_types=1);'
@endphp


@foreach($yamlFile['columns'] as $column)
//'{!! $column['name'] !!}' => '{!! $column['data_type'] !!}',
@endforeach

// {{ $className }}
// {{ $yamlCommonFile['name'] }}
// {{ $options['use_extends_class'] }}

@foreach($yamlCommonFile['columns'] as $column)
//'{!! $column['name'] !!}' => '{!! $column['data_type'] !!}',
@endforeach
