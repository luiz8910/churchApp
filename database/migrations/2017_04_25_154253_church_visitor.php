<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChurchVisitor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('church_visitor', function (Blueprint $table){
            $table->integer('church_id')->unsigned();
            $table->foreign('church_id')->references('id')->on('churches');

            $table->integer('visitor_id')->unsigned();
            $table->foreign('visitor_id')->references('id')->on('visitors');

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
        Schema::drop('church_visitor');
    }
}
