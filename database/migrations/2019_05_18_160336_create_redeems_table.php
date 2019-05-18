<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRedeemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('redeems', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('driverid')->unsigned();
            $table->integer('transactionid')->unsigned()->nullable();
            $table->double('amount', 8, 2)->default(0);
            $table->string('redeemcode')->nullable();
            $table->boolean('approved')->default(false);
            $table->timestamps();

            $table->foreign('driverid')->references('id')->on('users');
            $table->foreign('transactionid')->references('id')->on('wallet_transactions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('redeems');
    }
}
