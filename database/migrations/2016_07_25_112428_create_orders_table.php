<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('invoice_id');
            $table->enum('status', ['offered', 'booked', 'confirmed', 'finished'])->default('booked');
            $table->enum('source', ['website', 'phone', 'mail', 'other']);
            $table->enum('type', ['booking', 'membership'])->default('booking');
            $table->dateTime('payed_at')->nullable();
            $table->dateTime('cancelled_at')->nullable();
            $table->date('due_at')->nullable();
            $table->dateTime('reminded1_at')->nullable();
            $table->dateTime('reminded2_at')->nullable();
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
        Schema::drop('orders');
    }
}
