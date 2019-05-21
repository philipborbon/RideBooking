<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateWalletTransactionType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wallet_transactions', function (Blueprint $table) {
            $table->dropColumn('type');
        });

        Schema::table('wallet_transactions', function (Blueprint $table) {
            $table->enum('type', ['topup', 'redeem', 'payment', 'collection', 'boundary']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wallet_transactions', function (Blueprint $table) {
            $table->dropColumn('type');
        });

        Schema::table('wallet_transactions', function (Blueprint $table) {
            $table->enum('type', ['topup', 'redeem', 'payment', 'boundary']);
        });
    }
}
