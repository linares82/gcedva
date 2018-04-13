<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanPagoLnsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
            Schema::create('plan_pago_lns', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('plan_pago_id')->unsigned();
            $table->integer('caja_concepto_id')->unsigned();
            $table->integer('cuenta_contable_id')->unsigned();
            $table->integer('cuenta_recargo_id')->unsigned();
            $table->date('fecha_pago');
            $table->float('monto');
            $table->boolean('inicial_bnd');
            $table->integer('usu_alta_id')->unsigned();
            $table->integer('usu_mod_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('usu_mod_id')->references('id')->on('users');
            $table->foreign('usu_alta_id')->references('id')->on('users');
            $table->foreign('cuenta_recargo_id')->references('id')->on('cuenta_contables');
            $table->foreign('cuenta_contable_id')->references('id')->on('cuenta_contables');
            $table->foreign('caja_concepto_id')->references('id')->on('caja_conceptos');
            $table->foreign('plan_pago_id')->references('id')->on('plan_pagos');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('plan_pago_lns');
	}

}
