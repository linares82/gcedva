<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpresasVinculacionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('empresas_vinculacions', function(Blueprint $table) {
            $table->increments('id');
            $table->string('razon_social');
            $table->string('nombre_contacto');
            $table->string('tel_fijo');
            $table->string('tel_cel');
            $table->string('correo1');
            $table->string('correo2');
            $table->string('direccion');
            $table->integer('usu_alta_id')->unsigned();
            $table->integer('usu_mod_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
			$table->foreign('usu_alta_id')->references('id')->on('users');
			$table->foreign('usu_mod_id')->references('id')->on('users');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('empresas_vinculacions');
	}

}
