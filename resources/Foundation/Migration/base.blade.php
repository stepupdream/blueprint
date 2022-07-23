@php
echo '<?php' . PHP_EOL;
@endphp

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * {!! sprintf('Class Create%sTable', Str::studly($yamlFile['name'])) !!}
 */
{!! sprintf('class %s extends Migration' , Str::studly($yamlFile['name'])) !!}
{
    /**
     * connection name
     *
     * {{ blade_phpdoc_support('string', 'var') }}
     */
    protected $connection = '{!! Str::snake($yamlFile['connection_name']) !!}';

    /**
     * table name
     *
     * {{ blade_phpdoc_support('string', 'var') }}
     */
    protected $class_name = '{!! Str::studly(snake_singular($yamlFile['name'])) !!}';

    /**
     * run migration
     */
    public function up()
    {
        if (!Schema::connection($this->connection)->hasTable($this->table_name)) {
            Schema::connection($this->connection)->create($this->table_name, function (Blueprint $table) {
                $table->bigIncrements('id')->comment('ID');
@foreach ($yamlFile['columns'] as $column)
@if ($column['name'] === 'id')
@continue
@endif
@if ($column['is_real_column'])
                {!! sprintf("\$table->%s('%s')%s%s->comment('%s');", $column['migration_data_type'], $column['name'], $column['is_unsigned'] ? '->unsigned()' : '', $column['is_nullable'] ? '->nullable()' : '', $column['description']) !!}
@endif
@endforeach
                $table->timestamps();
            });
        }
    }

    /**
     * rollback migration
     */
    public function down()
    {
        if (Schema::connection($this->connection)->hasTable($this->table_name)) {
            Schema::connection($this->connection)->drop($this->table_name);
        }
    }
}
