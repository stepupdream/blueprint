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
class {{ Str::studly($class_name) }}{{ $extends_class_name }}
{
    //
}
