<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHotelPictogramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel_pictograms', function (Blueprint $table) {
            $table->integer('hotel_id');
            $table->integer('picto_id')->unsigned();

            $table->foreign('picto_id')->references('id')->on('pictograms');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('hotel_pictograms');
    }
}
