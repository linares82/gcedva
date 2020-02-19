<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransferencesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('transferences', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('origen_id')->unsigned();
            $table->integer('destino_id')->unsigned();
            $table->double('monto');
            $table->date('fecha');
            $table->integer('responsable_id')->unsigned();
            $table->integer('plantel_id')->unsigned();
            $table->integer('plantel_destino_id')->unsigned();
            $table->string('motivo');
            $table->integer('usu_alta_id')->unsigned();
            $table->integer('usu_mod_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('usu_mod_id')->references('id')->on('users');
            $table->foreign('usu_alta_id')->references('id')->on('users');
            $table->foreign('plantel_id')->references('id')->on('plantels');
            $table->foreign('plantel_destino_id')->references('id')->on('plantels');
            $table->foreign('responsable_id')->references('id')->on('empleados');
            $table->foreign('origen_id')->references('id')->on('cuentas_efectivos');
            $table->foreign('destino_id')->references('id')->on('cuentas_efectivos');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('transferences');
	}

}
