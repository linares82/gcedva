<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSepCarrerasTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sep_carreras', function (Blueprint $table) {
			$table->increments('id');
			$table->string('cve_carrera');
			$table->string('descripcion');
			$table->string('id_area');
			$table->string('area');
			$table->string('cve_subarea');
			$table->string('subarea');
			$table->string('id_nivel_sirep');
			$table->string('nivel_educativo');
			$table->string('num_rvoe');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('sep_carreras');
	}
}
