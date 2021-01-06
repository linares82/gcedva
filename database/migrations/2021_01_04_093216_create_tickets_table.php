<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tickets', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('categoria_ticket_id')->unsigned();
			$table->string('nombre_corto');
			$table->text('detalle');
			$table->date('fecha');
			$table->integer('prioridad_ticket_id')->unsigned();
            $table->integer('asignado_a')->unsigned();
            $table->integer('st_ticket_id')->unsigned();
            $table->integer('usu_alta_id')->unsigned();
            $table->integer('usu_mod_id')->unsigned();
            $table->timestamps();
			$table->softDeletes();
			$table->foreign('usu_alta_id')->references('id')->on('users');
			$table->foreign('usu_mod_id')->references('id')->on('users');
			$table->foreign('st_ticket_id')->references('id')->on('st_tickets');
			$table->foreign('asignado_a')->references('id')->on('users');
			$table->foreign('prioridad_id')->references('id')->on('prioridad_tickets');
			$table->foreign('categoria_ticket_id')->references('id')->on('categoria_tickets');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tickets');
	}

}
