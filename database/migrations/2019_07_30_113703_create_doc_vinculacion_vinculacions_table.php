<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocVinculacionVinculacionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('doc_vinculacion_vinculacions', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('doc_vinculacion_id')->unsigned();
            $table->integer('vinculacion_id')->unsigned();
            $table->string('archivo')->nullable();
            $table->integer('usu_alta_id')->unsigned();
            $table->integer('usu_mod_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('usu_mod_id')->references('id')->on('users');
            $table->foreign('usu_alta_id')->references('id')->on('users');
            $table->foreign('vinculacion_id')->references('id')->on('vinculacions');
            $table->foreign('doc_vinculacion_id')->references('id')->on('doc_vinculacions');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('doc_vinculacion_vinculacions');
	}

}
