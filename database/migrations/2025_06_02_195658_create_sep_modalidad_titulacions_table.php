<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSepModalidadTitulacionsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sep_modalidad_titulacions', function (Blueprint $table) {
			$table->increments('id');
			$table->string('id_modalidad');
			$table->string('descripcion');
			$table->string('tipo_modalidad');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('sep_modalidad_titulacions');
	}
}
