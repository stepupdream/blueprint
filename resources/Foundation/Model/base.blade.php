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
    //
}
