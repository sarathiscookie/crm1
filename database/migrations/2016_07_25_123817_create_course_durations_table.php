<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseDurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_durations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 255)->nullable();
            $table->smallInteger('duration')->nullable();
            $table->string('period', 255)->nullable();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('course_durations');
    }
}
