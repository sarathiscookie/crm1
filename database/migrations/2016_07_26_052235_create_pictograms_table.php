<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePictogramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pictograms', function (Blueprint $table) {
            $table->increments('id');
            $table->smallInteger('type')->nullable();
            $table->string('alt', 100)->nullable();
            $table->longText('caption');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('pictograms');
    }
}
