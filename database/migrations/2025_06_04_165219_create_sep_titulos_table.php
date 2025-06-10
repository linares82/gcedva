<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSepTitulosTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sep_titulos', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('plantel_id')->unsigned()->nullable();
			$table->integer('especialidad_id')->unsigned()->nullable();
			$table->integer('nivel_id')->unsigned()->nullable();
			$table->integer('grado_id')->unsigned()->nullable();
			$table->integer('lectivo_id')->unsigned()->nullable();
			$table->integer('grupo_id')->unsigned()->nullable();
			$table->integer('r1_sep_cargo_id')->unsigned()->nullable();
			$table->string('r1_titulo')->nullable();
			$table->integer('r1_id')->unsigned()->nullable();
			$table->integer('r2_sep_cargo_id')->unsigned()->nullable();
			$table->string('r2_titulo')->nullable();
			$table->integer('r2_id')->unsigned()->nullable();
			$table->integer('usu_alta_id')->unsigned();
			$table->integer('usu_mod_id')->unsigned();
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('usu_alta_id')->references('id')->on('users');
			$table->foreign('usu_mod_id')->references('id')->on('users');
			$table->foreign('r2_sep_cargo_id')->references('id')->on('sep_cargos');
			$table->foreign('r1_sep_cargo_id')->references('id')->on('sep_cargos');
			$table->foreign('r1_id')->references('id')->on('empleados');
			$table->foreign('r2_id')->references('id')->on('empleados');
			$table->foreign('plantel_id')->references('id')->on('plantels');
			$table->foreign('especialidad_id')->references('id')->on('especialidads');
			$table->foreign('nivel_id')->references('id')->on('nivels');
			$table->foreign('grado_id')->references('id')->on('grados');
			$table->foreign('lectivo_id')->references('id')->on('lectivos');
			$table->foreign('grupo_id')->references('id')->on('grupos');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('sep_titulos');
	}
}
