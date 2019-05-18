<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePassengerTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('passenger_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->integer('discount')->default(0);
            $table->timestamps();
        });

        Schema::table('booking_seats', function (Blueprint $table) {
            $table->foreign('typeid')->references('id')->on('passenger_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('booking_seats', function (Blueprint $table) {
            $table->dropForeign(['typeid']);
        });

        Schema::dropIfExists('passenger_types');
    }
}
