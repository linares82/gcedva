<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncidenciasCalificacionsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('incidencias_calificacions', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('calificacion_id')->unsigned()->nullable();
			$table->integer('hacademica_id')->unsigned()->nullable();
			$table->integer('materium_id')->unsigned()->nullable();
			$table->integer('calificacion_ponderacion_id')->unsigned()->nullable();
			$table->integer('cliente_id')->unsigned()->nullable();
			$table->float('calificacion_nueva')->unsigned()->nullable();
			$table->text('justificacion')->nullable();
			$table->text('observacion')->nullable();
			$table->integer('bnd_autorizada')->unsigned()->nullable();
			$table->integer('bnd_rechazada')->unsigned()->nullable();
			$table->date('fecha_ar')->nullable();
			$table->integer('usu_alta_id')->unsigned();
			$table->integer('usu_mod_id')->unsigned();
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('usu_alta_id')->references('id')->on('users');
			$table->foreign('usu_mod_id')->references('id')->on('users');
			$table->foreign('cliente_id')->references('id')->on('clientes');
			$table->foreign('calificacion_ponderacion_id')->references('id')->on('calificacion_ponderacions');
			$table->foreign('calificacion_id')->references('id')->on('calificacions');
			$table->foreign('hacademica_id')->references('id')->on('hacademicas');
			$table->foreign('materium_id')->references('id')->on('materia');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('incidencias_calificacions');
	}
}
