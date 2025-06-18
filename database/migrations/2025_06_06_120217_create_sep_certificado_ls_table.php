<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSepCertificadoLsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sep_certificado_ls', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('sep_certificado_id')->unsigned()->nullable();
			$table->integer('cliente_id')->unsigned()->nullable();
			$table->integer('hacademica_id')->unsigned()->nullable();
			$table->integer('materium_id')->unsigned()->nullable();
			$table->integer('lectivo_id')->unsigned()->nullable();
			$table->integer('sep_cert_tipo_id')->unsigned()->nullable();
			$table->date('fecha_expedicion')->nullable();
			$table->string('id_carrera')->nullable();
			$table->string('id_asignatura')->nullable();
			$table->string('numero_asignaturas_cursadas')->nullable();
			$table->string('promedio_general')->nullable();
			$table->integer('sep_cert_observacion_id')->unsigned()->nullable();
			$table->integer('bnd_descargar')->unsigned()->nullable();
			$table->float('calificacion_materia', 10, 2)->unsigned()->nullable();
			$table->integer('usu_alta_id')->unsigned();
			$table->integer('usu_mod_id')->unsigned();
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('usu_alta_id')->references('id')->on('users');
			$table->foreign('usu_mod_id')->references('id')->on('users');
			$table->foreign('sep_cert_observacion_id')->references('id')->on('sep_cert_observacions');
			$table->foreign('sep_cert_tipo_id')->references('id')->on('sep_cert_tipos');
			$table->foreign('hacademica_id')->references('id')->on('hacademicas');
			$table->foreign('materium_id')->references('id')->on('materia');
			$table->foreign('lectivo_id')->references('id')->on('lectivos');
			$table->foreign('cliente_id')->references('id')->on('clientes');
			$table->foreign('sep_certificado_id')->references('id')->on('sep_certificados');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('sep_certificado_ls');
	}
}
