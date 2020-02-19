<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCotizacionCursosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cotizacion_cursos', function(Blueprint $table) {
            $table->increments('id');
            $table->string('no_coti');
            $table->integer('empresa_id')->unsigned();
            $table->date('fecha');
            $table->float('subtotal',8,2)->default(0);
            $table->float('descuento',8,2)->default(0);
            $table->float('iva',8,2)->default(0);
            $table->float('total',8,2)->default(0);
            $table->text('observaciones');
            $table->integer('st_curso_empresa_id')->unsigned();
            $table->integer('usu_alta_id')->unsigned();
            $table->integer('usu_mod_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('usu_mod_id')->references('id')->on('users');
            $table->foreign('usu_alta_id')->references('id')->on('users');
            $table->foreign('st_curso_empresa_id')->references('id')->on('st_curso_empresas');
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
		Schema::drop('cotizacion_cursos');
	}

}
