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
    //
}
