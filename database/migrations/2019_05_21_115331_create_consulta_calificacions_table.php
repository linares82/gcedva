<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsultaCalificacionsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('consulta_calificacions', function (Blueprint $table) {
			$table->increments('id');
			$table->string('matricula')->nullable();
			$table->index('matricula');
			$table->string('periodo_escolar')->nullable();
			$table->string('materia')->nullable();
			$table->string('codigo')->nullable();
			$table->string('creditos', 10, 2)->nullable();
			$table->string('lectivo')->nullable();
			$table->decimal('calificacion', 10, 2)->nullable();
			$table->string('tipo_examen')->nullable();
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
		Schema::drop('consulta_calificacions');
	}
}
