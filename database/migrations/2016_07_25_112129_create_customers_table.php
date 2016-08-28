<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('firstname', 100);
            $table->string('lastname', 100);
            $table->string('street', 100);
            $table->string('postal', 10);
            $table->string('city', 50);
            $table->string('country', 100);
            $table->string('phone', 30);
            $table->string('mail', 255);
            $table->date('birthdate')->nullable();
            $table->enum('status', ['customer', 'vip', 'blocked', 'deleted'])->default('customer');
            $table->enum('counterpart', ['yes', 'no'])->default('no');
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
        Schema::drop('customers');
    }
}
