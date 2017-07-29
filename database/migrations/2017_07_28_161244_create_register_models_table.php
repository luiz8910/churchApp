<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegisterModelsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('register_models', function(Blueprint $table) {
            $table->increments('id');
            $table->string('model');
            $table->string('text');
            $table->integer('church_id')->unsigned();
            $table->foreign('church_id')->references('id')->on("churches");
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
		Schema::drop('register_models');
	}

}
