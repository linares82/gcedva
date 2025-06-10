<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSepCertObservacionsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sep_cert_observacions', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('id_observacion')->unsigned()->nullable();
			$table->string('descripcion')->nullable();
			$table->string('descripcion_corta')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('sep_cert_observacions');
	}
}
