<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagosLectivosLnsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pagos_lectivos_lns', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('pagos_lectivo_id')->unsigned();
            $table->string('clave');
            $table->string('concepto');
            $table->string('nombre_corto');
            $table->float('monto_mase')->unsigned();
            $table->integer('seriacion_id')->unsigned();
            $table->integer('cuenta_contable_id')->unsigned();
            $table->date('fec_inicio');
            $table->integer('cuenta_contable_recargo_id')->unsigned();
            $table->integer('usu_alta_id')->unsigned();
            $table->integer('usu_mod_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('usu_mod_id')->references('id')->on('users');
            $table->foreign('usu_alta_id')->references('id')->on('users');
            $table->foreign('cuenta_contable_recargo_id')->references('id')->on('cuenta_contables');
            $table->foreign('cuenta_contable_id')->references('id')->on('cuenta_contables');
            $table->foreign('pagos_lectivo_id')->references('id')->on('pagos_lectivos');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('pagos_lectivos_lns');
	}

}
