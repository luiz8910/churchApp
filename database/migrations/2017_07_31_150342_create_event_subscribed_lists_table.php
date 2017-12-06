<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventSubscribedListsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('event_subscribed_lists', function(Blueprint $table) {
            $table->increments('id');

            $table->integer('event_id')->unsigned();
            $table->foreign('event_id')->references('id')->on('events');

            $table->integer('person_id')->unsigned()->nullable();
            $table->foreign('person_id')->references('id')->on('people');

            $table->integer('sub_by')->unsigned();

            $table->integer('church_id')->unsigned();
            $table->foreign('church_id')->references('id')->on('churches');

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
		Schema::drop('event_subscribed_lists');
	}

}
