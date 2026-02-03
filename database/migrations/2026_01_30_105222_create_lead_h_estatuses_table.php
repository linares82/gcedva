<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeadHEstatusesTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('lead_h_estatuses', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('lead_id')->unsigned()->nullable();
			$table->integer('anterior_st_lead_id')->unsigned()->nullable();
			$table->integer('nuevo_st_lead_id')->unsigned()->nullable();
			$table->date('fecha')->nullable();
			$table->unsignedInteger('usu_alta_id');
			$table->unsignedInteger('usu_mod_id');
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('usu_alta_id')->references('id')->on('users');
			$table->foreign('usu_mod_id')->references('id')->on('users');
			$table->foreign('anterior_st_lead_id')->references('id')->on('st_leads');
			$table->foreign('nuevo_st_lead_id')->references('id')->on('st_leads');
			$table->foreign('lead_id')->references('id')->on('leads');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('lead_h_estatuses');
	}
}
