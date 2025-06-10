<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSepCertTiposTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sep_cert_tipos', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('id_tipo_certificacion')->unsigned()->nullable();
			$table->string('tipo_certificacion');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('sep_cert_tipos');
	}
}
