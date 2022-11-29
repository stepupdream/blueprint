<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Connection name.
     *
     * @var string
     */
    protected $connection = 'user_db';

    /**
     * Table name.
     *
     * @var string
     */
    protected string $tableName = 'accounts';

    /**
     * Model class name.
     *
     * @var string
     */
    protected string $modelClassName = 'Account';

    /**
     * Run migration.
     */
    public function up(): void
    {
        if (! Schema::connection($this->connection)->hasTable($this->tableName)) {
            Schema::connection($this->connection)->create($this->tableName, function (Blueprint $table) {
                $table->bigInteger('id')->unsigned()->nullable()->comment('ID');
                $table->integer('user_id')->nullable()->comment('UserID');
                $table->timestamps();
            });
        }
    }
};
