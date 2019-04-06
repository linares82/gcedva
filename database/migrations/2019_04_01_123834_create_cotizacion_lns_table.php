<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCotizacionLnsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cotizacion_lns', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('cotizacion_curso_id')->unsigned();
            $table->integer('consecutivo')->unsigned();
            $table->integer('st_curso_empresa_id')->unsigned();
            $table->integer('cursos_empresa_id')->unsigned();
            $table->integer('tipo_precio_coti_id')->unsigned();
            $table->integer('cantidad')->unsigned();
            $table->float('precio',8,2)->default(0);
            $table->float('total',8,2)->default(0)->unsigned();
            $table->float('descuento',8,2)->default(0)->unsigned();
            $table->integer('usu_alta_id')->unsigned();
            $table->integer('usu_mod_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('usu_mod_id')->references('id')->on('users');
            $table->foreign('usu_alta_id')->references('id')->on('users');
            $table->foreign('tipo_precio_coti_id')->references('id')->on('tipo_precio_cotis');
            $table->foreign('cursos_empresa_id')->references('id')->on('cursos_empresas');
            $table->foreign('cotizacion_curso_id')->references('id')->on('cotizacion_cursos');
            $table->foreign('st_curso_empresa_id')->references('id')->on('st_curso_empresas');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cotizacion_lns');
	}

}
