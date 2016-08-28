<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHotelBundlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel_bundles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('hotel_id')->nullable();
            $table->integer('room_id')->nullable();
            $table->integer('course_option_id')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('profit', 10, 2)->nullable();
            $table->decimal('price_additional_night', 10, 2)->nullable();
            $table->decimal('pseudo_price', 10, 2)->default('0.00');
            $table->decimal('discount', 8, 2)->nullable();
            $table->date('date_begin')->nullable();
            $table->date('date_end')->nullable();
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
        Schema::drop('hotel_bundles');
    }
}
