<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSetyceLotesTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('setyce_lotes', function (Blueprint $table) {
			$table->increments('id');
			$table->string('setyce_id')->nullable();
			$table->text('clientes')->nullable();
			$table->integer('titulacion_grupo_id')->unsigned()->nullable();
			$table->string('name');
			$table->integer('usu_alta_id')->unsigned();
			$table->integer('usu_mod_id')->unsigned();
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('usu_alta_id')->references('id')->on('usuario_clientes');
			$table->foreign('usu_mod_id')->references('id')->on('usuario_clientes');
			$table->foreign('titulacion_grupo_id')->references('id')->on('titulacion_grupos');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('setyce_lotes');
	}
}
