@php
echo '<?php' . PHP_EOL . PHP_EOL .'declare(strict_types=1);'
@endphp


// {{ $requestDirectoryPath }}
// {{ $responseDirectoryPath }}
// {{ $useExtendsClass }}
// {{ $extendsClassName }}
// {{ $useInterfaceClass }}
// {{ $interfaceClassName }}
// {{ $namespace }}
// {{ $className }}

@foreach ($options as $option)
// {{ $option }}
@endforeach
