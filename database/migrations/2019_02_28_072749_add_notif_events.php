<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNotifEvents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_subscribed_lists', function (Blueprint $table){
            $table->integer('notification_activity')->default(1);
            $table->integer('notification_updates')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('event_subscribed_lists', function (Blueprint $table){
            $table->dropColumn('notification_activity');
            $table->dropColumn('notification_updates');
        });
    }
}
