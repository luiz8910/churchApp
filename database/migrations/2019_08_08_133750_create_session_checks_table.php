<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateSessionChecksTable.
 */
class CreateSessionChecksTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('session_checks', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('session_id');
            $table->integer('person_id');
            $table->integer('check-in');
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
		Schema::drop('session_checks');
	}
}
