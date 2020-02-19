<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComenMueblesTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('comen_muebles', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('mueble_id')->unsigned();
			$table->integer('st_mueble_id')->unsigned();
			$table->string('obs');
			$table->integer('usu_alta_id')->unsigned();
			$table->integer('usu_mod_id')->unsigned();
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('usu_alta_id')->references('id')->on('users');
			$table->foreign('usu_mod_id')->references('id')->on('users');
			$table->foreign('st_mueble_id')->references('id')->on('st_muebles');
			$table->foreign('mueble_id')->references('id')->on('muebles');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('comen_muebles');
	}
}
