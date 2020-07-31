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
			$table->string('matricula')->nullable();
			$table->integer('adeudo_id')->unsigned()->nullable();
			$table->index('adeudo_id');
			$table->integer('pago_id')->unsigned()->nullable();
			$table->index('pago_id');
			$table->integer('caja_id')->unsigned()->nullable();
			$table->index('caja_id');
			$table->integer('caja_ln_id')->unsigned()->nullable();
			$table->index('caja_ln_id');
			$table->integer('peticion_multipago_id')->unsigned()->nullable();
			$table->index('peticion_multipago_id');
			$table->decimal('subtotal')->nullable();
			$table->decimal('descuento')->nullable();
			$table->decimal('recargo')->nullable();
			$table->decimal('total')->nullable();
			$table->date('fecha_limite')->nullable();
			$table->integer('cliente_id')->unsigned();
			$table->index('cliente_id');
			$table->integer('plantel_id')->unsigned();
			$table->index('plantel_id');
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
