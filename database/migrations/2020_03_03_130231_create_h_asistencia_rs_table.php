<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHAsistenciaRsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('h_asistencia_rs', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('asistencia_r_id')->unsigned();
			$table->integer('asignacion_academica_id')->unsigned();
			$table->date('fecha');
			$table->integer('cliente_id')->unsigned();
			$table->integer('est_asistencia_id')->unsigned();
			$table->integer('usu_alta_id')->unsigned();
			$table->integer('usu_mod_id')->unsigned();
			$table->timestamps();
			$table->softDeletes();
			$table->index('asistencia_r_id');
			$table->index('asignacion_academica_id');
			$table->index('cliente_id');
			$table->index('est_asistencia_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('h_asistencia_rs');
	}
}
