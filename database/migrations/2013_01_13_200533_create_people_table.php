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
			$table->string('lastName')->nullable();
			$table->integer('church_id')->nullable();
			$table->integer('role_id')->nullable()->unsigned();
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
			$table->string('imgProfile')->nullable();
			$table->string('tel')->nullable();
			$table->string('cel')->nullable();
			$table->string('gender')->nullable();
			$table->string('father_id')->nullable();
			$table->string('mother_id')->nullable();
			$table->string('cpf')->nullable();
			$table->string('rg')->nullable();
			$table->string('mailing')->nullable();
			$table->string('dateBirth')->nullable();
			$table->string('hasKids')->nullable();
            $table->string('tag')->nullable();
            $table->string('specialNeeds')->nullable();
			$table->string('street')->nullable();
			$table->string('neighborhood')->nullable();
			$table->string('city')->nullable();
			$table->string('zipCode')->nullable();
			$table->string('state')->nullable();
            $table->timestamps();
            $table->softDeletes();
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
