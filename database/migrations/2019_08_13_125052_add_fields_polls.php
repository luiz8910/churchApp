<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsPolls extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('polls', function (Blueprint $table){
            $table->string('order')->nullable();
            $table->string('content')->nullable();
            $table->integer('session_id')->nullable();
            $table->string('name')->change()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('polls', function (Blueprint $table){
            $table->dropColumn('order');
            $table->dropColumn('content');
            $table->dropColumn('session_id');
        });
    }
}
