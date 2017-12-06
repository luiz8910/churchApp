<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GroupVisitorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_visitor', function(Blueprint $table){
            $table->integer('group_id')->unsigned();
            $table->foreign('group_id')->references('id')->on('groups');

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
        Schema::drop('group_visitor');
    }
}
