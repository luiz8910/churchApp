<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateAllowedPaymentsTable.
 */
class CreateAllowedPaymentsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('allowed_payments', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('event_id');
            $table->integer('payment_method_id');
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
		Schema::drop('allowed_payments');
	}
}
