<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResponsiblesTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('responsibles', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('lastName')->nullable();
            $table->integer('role_id')->nullable()->unsigned();
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->string('imgProfile')->nullable();
            $table->string('tel')->nullable();
            $table->string('gender')->nullable();
            $table->string('cpf')->nullable();
            $table->string('rg')->nullable();
            $table->string('dateBirth')->nullable();
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
		Schema::drop('responsibles');
	}

}
