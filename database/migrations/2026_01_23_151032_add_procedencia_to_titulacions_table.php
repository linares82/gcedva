<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProcedenciaToTitulacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('titulacions', function (Blueprint $table) {
            $table->string('institucion_procedencia')->nullable();
            $table->integer('sep_t_estudio_antecedente_id')->unsigned()->nullable();
            $table->integer('estado_procedencia_id')->unsigned()->nullable();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_terminacion')->nullable();
            $table->string('numero_cedula')->nullable();
            $table->foreign('estado_procedencia_id')->references('id')->on('estados');
            $table->foreign('sep_t_estudio_antecedente_id')->references('id')->on('sep_t_estudio_antecedentes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('titulacions', function (Blueprint $table) {
            //
        });
    }
}
