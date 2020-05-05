<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDocenteLectivoOficialAsignacionAcademicasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('asignacion_academicas', function (Blueprint $table) {
            $table->string('docente_oficial')->nullable();
            $table->integer('lectivo_oficial_id')->unsigned();
            $table->index('lectivo_oficial_id');
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
