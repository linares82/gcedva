<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevolucionesCajasTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('devoluciones_cajas', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('caja_id')->unsigned()->nullable();
			$table->integer('cliente_id')->unsigned()->nullable();
			$table->integer('plantel_id')->unsigned()->nullable();
			$table->float('monto');
			$table->integer('caja_concepto_id')->unsigned()->nullable();
			$table->integer('grado_id')->unsigned()->nullable();
			$table->integer('motivos_dev_caja_id')->unsigned()->nullable();
			$table->integer('st_dev_caja_id')->unsigned()->nullable();
			$table->string('vobo')->nullable();
			$table->text('obs')->nullable();
			$table->unsignedInteger('usu_alta_id');
			$table->unsignedInteger('usu_mod_id');
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('usu_mod_id')->references('id')->on('users');
			$table->foreign('usu_alta_id')->references('id')->on('users');
			$table->foreign('motivos_dev_caja_id')->references('id')->on('motivos_dev_cajas');
			$table->foreign('grado_id')->references('id')->on('grados');
			$table->foreign('caja_concepto_id')->references('id')->on('caja_conceptos');
			$table->foreign('plantel_id')->references('id')->on('plantels');
			$table->foreign('cliente_id')->references('id')->on('clientes');
			$table->foreign('caja_id')->references('id')->on('cajas');
			$table->foreign('st_dev_caja_id')->references('id')->on('st_dev_cajas');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('devoluciones_cajas');
	}
}
