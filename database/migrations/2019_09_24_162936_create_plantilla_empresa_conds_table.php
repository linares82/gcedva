<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlantillaEmpresaCondsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('plantilla_empresa_conds', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('plantilla_empresa_id')->unsigned();
            $table->string('operador_condicion');
            $table->integer('plantilla_empresa_campo_id')->unsigned();
            $table->string('signo_comparacion');
            $table->string('valor_condicion');
            $table->string('interpretacion');
			$table->integer('usu_alta_id')->unsigned();
			$table->integer('usu_mod_id')->unsigned();
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('usu_mod_id')->references('id')->on('users');
			$table->foreign('usu_alta_id')->references('id')->on('users');
			$table->foreign('plantilla_empresa_campo_id')->references('id')->on('plantilla_empresa_campos');
			$table->foreign('plantilla_empresa_id')->references('id')->on('plantilla_empresas');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('plantilla_empresa_conds');
	}

}
