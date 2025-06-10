<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSepFundamentoLegalServicioSocialsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sep_fundamento_legal_servicio_socials', function (Blueprint $table) {
			$table->increments('id');
			$table->string('id_fundamento_legal_servicio_social');
			$table->string('fundamento_legal_servicio_social');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('sep_fundamento_legal_servicio_socials');
	}
}
