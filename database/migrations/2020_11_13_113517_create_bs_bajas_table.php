<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBsBajasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bs_bajas', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('cliente_id')->unsigned();
            $table->date('fecha_baja');
            $table->integer('bnd_baja');
            $table->date('fecha_reactivar');
            $table->integer('bnd_reactivar');
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
		Schema::drop('bs_bajas');
	}

}
