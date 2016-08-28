<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfferDatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offer_dates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('offer_id')->nullable();
            $table->date('date_begin')->nullable();
            $table->date('date_end')->nullable();
            $table->smallInteger('nights')->nullable();
            $table->smallInteger('arrival')->nullable();
            $table->string('type', 255)->nullable();
            $table->enum('status', ['online', 'offline','soldout', 'lastchance'])->default('online');
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
        Schema::drop('offer_dates');
    }
}
