<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('userid')->unsigned();
            $table->integer('ridescheduleid')->unsigned();
            $table->integer('transactionid')->unsigned()->nullable();
            $table->double('payment', 8, 2)->default(0);
            $table->string('bookingcode')->nullable();
            $table->boolean('approved')->default(false);
            $table->boolean('closed')->default(false);
            $table->timestamps();

            $table->foreign('userid')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('ridescheduleid')->references('id')->on('ride_schedules')->onDelete('cascade');
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
        Schema::dropIfExists('bookings');
    }
}
