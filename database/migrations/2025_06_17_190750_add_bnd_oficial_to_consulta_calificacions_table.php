<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBndOficialToConsultaCalificacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('consulta_calificacions', function (Blueprint $table) {
            $table->integer('bnd_oficial')->nullable();
            $table->string('nombre_oficial')->nullable();
            $table->string('id_asignatura')->nullable();
            $table->string('nombre_asignatura')->nullable();
            $table->string('ciclo')->nullable();
            $table->string('id_observaciones')->nullable();
            $table->string('observaciones')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('consulta_calificacions', function (Blueprint $table) {
            //
        });
    }
}
