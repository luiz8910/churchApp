<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('feeds', function(Blueprint $table) {
            $table->increments('id');
			$table->integer('church_id')->nullable();
            $table->integer('notification_range')->nullable();
            $table->string('model')->nullable();
            $table->integer('model_id')->nullable();
            $table->string('text')->nullable();
            $table->integer('icon_id')->nullable();
            $table->integer('show')->nullable();
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
		Schema::drop('feeds');
	}

}
