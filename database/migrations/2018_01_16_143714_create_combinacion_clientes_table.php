<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCombinacionClientesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    Schema::create('combinacion_clientes', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('cliente_id')->unsigned();
            $table->integer('plantel_id')->unsigned();
            $table->integer('especialidad_id')->unsigned();
            $table->integer('nivel_id')->unsigned();
            $table->integer('grado_id')->unsigned();
            $table->integer('turno_id')->unsigned();
            $table->integer('bnd_inscrito')->default(0);
            $table->date('fecha_incrito')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('turno_id')->references('id')->on('turnos');
            $table->foreign('grado_id')->references('id')->on('grados');
            $table->foreign('nivel_id')->references('id')->on('nivels');
            $table->foreign('especialidad_id')->references('id')->on('especialidads');
            $table->foreign('plantel_id')->references('id')->on('plantels');
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
		Schema::drop('combinacion_clientes');
	}

}
