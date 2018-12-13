<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEbanxesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ebanxes', function(Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('nombre2');
            $table->string('ape_paterno');
            $table->string('ape_materno');
            $table->string('tel_fijo');
            $table->string('mail');
            $table->integer('plantel_id')->unsigned();
            $table->integer('medio_id')->unsigned();
            $table->integer('empleado_id')->unsigned();
            $table->string('observaciones');
            $table->integer('estado_id')->unsigned();
            $table->integer('municipio_id')->unsigned();
            $table->integer('st_cliente_id')->unsigned();
            $table->integer('especialidad_id')->unsigned();
            $table->integer('especialidad2_id')->unsigned();
            $table->integer('especialidad3_id')->unsigned();
            $table->integer('especialidad4_id')->unsigned();
            $table->integer('nivel_id')->unsigned();
            $table->integer('diplomado_id')->unsigned();
            $table->integer('curso_id')->unsigned();
            $table->integer('otro_id')->unsigned();
            $table->integer('grado_id')->unsigned();
            $table->integer('subdiplomado_id')->unsigned();
            $table->integer('subotro_id')->unsigned();
            $table->integer('turno_id')->unsigned();
            $table->integer('turno2_id')->unsigned();
            $table->integer('turno3_id')->unsigned();
            $table->integer('turno4_id')->unsigned();
            $table->integer('ofertum_id')->unsigned();
            $table->string('matricula');
            $table->integer('ciclo_id')->unsigned();
            $table->integer('empresa_id')->unsigned();
            $table->string('cve_cliente');
            $table->string('tel_cel');
            $table->integer('paise_id')->unsigned();
            $table->integer('bnd_pagado')->unsigned();
            $table->integer('fecha_pago');
            $table->integer('bnd_procesado')->unsigned();
            $table->integer('fecha_procesado');
            $table->integer('usu_alta_id')->unsigned();
            $table->integer('usu_mod_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('usu_mod_id')->references('id')->on('users');
            $table->foreign('usu_alta_id')->references('id')->on('users');
            $table->foreign('paise_id')->references('id')->on('paises');
            $table->foreign('grado_id')->references('id')->on('grados');
            $table->foreign('nivel_id')->references('id')->on('nivels');
            $table->foreign('especialidad_id')->references('id')->on('especialidads');
            $table->foreign('plantel_id')->references('id')->on('plantels');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ebanxes');
	}

}
