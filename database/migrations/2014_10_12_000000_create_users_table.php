<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('church_id');
            $table->integer('person_id')->unique()->nullable()->unsigned();
            $table->foreign('person_id')->references('id')->on('people')->onDelete('cascade');
            $table->string('facebook_id')->unique()->nullable();
            $table->string('linkedin_id')->unique()->nullable();
            $table->string('google_id')->unique()->nullable();
            $table->string('twitter_id')->unique()->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::drop('users');
    }
}
