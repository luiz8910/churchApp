<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCreditCardsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('credit_cards', function(Blueprint $table) {
            $table->increments('id');
			$table->integer('owner_id'); //person_id
            $table->string('person_name');
            $table->string('number');
            $table->string('expires_in');
            $table->string('cvc');
            $table->string('company')->nullable();
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
		Schema::drop('credit_cards');
	}

}
