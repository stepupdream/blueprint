@php
echo '<?php' . PHP_EOL;
@endphp

namespace {{ $namespace }};

@if (!empty($useExtendsClass))
{{ $useExtendsClass }}

@else
@endif
/**
 * Class {{ $className }}
 */
abstract class {{ $className }}{{ $extendsClassName }}
{

}
