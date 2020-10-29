<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacturaGeneralLineasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('factura_general_lineas', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('factura_general_id')->unsigned();
            $table->integer('cliente_id')->unsigned();
            $table->integer('caja_id')->unsigned();
            $table->integer('pago_id')->unsigned();
            $table->integer('bnd_incluido')->unsigned()->default(0);
            $table->integer('usu_alta_id')->unsigned();
            $table->integer('usu_mod_id')->unsigned();
            $table->timestamps();
			$table->softDeletes();
			$table->foreign('usu_alta_id')->references('id')->on('users');
			$table->foreign('usu_mod_id')->references('id')->on('users');
			$table->foreign('pago_id')->references('id')->on('pagos');
			$table->foreign('caja_id')->references('id')->on('cajas');
			$table->foreign('cliente_id')->references('id')->on('clientes');
			$table->foreign('factura_general_id')->references('id')->on('factura_generals');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('factura_general_lineas');
	}

}
