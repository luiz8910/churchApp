<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeopleTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('people', function(Blueprint $table) {
            $table->increments('id');
			$table->string('name');
			$table->string('lastName');
			$table->string('email')->nullable();
			$table->string('role');
			$table->string('imgProfile');
			$table->string('tel')->nullable();
			$table->string('cel')->nullable();
			$table->string('gender');
			$table->string('fatherName')->nullable();
			$table->string('motherName')->nullable();
			$table->string('cpf')->nullable();
			$table->string('rg')->nullable();
			$table->string('mailing')->nullable();
			$table->string('dateBirth');
			$table->string('hasKids')->default('0');
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
		Schema::drop('people');
	}

}
