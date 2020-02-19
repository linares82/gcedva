<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGrupoPeriodoEstudiosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
            Schema::create('grupo_periodo_estudios', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('grupo_id')->unsigned();
            $table->integer('periodo_estudio_id')->unsigned();
            $table->timestamps();
            $table->foreign('grupo_id')->references('id')->on('grupos');
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
		Schema::drop('grupo_periodo_estudios');
	}

}
