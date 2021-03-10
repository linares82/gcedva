<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProspectosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('prospectos', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('cliente_id')->nullable();
            $table->index('cliente_id');
            $table->string('nombre')->nullable();
            $table->string('nombre2')->nullable();
            $table->string('ape_paterno')->nullable();
            $table->string('ape_materno')->nullable();
            $table->string('tel_fijo')->nullable();
            $table->string('tel_cel')->nullable();
            $table->string('mail')->nullable();
            $table->integer('plantel_id')->unsigned();
            $table->integer('especialidad_id')->unsigned();
            $table->integer('nivel_id')->unsigned();
            $table->integer('medio_id')->unsigned();
            $table->integer('st_prospecto_id')->unsigned();
            $table->integer('usu_alta_id')->unsigned();
            $table->integer('usu_mod_id')->unsigned();
            $table->timestamps();
			$table->softDeletes();
			$table->foreign('usu_alta_id')->references('id')->on('users');
			$table->foreign('usu_mod_id')->references('id')->on('users');
            $table->foreign('st_prospecto_id')->references('id')->on('st_prospectos');
            $table->foreign('medio_id')->references('id')->on('medios');
            $table->foreign('nivel_id')->references('id')->on('nivels');
            $table->foreign('especialidad_id')->references('id')->on('especialidads');
            $table->foreign('plantel_id')->references('id')->on('plantels');

        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('prospectos');
	}

}
