<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTypePlansTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('type_plans', function(Blueprint $table) {
            $table->increments('id');
			$table->string('type')->nullable();
			$table->string('selected_text')->nullable();
			$table->string('adjective')->nullable();
			$table->integer('save_money')->nullable();
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
		Schema::drop('type_plans');
	}

}
