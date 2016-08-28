<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schools', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('group_id')->nullable();
            $table->string('title', 255)->nullable();
            $table->string('subtitle', 200)->nullable();
            $table->string('alias', 100)->unique()->nullable();
            $table->text('description')->nullable();
            $table->string('address', 255)->nullable();
            $table->string('coords', 255)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('location', 255)->nullable();
            $table->string('country', 2)->nullable();
            $table->enum('status', ['offline', 'online', 'hidden', 'deleted'])->default('offline');
            $table->integer('holes')->nullable();
            $table->integer('training')->nullable();
            $table->string('duration', 3)->nullable();
            $table->enum('flex_booking', ['yes', 'no'])->default('no');
            $table->enum('new', ['yes', 'no'])->default('no');
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
        Schema::drop('schools');
    }
}
