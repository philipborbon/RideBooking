<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UseWalletReferenceInRedeem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('redeems', function (Blueprint $table) {
            $table->integer('walletid')->unsigned()->nullable();

            $table->dropForeign(['driverid']);
            $table->dropColumn('driverid');

            $table->foreign('walletid')->references('id')->on('wallets')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('redeems', function (Blueprint $table) {
            $table->dropForeign(['walletid']);
            $table->dropColumn('walletid');

            $table->integer('driverid')->unsigned()->nullable();
            $table->foreign('driverid')->references('id')->on('users')->onDelete('set null');
        });
    }
}
