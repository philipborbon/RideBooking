<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTopupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topups', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('walletid')->unsigned();
            $table->integer('transactionid')->unsigned()->nullable();
            $table->double('amount', 8, 2)->default(0);
            $table->string('topupcode')->nullable();
            $table->boolean('approved')->default(false);
            $table->timestamps();

            $table->foreign('walletid')->references('id')->on('wallets');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('topups');
    }
}
