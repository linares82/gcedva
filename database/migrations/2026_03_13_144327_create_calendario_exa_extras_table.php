<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalendarioExaExtrasTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('calendario_exa_extras', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('plantel_id')->unsigned()->nullable();
			$table->integer('duracion_periodo_id')->unsigned()->nullable();
			$table->date('fec_inicio')->nullable();
			$table->date('fec_fin')->nullable();
			$table->unsignedInteger('usu_alta_id');
			$table->unsignedInteger('usu_mod_id');
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('usu_alta_id')->references('id')->on('users');
			$table->foreign('usu_mod_id')->references('id')->on('users');
			$table->foreign('plantel_id')->references('id')->on('plantels');
			$table->foreign('duracion_periodo_id')->references('id')->on('duracion_periodos');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('calendario_exa_extras');
	}
}
