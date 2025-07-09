<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrebecasTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('prebecas', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('cliente_id')->unsigned()->nullable();
			$table->integer('motivo_beca_id')->unsigned()->nullable();
			$table->string('obs_prebeca')->nullable();
			$table->integer('porcentaje_beca_id')->unsigned()->nullable();
			$table->integer('usu_alta_id')->unsigned();
			$table->integer('usu_mod_id')->unsigned();
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('usu_alta_id')->references('id')->on('users');
			$table->foreign('usu_mod_id')->references('id')->on('users');
			$table->foreign('porcentaje_beca_id')->references('id')->on('porcentaje_becas');
			$table->foreign('motivo_beca_id')->references('id')->on('motivo_becas');
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
		Schema::drop('prebecas');
	}
}
