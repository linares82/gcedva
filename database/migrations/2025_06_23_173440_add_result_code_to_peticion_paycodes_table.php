<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddResultCodeToPeticionPaycodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('peticion_paycodes', function (Blueprint $table) {
            $table->string('card_type')->nullable();
            $table->string('result_code')->nullable();
            $table->string('card_4_digits')->nullable();
            $table->integer('bnd_conciliado')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('peticion_paycodes', function (Blueprint $table) {
            //
        });
    }
}
