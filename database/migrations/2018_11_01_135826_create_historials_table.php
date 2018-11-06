<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistorialsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('historials', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('historia_evento_id')->unsigned();
            $table->string('descripcion');
            $table->date('fecha');
            $table->string('archivo')->nullable();
            $table->integer('empleado_id')->unsigned();
            $table->integer('usu_alta_id')->unsigned();
            $table->integer('usu_mod_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('usu_mod_id')->references('id')->on('users');
            $table->foreign('usu_alta_id')->references('id')->on('users');
            $table->foreign('empleado_id')->references('id')->on('empleados');
            $table->foreign('historia_evento_id')->references('id')->on('historia_eventos');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('historials');
	}

}
