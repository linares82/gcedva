<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProspectoAsignacionTareasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('prospecto_asignacion_tareas', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('prospecto_id')->unsigned()->nullable();
            $table->integer('empleado_id')->unsigned()->nullable();
            $table->integer('prospecto_tarea_id')->unsigned()->nullable();
            $table->integer('prospecto_asunto_id')->unsigned()->nullable();
            $table->integer('prospecto_st_tarea_id')->unsigned()->nullable();
            $table->text('obs')->nullable();
			$table->text('detalle')->nullable();
            $table->integer('usu_alta_id')->unsigned();
            $table->integer('usu_mod_id')->unsigned();
            $table->timestamps();      
			$table->softDeletes();
			$table->foreign('usu_alta_id')->references('id')->on('users');
			$table->foreign('usu_mod_id')->references('id')->on('users');
			$table->foreign('prospecto_st_tarea_id')->references('id')->on('prospecto_st_tareas');
			$table->foreign('prospecto_asunto_id')->references('id')->on('prospecto_asuntos');
			$table->foreign('prospecto_tarea_id')->references('id')->on('prospecto_tareas');
			$table->foreign('empleado_id')->references('id')->on('empleados');
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
		Schema::drop('prospecto_asignacion_tareas');
	}

}
