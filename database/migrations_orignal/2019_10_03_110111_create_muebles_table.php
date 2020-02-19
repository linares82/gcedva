<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMueblesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('muebles', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('plantel_id')->unsigned();
            $table->integer('articulo_id')->unsigned();
            $table->date('fecha_alta');
            $table->integer('ubicacion_art_id')->unsigned();
            $table->integer('empleado_id')->unsigned();
            $table->string('marca')->nullable();
            $table->string('modelo')->nullable();
            $table->string('no_serie')->nullable();
            $table->string('observaciones')->nullable();
            $table->integer('st_mueble_id')->unsigned();
            $table->integer('st_mueble_uso_id')->unsigned();
            $table->string('no_inv');
            $table->integer('usu_alta_id')->unsigned();
            $table->integer('usu_mod_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('usu_mod_id')->references('id')->on('users');
            $table->foreign('usu_alta_id')->references('id')->on('users');
            $table->foreign('st_mueble_uso_id')->references('id')->on('st_mueble_usos');
            $table->foreign('st_mueble_id')->references('id')->on('st_muebles');
            $table->foreign('empleado_id')->references('id')->on('empleados');
            $table->foreign('ubicacion_art_id')->references('id')->on('ubicacion_arts');
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
		Schema::drop('muebles');
	}

}
