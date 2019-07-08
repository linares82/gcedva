<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHCuentasEfectivosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('h_cuentas_efectivos', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('cuentas_efectivo_id')->unsigned();
            $table->double('saldo_inicial',8,2);
            $table->double('saldo_actualizado',8,2);
            $table->date('fecha_saldo_inicial');
            $table->integer('usu_alta_id')->unsigned();
            $table->integer('usu_mod_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('usu_mod_id')->references('id')->on('users');
            $table->foreign('usu_alta_id')->references('id')->on('users');
            $table->foreign('cuentas_efectivo_id')->references('id')->on('cuentas_efectivos');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('h_cuentas_efectivos');
	}

}
