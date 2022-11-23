<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProspectoHactividadsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('prospecto_hactividads', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('prospecto_id')->unsigned();
            $table->integer('prospecto_seguimiento_id')->unsigned();
            $table->string('tarea')->nullable();
            $table->date('fecha')->nullable();
            $table->time('hora');
            $table->string('asunto');
            $table->string('detalle');
            $table->integer('usu_alta_id')->unsigned();
            $table->integer('usu_mod_id')->unsigned();
            $table->timestamps();      
			$table->softDeletes();
			$table->foreign('usu_alta_id')->references('id')->on('users');
			$table->foreign('usu_mod_id')->references('id')->on('users');
			$table->foreign('prospecto_seguimiento_id')->references('id')->on('prospecto_seguimientos');
			$table->foreign('prospecto_id')->references('id')->on('prospectos');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('prospecto_hactividads');
	}

}
