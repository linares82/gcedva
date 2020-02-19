<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCcuestionarioRespuestasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ccuestionario_respuesta', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('ccuestionario_id')->unsigned();
            $table->integer('ccuestionario_preguntum_id')->unsigned();
            $table->string('clave');
            $table->string('name');
            $table->integer('usu_alta_id')->unsigned();
            $table->integer('usu_mod_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('usu_mod_id')->references('id')->on('users');
            $table->foreign('usu_alta_id')->references('id')->on('users');
            $table->foreign('ccuestionario_preguntum_id')->references('id')->on('ccuestionario_pregunta');
            $table->foreign('ccuestionario_id')->references('id')->on('ccuestionarios');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ccuestionario_respuestas');
	}

}
