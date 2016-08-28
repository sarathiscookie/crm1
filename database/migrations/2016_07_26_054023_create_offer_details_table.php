<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfferDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offer_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('offer_date_id')->nullable();
            $table->integer('room_id')->nullable();
            $table->decimal('price', 8,2)->nullable();
            $table->decimal('profit', 8,2)->nullable();
            $table->decimal('pseudo_price', 8,2)->nullable();
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
        Schema::drop('offer_details');
    }
}
