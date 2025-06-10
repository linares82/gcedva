<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProcedenciaAlumnosTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('procedencia_alumnos', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('cliente_id')->unsigned()->nullable();
			$table->string('institucion_procedencia')->nullable();
			$table->integer('sep_t_estudio_antecedente_id')->unsigned()->nullable();
			$table->integer('estado_id')->unsigned()->nullable();
			$table->date('fecha_inicio')->nullable();
			$table->date('fecha_terminacion')->nullable();
			$table->string('numero_cedula')->nullable();
			$table->integer('usu_alta_id')->unsigned();
			$table->integer('usu_mod_id')->unsigned();
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('usu_alta_id')->references('id')->on('users');
			$table->foreign('usu_mod_id')->references('id')->on('users');
			$table->foreign('estado_id')->references('id')->on('estados');
			$table->foreign('sep_t_estudio_antecedente_id')->references('id')->on('sep_t_estudio_antecedentes');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('procedencia_alumnos');
	}
}
