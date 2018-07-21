<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateBugsTable.
 */
class CreateBugsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bugs', function(Blueprint $table) {
            $table->increments('id');
            $table->text('description');
            $table->string('platform')->nullable();
            $table->string('location')->nullable();
            $table->string('model')->nullable();
            $table->string('status')->default('pending');
            $table->integer('church_id')->nullable();
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
		Schema::drop('bugs');
	}
}
