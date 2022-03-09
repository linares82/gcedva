<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTitulacionPagosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('titulacion_pagos', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('titulacion_id')->unsigned();
			$table->integer('titulacion_intento_id')->unsigned()->nullable();
            $table->date('fecha');
            $table->double('monto',8,2);
			$table->string('observaciones')->nullable();
            $table->integer('usu_alta_id')->unsigned();
            $table->integer('usu_mod_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
			$table->foreign('usu_alta_id')->references('id')->on('users');
			$table->foreign('usu_mod_id')->references('id')->on('users');
			$table->foreign('titulacion_id')->references('id')->on('titulacions');
			$table->foreign('titulacion_intento_id')->references('id')->on('titulacion_intentos');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('titulacion_pagos');
	}

}
