<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTitulacionDocumentacionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('titulacion_documentacions', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('titulacion_id')->unsigned();
            $table->integer('titulacion_documento_id')->unsigned();
            $table->string('archivo');
            $table->integer('usu_alta_id')->unsigned();
            $table->integer('usu_mod_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
			$table->foreign('usu_alta_id')->references('id')->on('users');
			$table->foreign('usu_mod_id')->references('id')->on('users');
			$table->foreign('titulacion_id')->references('id')->on('titulacions');
			$table->foreign('titulacion_documento_id')->references('id')->on('titulacion_documentos');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('titulacion_documentacions');
	}

}
