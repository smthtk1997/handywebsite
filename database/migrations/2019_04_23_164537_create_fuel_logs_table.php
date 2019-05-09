<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFuelLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fuel_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('car_id');
            $table->text('img_slip')->nullable();
            $table->date('filling_date');
            $table->time('filling_time');
            $table->string('mileage');
            $table->string('gas_station');
            $table->string('fuel_type');
            $table->float('price_liter');
            $table->float('total_price');
            $table->float('total_liter');
            $table->string('filling_lat');
            $table->string('filling_lng');
            $table->string('token');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fuel_logs');
    }
}
