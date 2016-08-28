<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_options', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('course_id')->unsigned();
            $table->integer('course_duration_id')->unsigned();
            $table->decimal('price', 5, 2)->nullable();
            $table->decimal('profit', 5, 2)->nullable();
            $table->decimal('profit_solo', 5, 2)->nullable();
            $table->decimal('pseudo_price', 5, 2)->nullable();
            $table->decimal('price_solo', 5, 2)->default('0.00');
            $table->decimal('pseudo_price_solo', 5, 2)->default('0.00');
            $table->decimal('discount', 5, 2)->default('0.00');
            $table->enum('status', ['online', 'offline', 'deleted'])->default('online');

            $table->foreign('course_id')->references('id')->on('courses');
            $table->foreign('course_duration_id')->references('id')->on('course_durations');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('course_options');
    }
}
