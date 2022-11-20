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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("company_id")->nullable();//
            $table->unsignedBigInteger("user_id")->nullable();//
            $table->unsignedBigInteger("project_id")->nullable();//
            $table->unsignedBigInteger("task_id")->nullable();//

            $table->string("activity_name");//
            $table->mediumText("activity_description")->nullable();//
            $table->integer("activity_priority")->default(1); // 1-Low , 2, 3 High

            $table->string("activity_theme")->nullable(); // Color
            $table->string("activity_done")->boolean()->default(false); //
            $table->integer("activity_estimated_price")->default(0);//
            $table->date("activity_start_date")->nullable();//
            $table->date("activity_due_date")->nullable();//
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
        Schema::dropIfExists('activities');
    }
};
