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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("address")->nullable();

            $table->string("country")->nullable();
            $table->string("contact")->nullable();
            $table->string("telephone")->nullable();
            $table->string("email")->nullable();
            $table->string("fiscal_code")->nullable();
            $table->boolean("active")->default(1);
            $table->integer("solde")->default(0);
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
        Schema::dropIfExists('customers');
    }
};
