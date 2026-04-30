<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalendarioIncidenciaCalsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('calendario_incidencia_cals', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('lectivo_id')->unsigned()->nullable();
			$table->integer('ponderacion_id')->unsigned()->nullable();
			$table->integer('carga_ponderacion_id')->unsigned()->nullable();
			$table->date('v_inicio')->nullable();
			$table->date('v_fin')->nullable();
			$table->integer('plantel_id')->unsigned()->nullable();
			$table->unsignedInteger('usu_alta_id');
			$table->unsignedInteger('usu_mod_id');
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('usu_mod_id')->references('id')->on('users');
			$table->foreign('usu_alta_id')->references('id')->on('users');
			$table->foreign('plantel_id')->references('id')->on('plantels');
			$table->foreign('carga_ponderacion_id')->references('id')->on('carga_ponderacions');
			$table->foreign('ponderacion_id')->references('id')->on('ponderacions');
			$table->foreign('lectivo_id')->references('id')->on('lectivos');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('calendario_incidencia_cals');
	}
}
