<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLeadToProspectosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('prospectos', function (Blueprint $table) {
            $table->unsignedInteger('lead_id')->nullable();
            $table->string('escuela_procedencia')->nullable();
            $table->unsignedInteger('sep_t_estudio_antecedente_id')->nullable()->after('escuela_procedencia');
            $table->unsignedInteger('tipo_escuela_procedencia_id')->nullable();
            $table->string('ciclo_interesado')->nullable();
            $table->foreign('lead_id')->references('id')->on('leads');
            $table->foreign('sep_t_estudio_antecedente_id')->references('id')->on('sep_t_estudio_antecedentes');
            $table->foreign('tipo_escuela_procedencia_id')->references('id')->on('tipo_escuela_procedencias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prospectos', function (Blueprint $table) {
            //
        });
    }
}
