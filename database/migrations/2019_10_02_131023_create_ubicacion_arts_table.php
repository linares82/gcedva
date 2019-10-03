<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUbicacionArtsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ubicacion_arts', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('plantel_id')->unsigned();
            $table->string('ubicacion');
			$table->integer('usu_alta_id')->unsigned();
			$table->integer('usu_mod_id')->unsigned();
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('usu_mod_id')->references('id')->on('users');
			$table->foreign('usu_alta_id')->references('id')->on('users');
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
		Schema::drop('ubicacion_arts');
	}

}
