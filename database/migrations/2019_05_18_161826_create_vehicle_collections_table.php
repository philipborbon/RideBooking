<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehicleCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_collections', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('driverid')->unsigned()->nullable();
            $table->integer('vehicleid')->unsigned()->nullable();
            $table->double('amount', 8, 2)->default(0);
            $table->timestamps();

            $table->foreign('driverid')->references('id')->on('users')->onDelete('set null');
            $table->foreign('vehicleid')->references('id')->on('vehicles')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicle_collections');
    }
}
