<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSepAutorizacionReconocimientosTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sep_autorizacion_reconocimientos', function (Blueprint $table) {
			$table->increments('id');
			$table->string('id_autorizacion_reconocimiento');
			$table->string('autorizacion_reconocimiento');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('sep_autorizacion_reconocimientos');
	}
}
