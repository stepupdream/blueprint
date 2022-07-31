@php
use Illuminate\Support\Str;
echo '<?php' . PHP_EOL;
@endphp

declare(strict_types=1);

namespace {{ $namespace }};

@if (!empty($options['use_extends_class']))
{{ $options['use_extends_class'] }}

@else
@endif
abstract class {{ Str::studly($className) }}{{ $options['extends_class_name'] }}
{
    /**
     * The database connection instance.
     *
     * {{ blade_phpdoc_support('string', 'var') }}
     */
    protected string $connection = '{!! Str::snake($yamlFile['connection_name']) !!}';

    /**
     * The name of the cache table.
     *
     * {{ blade_phpdoc_support('string', 'var') }}
     */
    protected string $table = '{!! Str::snake($yamlFile['name']) !!}';

    /**
     * Cast an attribute.
     */
    protected array $casts = [
@foreach($yamlFile['columns'] as $column)
        '{!! $column['name'] !!}' => '{!! $column['data_type'] !!}',
@endforeach
    ];
}
