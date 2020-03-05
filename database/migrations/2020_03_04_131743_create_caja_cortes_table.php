<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCajaCortesTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('caja_cortes', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('plantel_id')->unsigned();
			$table->datetime('fecha');
			$table->double('monto_calculado');
			$table->double('monto_real');
			$table->double('faltante');
			$table->double('sobrante');
			$table->integer('usu_alta_id')->unsigned();
			$table->integer('usu_mod_id')->unsigned();
			$table->foreign('usu_alta_id')->references('id')->on('users');
			$table->foreign('usu_mod_id')->references('id')->on('users');
			$table->foreign('plantel_id')->references('id')->on('plantels');
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
		Schema::drop('caja_cortes');
	}
}
