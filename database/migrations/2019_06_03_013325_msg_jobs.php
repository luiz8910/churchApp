<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MsgJobs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('msg_jobs', function (Blueprint $table){
            $table->increments('id');
            $table->integer('person_id');
            $table->string('channel');
            $table->integer('responseCode');
            $table->string('responseText');
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
        Schema::drop('msg_jobs');
    }
}
