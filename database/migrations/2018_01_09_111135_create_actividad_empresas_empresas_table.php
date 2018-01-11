<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActividadEmpresasEmpresasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
            Schema::create('actividad_empresas_empresas', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('actividad_empresa_id')->unsigned();
            $table->integer('empresa_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('actividad_empresa_id')->references('id')->on('actividad_empresas');
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
		Schema::drop('actividad_empresas');
	}

}
