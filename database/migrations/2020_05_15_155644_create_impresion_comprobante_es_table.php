<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImpresionComprobanteEsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('impresion_comprobante_es', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('inscripcion_id')->unsigned();
			$table->integer('cliente_id')->unsigned();
			$table->integer('plantel_id')->unsigned();
			$table->integer('especialidad_id')->unsigned();
			$table->integer('nivel_id')->unsigned();
			$table->integer('grado_id')->unsigned();
			$table->integer('grupo_id')->unsigned();
			$table->integer('turno_id')->unsigned();
			$table->integer('lectivo_id')->unsigned();
			$table->integer('periodo_estudio_id')->unsigned();
			$table->string('token');
			$table->integer('usu_alta_id')->unsigned();
			$table->integer('usu_mod_id')->unsigned();
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
		Schema::drop('impresion_comprobante_es');
	}
}
