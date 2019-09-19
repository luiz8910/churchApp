<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateInvoiceItensTable.
 */
class CreateInvoiceItensTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('invoice_itens', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('invoice_id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('price');
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
		Schema::drop('invoice_itens');
	}
}
