<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRideScheduleRoutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ride_schedule_routes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('scheduleid')->unsigned();
            $table->integer('routeid')->unsigned();
            $table->boolean('isMain')->default(false);
            $table->timestamps();

            $table->foreign('scheduleid')->references('id')->on('ride_schedules')->onDelete('cascade');
            $table->foreign('routeid')->references('id')->on('routes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ride_schedule_routes');
    }
}
