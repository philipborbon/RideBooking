<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingSeatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_seats', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('bookingid')->unsigned();
            $table->integer('routeid')->unsigned();
            $table->integer('typeid')->unsigned();
            $table->integer('count')->default(0);
            $table->timestamps();

            $table->foreign('bookingid')->references('id')->on('bookings');
            $table->foreign('routeid')->references('id')->on('routes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('booking_seats');
    }
}
