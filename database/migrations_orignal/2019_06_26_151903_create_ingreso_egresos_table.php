<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIngresoEgresosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ingreso_egresos', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('plantel_id')->unsigned();
            $table->integer('cuenta_efectivo_id')->unsigned();
            $table->integer('pago_id')->unsigned();
            $table->integer('consecutivo_caja')->unsigned();
            $table->integer('egreso_id')->unsigned();
            $table->string('concepto')->nullable();
            $table->date('fecha');
            $table->double('monto');
            $table->integer('usu_alta_id')->unsigned();
            $table->integer('usu_mod_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('usu_mod_id')->references('id')->on('users');
            $table->foreign('usu_alta_id')->references('id')->on('users');
            $table->foreign('cuenta_efectivo_id')->references('id')->on('cuentas_efectivos');
            $table->foreign('plantel_id')->references('id')->on('plantels');
            $table->index('egreso_id');
            $table->index('pago_id');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ingreso_egresos');
	}

}
