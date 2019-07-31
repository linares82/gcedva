<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVinculacionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('vinculacions', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('cliente_id')->unsigned();
            $table->string('lugar_practica')->nullable();
            $table->string('tel_fijo')->nullable();
            $table->string('nombre_contacto')->nullable();
            $table->string('mail_contacto')->nullable();
            $table->date('fec_inicio')->nullable();
            $table->date('fec_fin')->nullable();
            $table->boolean('bnd_constancia_entregada')->nullable();
            $table->integer('usu_alta_id')->unsigned();
            $table->integer('usu_mod_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('usu_mod_id')->references('id')->on('users');
            $table->foreign('usu_alta_id')->references('id')->on('users');
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
		Schema::drop('vinculacions');
	}

}
