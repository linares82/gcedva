<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncidencesClientesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('incidences_clientes', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('cliente_id')->unsigned();
            $table->integer('incidence_cliente_id')->unsigned();
            $table->string('detalle')->nullable();
            $table->date('fecha')->nullable();
            $table->integer('usu_alta_id')->unsigned();
            $table->integer('usu_mod_id')->unsigned();
            $table->timestamps();
			$table->softDeletes();
			$table->foreign('usu_alta_id')->references('id')->on('users');
			$table->foreign('usu_mod_id')->references('id')->on('users');
			$table->foreign('incidence_cliente_id')->references('id')->on('incidence_clientes');
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
		Schema::drop('incidences_clientes');
	}

}
