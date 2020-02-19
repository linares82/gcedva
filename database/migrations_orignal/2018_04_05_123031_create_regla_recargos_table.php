<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReglaRecargosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('regla_recargos', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('dia_inicio');
            $table->integer('dia_fin');
            $table->integer('tipo_regla_id')->unsigned();
            $table->float('porcentaje')->nullable();
            $table->float('monto')->nullable();
            $table->integer('usu_alta_id')->unsigned();
            $table->integer('usu_mod_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('usu_mod_id')->references('id')->on('users');
            $table->foreign('usu_alta_id')->references('id')->on('users');
            $table->foreign('tipo_regla_id')->references('id')->on('tipo_reglas');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('regla_recargos');
	}

}
