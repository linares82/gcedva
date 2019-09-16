<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovimientosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('movimientos', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('plantel_id')->unsigned();
            $table->integer('articulo_id')->unsigned();
            $table->integer('cantidad');
            $table->date('fecha');
            $table->integer('entrada_salida_id')->unsigned();
            $table->integer('usu_alta_id')->unsigned();
            $table->integer('usu_mod_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('usu_mod_id')->references('id')->on('users');
            $table->foreign('usu_alta_id')->references('id')->on('users');
            $table->foreign('entrada_salida_id')->references('id')->on('entrada_salidas');
            $table->foreign('articulo_id')->references('id')->on('articulos');
            $table->foreign('plantel_id')->references('id')->on('plantels');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('movimientos');
	}

}
