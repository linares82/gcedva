<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDocenteOficialIdToAsignacionAcademicasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('asignacion_academicas', function (Blueprint $table) {
            $table->integer('docente_oficial_id')->unsigned();
            $table->index('docente_oficial_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('asignacion_academicas', function (Blueprint $table) {
            //
        });
    }
}
