<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreditCard extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credit_cards', function (Blueprint $table){
           $table->increments('id');
           $table->integer('person_id');
           $table->string('card_token')->nullable();
           $table->integer('status')->nullable();
           $table->integer('type')->nullable();
           $table->integer('lastDigits')->nullable();
           $table->string('expirationDate')->nullable();
           $table->integer('brandId')->nullable();
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
        //
    }
}
