<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHotelCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel_courses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('hotel_id')->nullable();
            $table->integer('course_duration_id')->nullable();
            $table->smallInteger('nights')->nullable();
            $table->smallInteger('arrival')->nullable();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('hotel_courses');
    }
}
