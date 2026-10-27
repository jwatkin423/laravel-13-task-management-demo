<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id('task_id');
            $table->bigInteger('project_id');
            $table->string('name');
            /*
             * This is set to nullable, for when creating (seeding)
             * the column can remain null until the Id for the task is
             * created.
             */
            $table->integer('priority')->nullable();
            $table->enum('status', ['open', 'in-progress', 'completed'])->default('open');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
