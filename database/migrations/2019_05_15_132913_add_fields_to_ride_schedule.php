<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToRideSchedule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ride_schedules', function (Blueprint $table) {
            $table->integer('vehicleid')->unsigned();
            $table->time('departuretime')->nullable();
            $table->time('boardingtime')->nullable();
            $table->date('date')->nullable();
            $table->boolean('departed')->default(false);

            $table->foreign('vehicleid')->references('id')->on('vehicles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ride_schedules', function (Blueprint $table) {
            $table->dropForeign(['vehicleid']);

            $table->dropColumn('vehicleid');
            $table->dropColumn('departuretime');
            $table->dropColumn('boardingtime');
            $table->dropColumn('date');
            $table->dropColumn('departed');
        });
    }
}
