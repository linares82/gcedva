<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdeudoPagoOnLinesTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('adeudo_pago_on_lines', function (Blueprint $table) {
			$table->increments('id');
			$table->string('matricula);
			$table->integer('adeudo_id')->unsigned();
			$table->integer('pago_id')->unsigned();
			$table->integer('caja_id')->unsigned();
			$table->decimal('subtotal')->nullable();
			$table->decimal('descuento')->nullable();
			$table->decimal('recargo')->nullable();
			$table->integer('cliente_id')->unsigned();
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
		Schema::drop('adeudo_pago_on_lines');
	}
}
