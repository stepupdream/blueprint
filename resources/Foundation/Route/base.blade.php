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

@foreach ($models as $model)
{!! sprintf("Route::%s('%s/%s', '%sController@%s'); // %s", Str::camel($model['http_method']), Str::snake($model['controller_name']), Str::snake($model['name']), $model['controller_name'], Str::snake($model['name']), $model['description']) !!}
@endforeach
