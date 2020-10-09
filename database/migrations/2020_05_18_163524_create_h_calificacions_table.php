<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHCalificacionsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('h_calificacions', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('cliente_id')->unsigned();
			$table->index('cliente_id');
			$table->integer('calificacion_id')->unsigned();
			$table->index('calificacion_id');
			$table->integer('calificacion_ponderacion_id')->unsigned();
			$table->index('calificacion_ponderacion_id');
			$table->integer('carga_ponderacion_id')->unsigned();
			$table->index('carga_ponderacion_id');
			$table->decimal('calificacion_parcial_anterior', 8, 3);
			$table->decimal('calificacion_parcial_actual', 8, 3);
			$table->integer('usu_alta_id')->unsigned();
			$table->integer('usu_mod_id')->unsigned();
			$table->foreign('usu_mod_id')->references('id')->on('users');
			$table->foreign('usu_alta_id')->references('id')->on('users');
			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('h_calificacions');
	}
}
