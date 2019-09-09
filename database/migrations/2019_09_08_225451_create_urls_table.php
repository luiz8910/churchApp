<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateUrlsTable.
 */
class CreateUrlsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('urls', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('url');
            $table->decimal('value_money');
            $table->dateTime('expires_in');
            $table->integer('pay_method');
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
		Schema::drop('urls');
	}
}
