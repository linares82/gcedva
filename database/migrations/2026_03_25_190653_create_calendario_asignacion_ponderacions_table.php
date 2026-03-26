<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalendarioAsignacionPonderacionsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('calendario_asignacion_ponderacions', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('asignacion_id')->unsigned()->nullable();
			$table->integer('carga_ponderacion_id')->unsigned()->nullable();
			$table->date('fec_inicio')->nullable();
			$table->date('fec_fin')->nullable();
			$table->unsignedInteger('usu_alta_id');
			$table->unsignedInteger('usu_mod_id');
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('usu_alta_id')->references('id')->on('users');
			$table->foreign('usu_mod_id')->references('id')->on('users');
			$table->foreign('carga_ponderacion_id')->references('id')->on('carga_ponderacions');
			$table->foreign('asignacion_id')->references('id')->on('asignacion_academicas');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('calendario_asignacion_ponderacions');
	}
}
