<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSepTituloLsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sep_titulo_ls', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('sep_titulo_id')->unsigned()->nullable();
			$table->integer('cliente_id')->unsigned()->nullable();
			$table->integer('bnd_descargar')->unsigned()->nullable();
			$table->integer('usu_alta_id')->unsigned();
			$table->integer('usu_mod_id')->unsigned();
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('usu_alta_id')->references('id')->on('users');
			$table->foreign('usu_mod_id')->references('id')->on('users');
			$table->foreign('cliente_id')->references('id')->on('clientes');
			$table->foreign('sep_titulo_id')->references('id')->on('sep_titulos');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('sep_titulo_ls');
	}
}
