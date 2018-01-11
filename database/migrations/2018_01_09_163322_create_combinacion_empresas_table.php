<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCombinacionEmpresasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
            Schema::create('combinacion_empresas', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('empresa_id')->unsigned();
            $table->integer('plantel_id')->unsigned();
            $table->integer('especialidad_id')->unsigned();
            $table->integer('nivel_id')->unsigned();
            $table->integer('grado_id')->unsigned();
            $table->integer('usu_alta_id')->unsigned();
            $table->integer('usu_mod_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('usu_mod_id')->references('id')->on('users');
            $table->foreign('usu_alta_id')->references('id')->on('users');
            $table->foreign('grado_id')->references('id')->on('grados');
            $table->foreign('nivel_id')->references('id')->on('nivels');
            $table->foreign('especialidad_id')->references('id')->on('especialidads');
            $table->foreign('plantel_id')->references('id')->on('plantels');
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
		Schema::drop('combinacion_empresas');
	}

}
