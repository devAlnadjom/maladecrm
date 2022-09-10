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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("company_id")->nullable();
            $table->unsignedBigInteger("user_id")->nullable();
            $table->unsignedBigInteger("customer_id")->nullable();

            $table->string("project_name");
            $table->string("project_category")->nullable();
            $table->mediumText("project_description")->nullable();
            $table->integer("project_status")->nullable();
            $table->string("project_public_key")->nullable();
            $table->string("project_theme")->nullable(); // Color
            $table->integer("project_estimated_price")->default(0);
            $table->date("project_start_date")->nullable();
            $table->date("project_end_date")->nullable();
            $table->integer("project_template_id")->default(1);
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
        Schema::dropIfExists('projects');
    }
};
