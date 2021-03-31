<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHPeticionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('h_peticions', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('peticion_multipagos_id')->unsigned();
			$table->index('peticion_multipagos_id');
            $table->string('campo');
            $table->string('valor_anterior');
            $table->string('valor_nuevo');
            $table->string('usu_alta_id');
            $table->string('usu_mod_id');
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
		Schema::drop('h_peticions');
	}

}
