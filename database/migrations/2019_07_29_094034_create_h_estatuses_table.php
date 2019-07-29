<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHEstatusesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('h_estatuses', function(Blueprint $table) {
            $table->increments('id');
            $table->string('tabla');
            $table->integer('cliente_id')->unsigned();
            $table->integer('seguimiento_id')->unsigned();
            $table->string('estatus');
            $table->integer('estatus_id')->unsigned();
            $table->date('fecha');
            $table->integer('usu_alta_id')->unsigned();
            $table->integer('usu_mod_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->index('cliente_id');
            $table->index('seguimiento_id');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('h_estatuses');
	}

}
