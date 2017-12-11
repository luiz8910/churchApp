<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveChurchIdEventSubList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_subscribed_lists', function(Blueprint $table){
            $table->dropForeign(['church_id']);

            $table->dropColumn(['church_id']);

            //$table->integer('visitor_id')->unsigned()->nullable();

            //$table->foreign('visitor_id')->references('id')->on('visitors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('event_subscribed_lists', function(Blueprint $table){
            $table->integer('church_id')->unsigned();

            $table->foreign('church_id')->references('id')->on('churches');

            $table->dropForeign(['visitor_id']);
        });
    }
}
