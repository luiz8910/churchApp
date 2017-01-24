<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('groups', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('frequency');
            $table->string('sinceOf');
            $table->string('imgProfile')->nullable();
            $table->integer('active');
            $table->integer('owner_id')->unsigned();
            $table->string('street')->nullable();
            $table->string('neighborhood')->nullable();
            $table->string('city')->nullable();
            $table->string('zipCode')->nullable();
            $table->string('state')->nullable();
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
		Schema::drop('groups');
	}

}
