<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHotelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotels', function (Blueprint $table) {
            $table->increments('id');
            $table->smallInteger('group_id')->nullable();
            $table->integer('school_id')->nullable();
            $table->string('title', 100)->nullable();
            $table->string('subtitle', 200)->nullable();
            $table->string('alias', 100)->unique();
            $table->longText('description');
            $table->longText('terms');
            $table->longText('services');
            $table->smallInteger('golfdistance')->nullable();
            $table->decimal('stars', 2,1)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('coords', 100)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('country', 100)->nullable();
            $table->string('country_short', 3)->nullable();
            $table->smallInteger('nights')->nullable();
            $table->enum('additional_nights', ['yes', 'no'])->default('no');
            $table->string('location', 100)->nullable();
            $table->enum('status', ['online', 'offline', 'offer', 'hidden', 'deleted'])->default('online');
            $table->enum('new', ['yes', 'no'])->default('no');
            $table->string('blog_link', 200)->nullable();
            $table->text('widget');
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
        Schema::drop('hotels');
    }
}
