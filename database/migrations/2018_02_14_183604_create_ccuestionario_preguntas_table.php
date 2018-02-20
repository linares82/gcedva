<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCcuestionarioPreguntasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ccuestionario_pregunta', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('ccuestionario_id')->unsigned();
            $table->integer('numero')->unsigned();
            $table->string('name');
            $table->integer('usu_alta_id')->unsigned();
            $table->integer('usu_mod_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('usu_mod_id')->references('id')->on('users');
            $table->foreign('usu_alta_id')->references('id')->on('users');
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
		Schema::drop('ccuestionario_preguntas');
	}

}
