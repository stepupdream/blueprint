@php
echo '<?php' . PHP_EOL;
@endphp

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
        if (! Schema::connection($this->connection)->hasTable($this->tableName)) {
            Schema::connection($this->connection)->create($this->tableName, function (Blueprint $table) {
@foreach ($versionMatchColumns as $versionMatchColumn)
                {!! sprintf("\$table->%s('%s')%s%s->comment('%s');", $versionMatchColumn['migration_data_type'], $versionMatchColumn['name'], $versionMatchColumn['is_unsigned'] ? '->unsigned()' : '', $versionMatchColumn['is_nullable'] ? '->nullable()' : '', $versionMatchColumn['description']) !!}
@endforeach
                $table->timestamps();
            });
        }
    }
};
