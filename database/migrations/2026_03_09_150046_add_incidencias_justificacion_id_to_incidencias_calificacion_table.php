<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIncidenciasJustificacionIdToIncidenciasCalificacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('incidencias_calificacions', function (Blueprint $table) {
            $table->integer('incidencias_justificacion_id')->unsigned()->nullable();
            $table->foreign('incidencias_justificacion_id')->references('id')->on('incidencias_justificacions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('incidencias_calificacion', function (Blueprint $table) {
            //
        });
    }
}
