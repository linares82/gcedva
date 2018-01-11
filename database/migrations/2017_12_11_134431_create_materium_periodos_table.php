<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMateriumPeriodosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    Schema::create('materium_periodos', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('materium_id')->unsigned();
            $table->integer('periodo_estudio_id')->unsigned();
            $table->integer('usu_alta_id')->unsigned()->nullable();
            $table->integer('usu_mod_id')->unsigned()->nullable();
            $table->timestamps();
            $table->foreign('materium_id')->references('id')->on('materia');
            $table->foreign('periodo_estudio_id')->references('id')->on('periodo_estudios');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('materium_periodos');
	}

}
