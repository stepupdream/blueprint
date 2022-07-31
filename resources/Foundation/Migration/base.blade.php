@php
echo '<?php' . PHP_EOL;
@endphp

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

{!! sprintf('class %s extends Migration' , Str::studly(snake_singular($yamlFile['name']))) !!}
{
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
        if (! Schema::connection($this->connection)->hasTable($this->tableName)) {
            Schema::connection($this->connection)->create($this->tableName, function (Blueprint $table) {
                $table->bigIncrements('id')->comment('ID');
@foreach ($yamlFile['columns'] as $column)
@if ($column['name'] === 'id')
@continue
@endif
                {!! sprintf("\$table->%s('%s')%s%s->comment('%s');", $column['migration_data_type'], $column['name'], $column['is_unsigned'] ? '->unsigned()' : '', $column['is_nullable'] ? '->nullable()' : '', $column['description']) !!}
@endforeach
                $table->timestamps();
            });
        }
    }

    /**
     * Rollback migration.
     */
    public function down(): void
    {
        if (Schema::connection($this->connection)->hasTable($this->tableName)) {
            Schema::connection($this->connection)->drop($this->tableName);
        }
    }
}
