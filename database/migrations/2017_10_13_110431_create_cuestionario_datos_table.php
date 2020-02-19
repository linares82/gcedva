<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCuestionarioDatosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cuestionario_datos', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('empresa_id')->unsigned();
            $table->integer('cuestionario_id')->unsigned();
            $table->integer('cuestionario_pregunta_id')->unsigned();
            $table->integer('cuestionario_respuesta_id')->unsigned();
            $table->string('name');
            $table->integer('usu_alta_id')->unsigned();
            $table->integer('usu_mod_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('usu_mod_id')->references('id')->on('users');
            $table->foreign('usu_alta_id')->references('id')->on('users');
            $table->foreign('cuestionario_pregunta_id')->references('id')->on('cuestionario_preguntas');
            $table->foreign('cuestionario_id')->references('id')->on('cuestionarios');
            $table->foreign('cuestionario_respuesta_id')->references('id')->on('cuestionario_respuestas');
            $table->foreign('empresa_id')->references('id')->on('empresas');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cuestionario_datos');
	}

}
