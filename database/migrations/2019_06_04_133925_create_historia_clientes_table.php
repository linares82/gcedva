<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoriaClientesTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('historia_clientes', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('evento_cliente_id')->unsigned();
			$table->string('descripcion');
			$table->date('fecha');
			$table->string('archivo')->nullable();
			$table->integer('cliente_id')->unsigned();
			$table->integer('usu_alta_id')->unsigned();
			$table->integer('usu_mod_id')->unsigned();
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('usu_mod_id')->references('id')->on('users');
			$table->foreign('usu_alta_id')->references('id')->on('users');
			$table->foreign('cliente_id')->references('id')->on('clientes');
			$table->foreign('evento_cliente_id')->references('id')->on('evento_clientes');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('historia_clientes');
	}
}
