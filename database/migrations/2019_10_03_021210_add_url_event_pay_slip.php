<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUrlEventPaySlip extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_slips', function (Blueprint $table){
            $table->integer('event_id')->nullable();
            $table->integer('url_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payment_slips', function (Blueprint $table){
            $table->dropColumn('event_id');
            $table->dropColumn('url_id');
        });
    }
}
