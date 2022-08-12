@php
echo '<?php' . PHP_EOL . PHP_EOL .'declare(strict_types=1);'
@endphp


@foreach ($yamlFiles as $yamlFile)
// {{ Str::snake($yamlFile['name']) }}
@endforeach

// {{ $yamlCommonFile['name'] }}
// {{ $className }}
// {{ $options['sample'] }}
