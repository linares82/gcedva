<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImpresionTicketsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('impresion_tickets', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('caja_id')->unsigned();
			$table->integer('pago_id')->unsigned();
			$table->integer('cliente_id')->unsigned();
			$table->integer('plantel_id')->unsigned();
			$table->integer('consecutivo')->unsigned()->default(0);
			$table->float('monto', 10, 2);
			$table->string('toke_unico');
			$table->integer('usu_alta_id')->unsigned();
			$table->integer('usu_mod_id')->unsigned();
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('usu_alta_id')->references('id')->on('users');
			$table->foreign('usu_mod_id')->references('id')->on('users');
			$table->foreign('cliente_id')->references('id')->on('clientes');
			$table->foreign('plantel_id')->references('id')->on('plantels');
			$table->foreign('pago_id')->references('id')->on('pagos');
			$table->foreign('caja_id')->references('id')->on('cajas');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('impresion_tickets');
	}
}
