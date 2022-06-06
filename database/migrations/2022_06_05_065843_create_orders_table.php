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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id")->nullable();
            $table->unsignedBigInteger("customer_id");
            $table->string("address")->nullable();

            $table->integer("status")->nullable(1);
            $table->string("order_key")->nullable();
            $table->string("refrence")->nullable();
            $table->integer("montant_total")->default(0);
            $table->integer("taxe_1")->default(0);
            $table->integer("taxe_2")->default(0);
            $table->integer("remise")->default(0);
            $table->mediumText("Note")->nullable();
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
        Schema::dropIfExists('orders');
    }
};
