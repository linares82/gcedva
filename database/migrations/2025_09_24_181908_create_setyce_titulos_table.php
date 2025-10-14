<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSetyceTitulosTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setyce_titulos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('setyce_id')->nullable();
            $table->integer('setyce_lote_id')->unsigned()->nullable();
            $table->integer('cliente_id')->unsigned()->nullable();
            $table->string('carrera')->nullable();
            $table->date('fecha_inicio')->nullable();
            $table->date('fechat_terminacion')->nullable();
            $table->string('folio')->nullable();
            $table->string('curp')->nullable();
            $table->string('nombre')->nullable();
            $table->string('primer_apellido')->nullable();
            $table->string('segundo_apellido')->nullable();
            $table->string('correo_electronico')->nullable();
            $table->date('fecha_expedicion')->nullable();
            $table->integer('sep_modalidad_titulacion_id')->unsigned()->nullable();
            $table->date('fecha_examen_profesional')->nullable();
            $table->integer('cumplio_servicio_social')->nullable();
            $table->integer('sep_fundamento_legal_servicio_social_id')->unsigned()->nullable();
            $table->integer('sep_t_estudio_antecedente_id')->unsigned()->nullable();
            $table->integer('entidad_expedicion')->unsigned()->nullable();
            $table->string('institucion_procedencia')->nullable();
            $table->integer('entidad_antecedente')->unsigned()->nullable();
            $table->date('fecha_inicio_antecedente')->nullable();
            $table->date('fecha_terminoa_antecedente')->nullable();
            $table->string('no_cedula')->nullable();
            $table->integer('usu_alta_id')->unsigned();
            $table->integer('usu_mod_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('usu_alta_id')->references('id')->on('usuario_clientes');
            $table->foreign('usu_mod_id')->references('id')->on('usuario_clientes');
            $table->foreign('setyce_lote_id')->references('id')->on('setyce_lotes');
            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->foreign('sep_modalidad_titulacion_id')->references('id')->on('sep_modalidad_titulacions');
            $table->foreign('sep_fundamento_legal_servicio_social_id')->references('id')->on('sep_fundamento_legal_servicio_socials');
            $table->foreign('sep_t_estudio_antecedente_id')->references('id')->on('sep_t_estudio_antecedentes');
            $table->foreign('entidad_expedicion')->references('id')->on('estados');
            $table->foreign('entidad_antecedente')->references('id')->on('estados');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('setyce_titulos');
    }
}
