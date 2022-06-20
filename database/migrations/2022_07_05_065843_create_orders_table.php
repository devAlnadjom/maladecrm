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
            $table->unsignedBigInteger("company_id")->nullable();
            $table->unsignedBigInteger("user_id")->nullable();
            $table->unsignedBigInteger("customer_id")->nullable();

            $table->integer("order_status")->nullable();
            $table->string("order_key")->nullable();

            $table->string("ref_customer")->nullable();
            $table->integer("montant_total")->default(0);
            $table->integer("tax_1_percentage")->default(0);
            $table->integer("tax_2_percentage")->default(0);
            $table->integer("tax_1_amount")->default(0);
            $table->integer("tax_2_amount")->default(0);
            $table->integer("order_type")->default(0);
            $table->bigInteger("total_order")->default(0);
            $table->bigInteger("ttc_total_order")->default(0);

            $table->mediumText("order_comment")->nullable();
            $table->integer("remise_order")->default(0);

            $table->date("date_order")->nullable();
            $table->date("due_date_order")->nullable();

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
