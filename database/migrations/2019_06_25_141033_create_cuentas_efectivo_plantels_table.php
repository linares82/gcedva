<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCuentasEfectivoPlantelsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cuentas_efectivo_plantels', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('cuentas_efectivo_id')->unsigned();
			$table->integer('plantel_id')->unsigned();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cuentas_efectivo_plantels');
	}
}
