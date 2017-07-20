<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropChurchIdVisitors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("visitors", function (Blueprint $table){
           $table->dropColumn("church_id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("visitors", function (Blueprint $table){
            $table->integer("church_id")->nullable()->unsigned();
            $table->foreign("church_id")->references('id')->on('churches');
        });
    }
}
