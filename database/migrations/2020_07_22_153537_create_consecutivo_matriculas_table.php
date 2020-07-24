<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsecutivoMatriculasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('consecutivo_matriculas', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('plantel_id')->unsigned();
            $table->integer('anio')->unsigned();
            $table->integer('mes')->unsigned();
            $table->string('seccion');
            $table->integer('consecutivo')->unsigned();
            $table->integer('usu_alta_id')->unsigned();
            $table->integer('usu_mod_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('consecutivo_matriculas');
	}

}
