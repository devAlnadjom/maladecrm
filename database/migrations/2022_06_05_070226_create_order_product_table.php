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
        Schema::create('order_product', function (Blueprint $table) {
            $table->id();
            //$table->unsignedBigInteger("user_id")->nullable();
            $table->unsignedBigInteger("order_id");
            $table->unsignedBigInteger("product_id");
            $table->string("name")->nullable();
            $table->mediumText("description")->nullable();

            $table->boolean("is_service")->default(true);
            $table->integer("total_price")->default(0);
            $table->integer("total_quantity")->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_product');
    }
};
