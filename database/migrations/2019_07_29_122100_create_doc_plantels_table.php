<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocPlantelsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('doc_plantels', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->boolean('bnd_obligatorio');
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
		Schema::drop('doc_plantels');
	}

}
