<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacturaCotizacionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('factura_cotizacions', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('cotizacion_curso_id')->unsigned();
            $table->string('no_factura');
            $table->date('fecha');
            $table->float('monto');
            $table->integer('forma_pago_id')->unsigned();
            $table->integer('usu_alta_id')->unsigned();
            $table->integer('usu_mod_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('usu_mod_id')->references('id')->on('users');
            $table->foreign('usu_alta_id')->references('id')->on('users');
            $table->foreign('forma_pago_id')->references('id')->on('forma_pagos');
            $table->foreign('cotizacion_curso_id')->references('id')->on('cotizacion_cursos');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('factura_cotizacions');
	}

}
