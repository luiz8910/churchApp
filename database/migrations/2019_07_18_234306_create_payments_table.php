<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreatePaymentsTable.
 */
class CreatePaymentsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('payments', function(Blueprint $table) {
            $table->increments('id');
            $table->string('transactionId');
            $table->string('metaId');
            $table->integer('status');
            $table->string('antiFraude_success');
            $table->string('antiFraude_validator');
            $table->decimal('antiFraude_score');
            $table->string('antiFraude_recommendation');
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
		Schema::drop('payments');
	}
}
