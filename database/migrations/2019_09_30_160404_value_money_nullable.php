<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ValueMoneyNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('urls', function (Blueprint $table){
            $table->decimal('value_money')->nullable()->change();
            $table->decimal('expires_in')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('urls', function (Blueprint $table){
            $table->decimal('value_money')->change();
            $table->decimal('expires_in')->change();
        });
    }
}
