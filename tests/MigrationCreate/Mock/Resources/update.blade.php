@php
echo '<?php' . PHP_EOL;
@endphp

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Connection name.
     *
     * {{ blade_phpdoc_support('string', 'var') }}
     */
    protected $connection = '{!! Str::snake($yamlFile['connection_name']) !!}';

    /**
     * Table name.
     *
     * {{ blade_phpdoc_support('string', 'var') }}
     */
    protected string $tableName = '{!! $yamlFile['name'] !!}';

    /**
     * Model class name.
     *
     * {{ blade_phpdoc_support('string', 'var') }}
     */
    protected string $modelClassName = '{!! Str::studly(snake_singular($yamlFile['name'])) !!}';

    /**
     * Run migration.
     */
    public function up(): void
    {
        Schema::connection($this->connection)->table($this->tableName, function (Blueprint $table) {
@foreach ($versionMatchColumns as $column)
@if(in_array($column['name'], $existColumnNames, true))
            {!! sprintf("\$table->%s('%s')%s%s->change();", $column['migration_data_type'], $column['name'], $column['is_unsigned'] ? '->unsigned()' : '', $column['is_nullable'] ? '->nullable()' : '', $column['description']) !!}
@else
            {!! sprintf("\$table->%s('%s')%s%s->comment('%s')->after('%s');", $column['migration_data_type'], $column['name'], $column['is_unsigned'] ? '->unsigned()' : '', $column['is_nullable'] ? '->nullable()' : '', $column['description'], $column['after_column']) !!}
@endif
@endforeach
        });
    }
};
