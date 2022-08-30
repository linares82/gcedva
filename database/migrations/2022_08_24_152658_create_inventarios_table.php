<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventariosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('inventarios', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('plantel_id')->unsigned()->nullable();
            $table->string('area')->nullable();
            $table->string('escuela')->nullable();
            $table->string('tipo_inventario')->nullable();
            $table->string('ubicacion')->nullable();
            $table->string('cantidad')->nullable();
            $table->string('nombre')->nullable();
            $table->string('medida')->nullable();
            $table->string('marca')->nullable();
            $table->string('observaciones')->nullable();
            $table->string('existe_si')->nullable();
            $table->string('existe_no')->nullable();
            $table->string('estado_bueno')->nullable();
            $table->string('estado_malo')->nullable();
            $table->integer('usu_alta_id')->unsigned();
            $table->integer('usu_mod_id')->unsigned();
            $table->timestamps();      
			$table->softDeletes();
			$table->foreign('usu_alta_id')->references('id')->on('users');
			$table->foreign('usu_mod_id')->references('id')->on('users');
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
		Schema::drop('inventarios');
	}

}
