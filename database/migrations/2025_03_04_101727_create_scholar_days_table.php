<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScholarDaysTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('scholar_days', function(Blueprint $table) {
            $table->increments('id');
			$table->integer('jornada_id')->unsigned()->nullable();
            $table->integer('dia_id')->unsigned()->nullable();
			$table->time('h_inicio')->nullable();
			$table->time('h_fin')->nullable();
            $table->integer('usu_alta_id')->unsigned();
            $table->integer('usu_mod_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
			$table->foreign('usu_alta_id')->references('id')->on('users');
			$table->foreign('usu_mod_id')->references('id')->on('users');
			$table->foreign('jornada_id')->references('id')->on('jornadas');
			$table->foreign('dia_id')->references('id')->on('dias');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('scholar_days');
	}

}
