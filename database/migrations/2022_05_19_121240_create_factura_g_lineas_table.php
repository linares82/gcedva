<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacturaGLineasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('factura_g_lineas', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('factura_g_id')->unsigned();
			$table->integer('bnd_incluido')->unsigned()->nullable();
            $table->date('fecha_operacion');
            $table->string('concepto');
            $table->string('referencia');
            $table->string('referencia_ampliada');
            $table->double('cargo',10,2)->nullable();
            $table->double('abono',10,2)->nullable();
            $table->double('saldo',10,2);
			$table->string('ultimo_error')->nullable();
            $table->integer('usu_alta_id')->unsigned();
            $table->integer('usu_mod_id')->unsigned();
            $table->timestamps();      
			$table->softDeletes();
			$table->foreign('usu_alta_id')->references('id')->on('users');
			$table->foreign('usu_mod_id')->references('id')->on('users');      
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('factura_g_lineas');
	}

}
