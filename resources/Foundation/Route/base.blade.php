@php
echo '<?php' . PHP_EOL
@endphp

/*
|--------------------------------------------------------------------------
| route
|--------------------------------------------------------------------------
|
| It is a file that defines the route
| No need for manual editing as it is output automatically
|
*/

@foreach ($yamlFiles as $yamlFile)
{!! sprintf("Route::%s('%s/%s', '%sController@%s'); // %s", Str::camel($yamlFile['http_method']), Str::snake($yamlFile['controller_name']), Str::snake($yamlFile['name']), $yamlFile['controller_name'], Str::snake($yamlFile['name']), $yamlFile['description']) !!}
@endforeach
