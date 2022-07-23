@php
use Illuminate\Support\Str;
echo '<?php' . PHP_EOL;
@endphp

namespace {{ $namespace }};

@if (!empty($use_extends_class))
{{ $use_extends_class }}

@else
@endif
/**
 * Class {{ Str::studly($class_name) }}
 *
 * {{ blade_phpdoc_support($namespace, 'package') }}
 */
abstract class {{ Str::studly($class_name) }}{{ $extends_class_name }}
{
    /**
     * The database connection instance
     */
    protected $connection = '{!! Str::snake($model['connection_name']) !!}';

    /**
     * The name of the cache table
     */
    protected $table = '{!! Str::snake($model['name']) !!}';

    /**
     * Cast an attribute
     */
    protected $casts = [
@foreach($model['columns'] as $column)
        '{!! $column['name'] !!}' => '{!! $column['data_type'] !!}',
@endforeach
    ];
}
