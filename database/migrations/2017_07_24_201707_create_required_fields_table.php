<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequiredFieldsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('required_fields', function(Blueprint $table) {
            $table->increments('id');
            $table->string('model');
            $table->string('value');
            $table->string('field');
            $table->boolean('required')->default(null)->nullable();
            $table->integer('church_id');
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
		Schema::drop('required_fields');
	}

}
