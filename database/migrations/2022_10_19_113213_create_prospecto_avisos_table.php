<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProspectoAvisosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('prospecto_avisos', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('prospecto_seguimiento_id')->unsigned();
            $table->integer('prospecto_asunto_id')->unsigned();
            $table->string('detalle');
            $table->date('fecha');
            $table->integer('activo')->unsigned();
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
		Schema::drop('prospecto_avisos');
	}

}
