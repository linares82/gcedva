<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSepTEstudioAntecedentesTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sep_t_estudio_antecedentes', function (Blueprint $table) {
			$table->increments('id');
			$table->string('id_t_estudio_antecedente');
			$table->string('t_estudio_antecedente');
			$table->string('tipo_educativo');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('sep_t_estudio_antecedentes');
	}
}
