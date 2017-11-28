<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGeofencesTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('geofences', function(Blueprint $table) {
            $table->increments('id');
			$table->integer('event_id');
            $table->integer('user_id');
            $table->string('lat');
            $table->string('long');
            $table->boolean('active')->default(1);
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
		Schema::drop('geofences');
	}

}
