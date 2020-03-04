<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHCalifPonderacionsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('h_calif_ponderacions', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('calificacion_ponderacion_id')->unsigned();
			$table->integer('calificacion_id')->unsigned();
			$table->integer('carga_ponderacion_id')->unsigned();
			$table->decimal('calificacion_parcial', 8, 2)->default(0);
			$table->decimal('calificacion_parcial_calculada', 8, 2)->default(0);
			$table->decimal('ponderacion', 8, 2)->default(0);
			$table->integer('tiene_detalle')->default(0);
			$table->integer('padre_id')->unsigned();
			$table->integer('usu_alta_id')->unsigned();
			$table->integer('usu_mod_id')->unsigned();
			$table->timestamps();
			$table->softDeletes();
			$table->index('padre_id');
			$table->index('carga_ponderacion_id');
			$table->index('calificacion_id');
			$table->index('calificacion_ponderacion_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('h_calif_ponderacions');
	}
}
