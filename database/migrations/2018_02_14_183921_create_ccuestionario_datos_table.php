<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCcuestionarioDatosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ccuestionario_datos', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('cliente_id')->unsigned();
            $table->integer('ccuestionario_id')->unsigned();
            $table->integer('ccuestionario_pregunta_id')->unsigned();
            $table->integer('ccuestionario_respuesta_id')->unsigned();
            $table->string('clave');
            $table->string('name');
            $table->integer('usu_alta_id')->unsigned();
            $table->integer('usu_mod_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('usu_mod_id')->references('id')->on('users');
            $table->foreign('usu_alta_id')->references('id')->on('users');
            $table->foreign('ccuestionario_pregunta_id')->references('id')->on('ccuestionario_pregunta');
            $table->foreign('ccuestionario_id')->references('id')->on('ccuestionarios');
            $table->foreign('ccuestionario_respuesta_id')->references('id')->on('ccuestionario_respuesta');
            $table->foreign('cliente_id')->references('id')->on('clientes');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ccuestionario_datos');
	}

}
