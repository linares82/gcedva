<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHCambiosCajasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('h_cambios_cajas', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('caja_id')->unsigned();
			$table->string('campo');
            $table->string('valor_anterior')->nullable();
            $table->string('valor_nuevo')->nullable();
            $table->integer('user_id')->unsigned();
            $table->integer('usu_alta_id')->unsigned();
            $table->integer('usu_mod_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
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
		Schema::drop('h_cambios_cajas');
	}

}
