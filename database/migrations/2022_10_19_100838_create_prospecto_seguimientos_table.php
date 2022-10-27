<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProspectoSeguimientosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('prospecto_seguimientos', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('prospecto_id')->unsigned()->nullable();
            $table->integer('prospecto_st_seg_id')->unsigned()->nullable();
            $table->integer('mes')->unsigned();
            $table->integer('contador_sms')->unsigned();
            $table->integer('usu_alta_id')->unsigned();
            $table->integer('usu_mod_id')->unsigned();
            $table->timestamps();      
			$table->softDeletes();
			$table->foreign('usu_alta_id')->references('id')->on('users');
			$table->foreign('usu_mod_id')->references('id')->on('users');
			$table->foreign('prospecto_st_seg_id')->references('id')->on('prospecto_st_segs');
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
		Schema::drop('prospecto_seguimientos');
	}

}
