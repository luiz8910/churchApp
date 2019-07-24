<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNullableFieldsPayment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payments', function (Blueprint $table){
            $table->string('antiFraude_success')->nullable()->change();
            $table->string('antiFraude_validator')->nullable()->change();
            $table->string('antiFraude_score')->nullable()->change();
            $table->string('antiFraude_recommendation')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
