@php
echo '<?php' . PHP_EOL;
@endphp

namespace {{ $namespace }};

@if (!empty($use_extends_class))
{{ $use_extends_class }}

@else
@endif
/**
 * Class {{ $class_name }}
 *
 * {{ blade_phpdoc_support($namespace, 'package') }}
 */
abstract class {{ $class_name }}{{ $extends_class_name }}
{

}
