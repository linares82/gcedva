<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeadsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('leads', function (Blueprint $table) {
			$table->increments('id');
			$table->string('nombre')->nullable();
			$table->string('nombre2')->nullable();
			$table->string('ape_paterno')->nullable();
			$table->string('ape_materno')->nullable();
			$table->string('tel_fijo')->nullable();
			$table->string('tel_cel')->nullable();
			$table->string('email')->nullable();
			$table->unsignedInteger('medio_id')->nullable();
			$table->string('ciclo_interesado')->nullable();
			$table->text('observaciones')->nullable();
			$table->integer('contador_llamadas')->default(0);
			$table->unsignedInteger('st_lead_id')->nullable();
			$table->unsignedInteger('usu_alta_id');
			$table->unsignedInteger('usu_mod_id');
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('usu_alta_id')->references('id')->on('users');
			$table->foreign('usu_mod_id')->references('id')->on('users');
			$table->foreign('medio_id')->references('id')->on('medios');
			$table->foreign('st_lead_id')->references('id')->on('st_leads');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('leads');
	}
}
