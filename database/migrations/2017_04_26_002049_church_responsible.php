<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChurchResponsible extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('church_responsible', function (Blueprint $table){
            $table->integer('church_id')->unsigned();
            $table->foreign('church_id')->references("id")->on("churches");

            $table->integer('responsible_id')->unsigned();
            $table->foreign('responsible_id')->references('id')->on("responsibles");

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
        Schema::drop('church_responsible');
    }
}
