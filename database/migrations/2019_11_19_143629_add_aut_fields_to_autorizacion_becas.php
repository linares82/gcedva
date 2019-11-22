<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAutFieldsToAutorizacionBecas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('autorizacion_becas', function (Blueprint $table) {
            $table->integer('aut_caja_plantel')->integer()->default(0);
            $table->integer('aut_dir_plantel')->integer()->default(0);
            $table->integer('aut_caja_corp')->integer()->default(0);
            $table->integer('aut_ser_esc')->integer()->default(0);
            $table->integer('aut_dueno')->integer()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
