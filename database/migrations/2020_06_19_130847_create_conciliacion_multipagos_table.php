<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConciliacionMultipagosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('conciliacion_multipagos', function(Blueprint $table) {
            $table->increments('id');
            $table->date('fecha_carga');
            $table->string('archivo');
            $table->integer('registros');
            $table->integer('contador_ejecucion');
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
		Schema::drop('conciliacion_multipagos');
	}

}
