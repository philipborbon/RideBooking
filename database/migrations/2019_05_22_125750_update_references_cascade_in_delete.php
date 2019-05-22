<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateReferencesCascadeInDelete extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('topups', function (Blueprint $table) {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            $table->dropForeign(['walletid']);
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            $table->foreign('walletid')->references('id')->on('wallets')->onDelete('cascade');
        });

        Schema::table('redeems', function (Blueprint $table) {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            $table->dropForeign(['walletid']);
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            $table->foreign('walletid')->references('id')->on('wallets')->onDelete('cascade');
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
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            $table->dropForeign(['walletid']);
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            $table->foreign('walletid')->references('id')->on('wallets')->onDelete('set null');
        });

        Schema::table('redeems', function (Blueprint $table) {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            $table->dropForeign(['walletid']);
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            $table->foreign('walletid')->references('id')->on('wallets')->onDelete('set null');
        });
    }
}
