<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("company_id")->nullable();
            $table->unsignedBigInteger("user_id")->nullable();
            $table->unsignedBigInteger("project_id")->nullable();

            $table->string("task_name");
            $table->mediumText("task_description")->nullable();
            $table->integer("task_priority")->default(1); // 1-Low , 2, 3 High

            $table->string("task_theme")->nullable();
            $table->string("task_done")->boolean()->default(false); // Color
            $table->integer("task_estimated_price")->default(0);
            $table->date("task_start_date")->nullable();
            $table->date("task_due_date")->nullable();
            $table->unsignedBigInteger("task_status_id")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
};
