<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('school_id')->nullable();
            $table->integer('course_type_id')->nullable();
            $table->smallInteger('month_begin')->nullable();
            $table->smallInteger('month_end')->nullable();
            $table->text('services');
            $table->longText('content');
            $table->smallInteger('unit_lesson')->nullable();
            $table->smallInteger('unit_rules')->nullable();
            $table->smallInteger('rounds')->nullable();
            $table->string('rentalclub', 1)->default('f');
            $table->string('free_balls', 1)->default('f');
            $table->string('free_range', 1)->default('f');
            $table->string('free_putting', 1)->default('f');
            $table->smallInteger('turnier')->nullable();
            $table->enum('status', ['online', 'offline', 'deleted'])->default('online');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('courses');
    }
}
