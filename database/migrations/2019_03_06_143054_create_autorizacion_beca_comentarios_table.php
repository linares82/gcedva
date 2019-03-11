<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutorizacionBecaComentariosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('autorizacion_beca_comentarios', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('autorizacion_beca_id')->unsigned();
            $table->string('comentario')->nullable()->default('');
            $table->decimal('monto_inscripcion')->nullable()->default(0);
            $table->decimal('monto_mensualidad')->nullable()->default(0);
            $table->integer('st_beca_id')->unsigned();
            $table->integer('bnd_visto')->nullable()->unsigned();
            $table->integer('usu_alta_id')->unsigned();
            $table->integer('usu_mod_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('usu_mod_id')->references('id')->on('users');
            $table->foreign('usu_alta_id')->references('id')->on('users');
            $table->foreign('st_beca_id')->references('id')->on('st_becas');
            $table->foreign('autorizacion_beca_id')->references('id')->on('autorizacion_becas');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('autorizacion_beca_comentarios');
	}

}
