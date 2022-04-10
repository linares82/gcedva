<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCaptacionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('captacions', function(Blueprint $table) {
            $table->increments('id');
            $table->string('plantel')->nullable();
            $table->string('nombre')->nullable();
            $table->string('nombre2')->nullable();
            $table->string('ape_paterno')->nullable();
            $table->string('ape_materno')->nullable();
            $table->string('mail')->nullable();
            $table->string('tel_cel')->nullable();
            $table->string('tel_fijo')->nullable();
            $table->string('pais')->nullable();
			$table->text('comen_obs')->nullable();
            $table->integer('medio_id')->unsigned();
            $table->integer('usu_alta_id')->unsigned();
            $table->integer('usu_mod_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
			$table->foreign('usu_alta_id')->references('id')->on('users');
			$table->foreign('usu_mod_id')->references('id')->on('users');
			$table->foreign('medio_id')->references('id')->on('medios');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('captacions');
	}

}
