<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSerieFolioSimplificadosTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('serie_folio_simplificados', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('cuenta_p_id')->unsigned();
			$table->string('serie');
			$table->integer('folio_inicial')->unsigned();
			$table->integer('folio_actual')->unsigned()->nullable();
			$table->integer('anio')->unsigned();
			$table->integer('mese_id')->unsigned();
			$table->integer('bnd_activo')->unsigend();
			$table->integer('bnd_fiscal')->unsigend();
			$table->integer('usu_alta_id')->unsigned();
			$table->integer('usu_mod_id')->unsigned();
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('usu_alta_id')->references('id')->on('users');
			$table->foreign('usu_mod_id')->references('id')->on('users');
			$table->foreign('mes_id')->references('id')->on('mese');
			$table->foreign('cuenta_p_id')->references('id')->on('cuenta_ps');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('serie_folio_simplificados');
	}
}
