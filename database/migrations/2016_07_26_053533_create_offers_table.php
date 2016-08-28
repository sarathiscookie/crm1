<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('hotel_id')->nullable();
            $table->integer('school_id')->nullable();
            $table->string('title', 255)->nullable();
            $table->string('subtitle', 255)->nullable();
            $table->string('alias', 100)->nullable();
            $table->text('kurzleistungen');
            $table->text('services');
            $table->text('description');
            $table->text('header');
            $table->text('footer');
            $table->string('type', 100)->nullable();
            $table->enum('type_date', ['timerange', 'fixdates', 'validrange'])->nullable();
            $table->enum('course', ['yes', 'no', 'optional'])->default('no');
            $table->decimal('discount', 8, 2)->nullable();
            $table->date('date_begin')->nullable();
            $table->date('date_end')->nullable();
            $table->enum('status', ['offline', 'online', 'hidden', 'deleted'])->default('offline');
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
        Schema::drop('offers');
    }
}
