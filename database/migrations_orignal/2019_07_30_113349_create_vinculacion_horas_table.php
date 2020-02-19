<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVinculacionHorasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('vinculacion_horas', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('vinculacion_id')->unsigned();
            $table->date('fec_inicio')->nullable();
            $table->date('fec_fin')->nullable();
            $table->integer('horas')->nullable();
            $table->string('fv6')->nullable();
            $table->integer('usu_alta_id')->unsigned();
            $table->integer('usu_mod_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('usu_mod_id')->references('id')->on('users');
            $table->foreign('usu_alta_id')->references('id')->on('users');
            $table->foreign('vinculacion_id')->references('id')->on('vinculacions');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('vinculacion_horas');
	}

}
