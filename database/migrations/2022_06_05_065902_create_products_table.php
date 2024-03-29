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
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("company_id")->nullable();
            $table->unsignedBigInteger("user_id")->nullable();
            $table->string("name")->nullable();
            $table->string("manufacturer")->nullable();
            $table->mediumText("description")->nullable();

            $table->boolean("is_service")->default(true);
            $table->string("refrence")->nullable();
            $table->integer("price")->default(0);
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
        Schema::dropIfExists('products');
    }
};
