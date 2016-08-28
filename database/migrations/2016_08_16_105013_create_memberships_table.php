<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembershipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('memberships', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id')->unsigned();
            $table->integer('school_id')->unsigned();
            $table->date('created_at');
            $table->date('joined_at');
            $table->dateTime('renewed_at')->nullable();
            $table->date('cancelled_at')->nullable();

            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('school_id')->references('id')->on('schools');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('memberships');
    }
}
