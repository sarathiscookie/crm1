<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderPositionMetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_position_metas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_position_id')->unsigned();
            $table->string('name', 100);
            $table->text('value');
            $table->timestamps();

            $table->foreign('order_position_id')->references('id')->on('order_positions');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('order_position_metas');
    }
}
