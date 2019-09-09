<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreatePaymentSlipsTable.
 */
class CreatePaymentSlipsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('payment_slips', function(Blueprint $table) {
            $table->increments('id');
            $table->string('uuid')->nullable();
            $table->string('bank')->nullable();
            $table->dateTime('due_date')->nullable();
            $table->string('bar_code')->nullable();
            $table->string('typeable_line')->nullable();
            $table->integer('our_number')->nullable();
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
		Schema::drop('payment_slips');
	}
}
