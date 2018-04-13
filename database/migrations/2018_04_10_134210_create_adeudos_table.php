<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdeudosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    Schema::create('adeudos', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('cliente_id')->unsigned();
            $table->integer('caja_concepto_id')->unsigned();
            $table->integer('cuenta_contable_id')->unsigned();
            $table->integer('cuenta_recargo_id')->unsigned();
            $table->date('fecha_pago');
            $table->float('monto');
            $table->boolean('inicial_bnd');
            $table->boolean('pagado_bnd')->defaul(0);
            $table->integer('plan_pago_ln_id')->unsigned();
            $table->integer('usu_alta_id')->unsigned();
            $table->integer('usu_mod_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('usu_mod_id')->references('id')->on('users');
            $table->foreign('usu_alta_id')->references('id')->on('users');
            $table->foreign('plan_pago_ln_id')->references('id')->on('plan_pago_lns');
            $table->foreign('cuenta_recargo_id')->references('id')->on('cuenta_contables');
            $table->foreign('cuenta_contable_id')->references('id')->on('cuenta_contables');
            $table->foreign('caja_concepto_id')->references('id')->on('caja_conceptos');
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
		Schema::drop('adeudos');
	}

}
