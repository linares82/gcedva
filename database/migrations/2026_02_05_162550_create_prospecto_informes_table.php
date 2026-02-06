<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProspectoInformesTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('prospecto_informes', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('prospecto_id')->unsigned()->nullable();
			$table->integer('prospecto_parte_informe_id')->unsigned()->nullable();
			$table->integer('prospecto_etiqueta_id')->unsigned();
			$table->text('detalle')->nullable();
			$table->unsignedInteger('usu_alta_id');
			$table->unsignedInteger('usu_mod_id');
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('usu_alta_id')->references('id')->on('users');
			$table->foreign('usu_mod_id')->references('id')->on('users');
			$table->foreign('prospecto_id')->references('id')->on('prospectos');
			$table->foreign('prospecto_parte_informe_id')->references('id')->on('prospecto_parte_informes');
			$table->foreign('prospecto_etiqueta_id')->references('id')->on('prospecto_etiquetas');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('prospecto_informes');
	}
}
