<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlantillaEmpresaCamposTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('plantilla_empresa_campos', function(Blueprint $table) {
            $table->increments('id');
            $table->string('campo');
			$table->integer('usu_alta_id')->unsigned();
			$table->integer('usu_mod_id')->unsigned();
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('usu_mod_id')->references('id')->on('users');
			$table->foreign('usu_alta_id')->references('id')->on('users');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('plantilla_empresa_campos');
	}

}
