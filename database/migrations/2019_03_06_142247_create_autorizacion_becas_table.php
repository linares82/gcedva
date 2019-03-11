<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutorizacionBecasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	Schema::create('autorizacion_becas', function(Blueprint $table) {
            $table->increments('id');
            $table->string('solicitud')->nullable()->default("");
            $table->integer('cliente_id')->unsigned();
            $table->decimal('monto_inscripcion')->nullable()->default(0);
            $table->decimal('monto_mensualidad')->nullable()->default(0);
            $table->integer('st_beca_id')->unsigned();
            $table->integer('usu_alta_id')->unsigned();
            $table->integer('usu_mod_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('usu_mod_id')->references('id')->on('users');
            $table->foreign('usu_alta_id')->references('id')->on('users');
            $table->foreign('st_beca_id')->references('id')->on('st_becas');
            $table->foreign('cliente_id')->references('id')->on('clientes');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('autorizacion_becas');
	}

}
