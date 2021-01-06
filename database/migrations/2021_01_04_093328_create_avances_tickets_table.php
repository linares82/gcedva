<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAvancesTicketsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('avances_tickets', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('ticket_id')->unsigned();
            $table->text('detalle');
            $table->integer('asignado_a')->unsigned();
            $table->integer('st_ticket_id')->unsigned();
            $table->integer('usu_alta_id')->unsigned();
			$table->integer('usu_mod_id')->unsigned();
			$table->integer('bnd_notificacion')->default(0);
			$table->integer('bnd_nota')->default(0);
            $table->timestamps();
			$table->softDeletes();
			$table->foreign('usu_alta_id')->references('id')->on('users');
			$table->foreign('usu_mod_id')->references('id')->on('users');
			$table->foreign('st_ticket_id')->references('id')->on('st_tickets');
			$table->foreign('asignado_a')->references('id')->on('users');
			$table->foreign('ticket_id')->references('id')->on('users');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('avances_tickets');
	}

}
