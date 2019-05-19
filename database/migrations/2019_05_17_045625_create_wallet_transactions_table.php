<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWalletTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fromwalletid')->unsigned()->nullable();
            $table->integer('towalletid')->unsigned()->nullable();
            $table->double('amount', 8, 2)->default(0);
            $table->enum('type', ['topup', 'redeem', 'payment', 'boundary']);
            $table->timestamps();

            $table->foreign('fromwalletid')->references('id')->on('wallets')->onDelete('set null');
            $table->foreign('towalletid')->references('id')->on('wallets')->onDelete('set null');
        });

        Schema::table('topups', function (Blueprint $table) {
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
        Schema::table('topups', function (Blueprint $table) {
            $table->dropForeign(['transactionid']);
        });

        Schema::dropIfExists('wallet_transactions');
    }
}
