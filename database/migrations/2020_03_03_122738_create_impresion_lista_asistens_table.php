<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImpresionListaAsistensTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('impresion_lista_asistens', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('asignacion_id')->unsigned();
            $table->integer('inscritos')->unsigned();
            $table->date('fecha_f');
            $table->date('fecha_t');
            $table->string('token');
            $table->integer('usu_alta_id')->unsigned();
            $table->integer('usu_mod_id')->unsigned();
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
		Schema::drop('impresion_lista_asistens');
	}

}
