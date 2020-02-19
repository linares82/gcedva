<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegistroHistoriaClientesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('registro_historia_clientes', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('historia_cliente_id')->unsigned();
            $table->integer('st_historia_cliente_id')->unsigned();
            $table->string('comentario');
			$table->integer('usu_alta_id')->unsigned();
			$table->integer('usu_mod_id')->unsigned();
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('usu_mod_id')->references('id')->on('users');
			$table->foreign('usu_alta_id')->references('id')->on('users');
			$table->foreign('st_historia_cliente_id')->references('id')->on('st_historia_clientes');
			$table->foreign('historia_cliente_id')->references('id')->on('historia_clientes');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('registro_historia_clientes');
	}

}
