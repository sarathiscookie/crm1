<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderPositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_positions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->unsigned();
            $table->integer('quantity');
            $table->string('title', 100);
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->decimal('cost', 10, 2);
            $table->enum('type', ['course', 'hotel', 'bundle', 'membership', 'other']);
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('order_positions');
    }
}
