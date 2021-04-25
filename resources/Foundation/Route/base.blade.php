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

@foreach ($yamls as $yaml)
{!! sprintf("Route::%s('%s/%s', '%sController@%s'); // %s", Str::camel($yaml['http_method']), Str::snake($yaml['controller_name']), Str::snake($yaml['name']), $yaml['controller_name'], Str::snake($yaml['name']), $yaml['description']) !!}
@endforeach
