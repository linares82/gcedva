<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsultaCalificacionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('consulta_calificacions', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('cliente_id')->nullable();
            $table->string('horario')->nullable();
            $table->string('materia')->nullable();
            $table->string('modulo')->nullable();
            $table->string('instructor')->nullable();
            $table->string('clave')->nullable();
            $table->string('apellido_paterno')->nullable();
            $table->string('apellido_materno')->nullable();
            $table->string('nombre')->nullable();
            $table->float('calif_final')->nullable();
            $table->integer('usu_alta_id')->unsigned();
            $table->integer('usu_mod_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->index('cliente_id');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('consulta_calificacions');
	}

}
