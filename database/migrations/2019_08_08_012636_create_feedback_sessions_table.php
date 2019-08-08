<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateFeedbackSessionsTable.
 */
class CreateFeedbackSessionsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('feedback_sessions', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('type_feedback')->nullable();
            $table->integer('rating')->nullable();
            $table->text('comment')->nullable();
            $table->integer('person_id');
            $table->integer('session_id');
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
		Schema::drop('feedback_sessions');
	}
}
