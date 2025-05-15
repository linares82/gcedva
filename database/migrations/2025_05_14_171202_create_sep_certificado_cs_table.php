<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSepCertificadoCsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sep_certificado_cs', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('plantel_id')->unsigned();
            $table->integer('empleado_id')->unsigned();
            $table->integer('sep_cargo_id')->unsigned();
            $table->integer('especialidad_id')->unsigned();
            $table->integer('nivel_id')->unsigned();
            $table->integer('grado_id')->unsigned();
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
		Schema::drop('sep_certificado_cs');
	}

}
