<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSepHomologacionToOpcionTitulacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('opcion_titulacions', function (Blueprint $table) {
            $table->integer('sep_modalidad_titulacion_id')->unsigned()->nullable();
            $table->foreign('sep_modalidad_titulacion_id')->references('id')->on('sep_modalidad_titulacions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('opcion_titulacions', function (Blueprint $table) {
            //
        });
    }
}
