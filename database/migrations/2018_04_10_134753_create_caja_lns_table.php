<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCajaLnsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('caja_lns', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('caja_id')->unsigned();
            $table->integer('caja_concepto_id')->unsigned();
            $table->float('subtotal');
            $table->float('descuento');
            $table->float('recargo');
            $table->float('total');
            $table->string('autorizacion_descuento')->nullable();
            $table->integer('adeudo_id')->unsigned();
            $table->integer('usu_alta_id')->unsigned();
            $table->integer('usu_mod_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('usu_mod_id')->references('id')->on('users');
            $table->foreign('usu_alta_id')->references('id')->on('users');
            $table->foreign('caja_concepto_id')->references('id')->on('caja_conceptos');
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
		Schema::drop('caja_lns');
	}

}
