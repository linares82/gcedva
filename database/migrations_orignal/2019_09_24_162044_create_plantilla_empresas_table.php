<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlantillaEmpresasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('plantilla_empresas', function(Blueprint $table) {
            $table->increments('id');
            $table->text('plantilla');
            $table->string('nombre');
            $table->string('detalle');
            $table->string('asunto')->nullable();
            $table->integer('dia')->unsigned()->nullable();
            $table->string('img1')->nullable();
            $table->string('img2')->nullable();
            $table->boolean('activo_bnd');
            $table->boolean('sms_bnd');
            $table->boolean('mail_bnd');
            $table->text('sms')->nullable();
            $table->date('inicio')->nullable();
            $table->date('fin')->nullable();
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
		Schema::drop('plantilla_empresas');
	}

}
