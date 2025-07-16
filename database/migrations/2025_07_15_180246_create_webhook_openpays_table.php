<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebhookOpenpaysTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('webhook_openpays', function (Blueprint $table) {
			$table->increments('id');
			$table->string('openpay_id')->nullable();
			$table->string('type')->nullable();
			$table->string('verification_code')->nullable();
			$table->string('event_date')->nullbale();
			$table->integer('usu_alta_id')->unsigned()->nullbale();
			$table->integer('usu_mod_id')->unsigned()->nullbale();
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
		Schema::drop('webhook_openpays');
	}
}
