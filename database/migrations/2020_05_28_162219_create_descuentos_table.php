<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDescuentosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('descuentos', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('adeudo_id')->unsigned();
            $table->decimal('porcentaje',7,3)->default(0.0);
            $table->string('justificacion')->default('');
            $table->integer('autorizado_por')->unsigned();
            $table->date('autorizado_el')->nullable();
            $table->integer('usu_alta_id')->unsigned();
            $table->integer('usu_mod_id')->unsigned();
            $table->timestamps();
			$table->softDeletes();
			$table->foreign('usu_alta_id')->references('id')->on('users');
			$table->foreign('usu_mod_id')->references('id')->on('users');
			$table->foreign('autorizado_por')->references('id')->on('empleados');
			$table->foreign('adeudo_id')->references('id')->on('adeudos');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('descuentos');
	}

}
