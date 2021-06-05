@php
use Illuminate\Support\Str;
echo '<?php' . PHP_EOL;
@endphp

namespace {{ $namespace }};

@if (!empty($useExtendsClass))
{{ $useExtendsClass }}

@else
@endif
/**
 * Class {{ Str::studly($className) }}
 */
abstract class {{ Str::studly($className) }}{{ $extendsClassName }}
{
    /**
     * The database connection instance
     */
    protected $connection = '{!! Str::snake($yaml['connection_name']) !!}';

    /**
     * The name of the cache table
     */
    protected $table = '{!! Str::snake($yaml['name']) !!}';

    /**
     * Cast an attribute
     */
    protected $casts = [
@foreach($yaml['columns'] as $column)
        '{!! $column['name'] !!}' => '{!! $column['data_type'] !!}',
@endforeach
    ];
}
