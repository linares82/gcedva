<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCajasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cajas', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('cliente_id')->unsigned();
            $table->integer('plantel_id')->unsigned();
            $table->float('subtotal');
            $table->float('descuento');
            $table->float('recargo');
            $table->float('total');
            $table->integer('forma_pago_id')->unsigned();
            $table->string('autorizacion_descuento')->nullable();
            $table->date('fecha');
            $table->integer('st_caja_id')->unsigned();
            $table->integer('usu_alta_id')->unsigned();
            $table->integer('usu_mod_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('usu_mod_id')->references('id')->on('users');
            $table->foreign('usu_alta_id')->references('id')->on('users');
            $table->foreign('st_caja_id')->references('id')->on('st_cajas');
            $table->foreign('forma_pago_id')->references('id')->on('forma_pagos');
            $table->foreign('plantel_id')->references('id')->on('plantels');
            $table->foreign('cliente_id')->references('id')->on('clientes');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cajas');
	}

}
