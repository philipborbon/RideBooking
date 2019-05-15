<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToRoutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('routes', function (Blueprint $table) {
            $table->string('startlocation')->nullable();
            $table->string('endlocation')->nullable();
            $table->double('distance', 8, 2)->nullable();
            $table->double('eta', 8, 2)->nullable();
            $table->double('regularfare', 8, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('routes', function (Blueprint $table) {
            $table->dropColumn('startlocation');
            $table->dropColumn('endlocation');
            $table->dropColumn('distance');
            $table->dropColumn('eta');
            $table->dropColumn('regularfare');
        });
    }
}
