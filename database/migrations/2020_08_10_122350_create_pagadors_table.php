<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagadorsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pagadors', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
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
		Schema::drop('pagadors');
	}

}
