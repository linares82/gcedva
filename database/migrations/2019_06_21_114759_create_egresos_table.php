<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEgresosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('egresos', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('plantel_id')->unsigned();
            $table->date('fecha');
            $table->integer('egresos_concepto_id')->unsigned();
            $table->string('detalle')->nullable();
            $table->string('archivo')->nullable();
            $table->string('saldo_inicial', 8, 2);
            $table->integer('forma_pago_id')->unsigned();
            $table->integer('cuentas_efectivo_id')->unsigned();
            $table->double('monto', 8, 2);
            $table->integer('empleado_id')->unsigned();
            $table->integer('usu_alta_id')->unsigned();
            $table->integer('usu_mod_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('usu_mod_id')->references('id')->on('users');
            $table->foreign('usu_alta_id')->references('id')->on('users');
            $table->foreign('empleado_id')->references('id')->on('empleados');
            $table->foreign('cuentas_efectivo_id')->references('id')->on('cuentas_efectivos');
            $table->foreign('forma_pago_id')->references('id')->on('forma_pagos');
            $table->foreign('egresos_concepto_id')->references('id')->on('egresos_conceptos');
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
		Schema::drop('egresos');
	}

}
