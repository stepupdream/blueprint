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
        Schema::connection($this->connection)->table($this->tableName, function (Blueprint $table) {
            $table->string('user_id')->unsigned()->nullable()->change();
            $table->integer('rank')->unsigned()->nullable()->comment('Rank')->after('user_id');
        });
    }
};
