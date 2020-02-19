<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoriClienteInscripcionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('histori_cliente_inscripcions', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('historia_cliente_id')->unsigned();
            $table->integer('inscripcion_id')->unsigned();
            $table->integer('usu_alta_id')->unsigned();
            $table->integer('usu_mod_id')->unsigned();
            $table->timestamps();
			$table->softDeletes();
			$table->foreign('historia_cliente_id')->references('id')->on('historia_clientes');
			$table->foreign('inscripcion_id')->references('id')->on('inscripcions');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('histori_cliente_inscripcions');
	}

}
