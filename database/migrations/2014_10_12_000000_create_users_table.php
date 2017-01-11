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
            $table->string('facebook_id')->unique()->nullable();
            $table->string('linkedin_id')->unique()->nullable();
            $table->string('google_id')->unique()->nullable();
            $table->string('twitter_id')->unique()->nullable();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->string('imgProfile');
            $table->string('tel')->nullable();
            $table->string('role')->nullable();
            $table->string('gender')->nullable();
            $table->date('dateBirth')->nullable();
            $table->string('cpf')->nullable();
            $table->string('street')->nullable();
            $table->string('neighborhood')->nullable();
            $table->string('city')->nullable();
            $table->string('zipCode')->nullable();
            $table->string('state')->nullable();
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
