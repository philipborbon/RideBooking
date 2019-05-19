<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToVehicles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->string('description')->nullable();
            $table->integer('driverid')->unsigned()->nullable();
            $table->integer('seats')->default(0);
            $table->string('platenumber')->nullable();
            $table->string('cabnumber')->nullable();
            $table->boolean('available')->default(true);
            $table->integer('operatorid')->unsigned()->nullable();
            $table->double('boundary')->nullable();

            $table->foreign('driverid')->references('id')->on('users')->onDelete('set null');
            $table->foreign('operatorid')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropForeign(['driverid']);
            $table->dropForeign(['operatorid']);

            $table->dropColumn('description');
            $table->dropColumn('driverid');
            $table->dropColumn('seats');
            $table->dropColumn('platenumber');
            $table->dropColumn('cabnumber');
            $table->dropColumn('available');
            $table->dropColumn('operatorid');
            $table->dropColumn('boundary');
        });
    }
}
