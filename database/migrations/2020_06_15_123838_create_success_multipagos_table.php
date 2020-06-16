<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuccessMultipagosTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('success_multipagos', function (Blueprint $table) {
			$table->increments('id');
			$table->string('mp_order');
			$table->index('mp_order');
			$table->string('mp_reference');
			$table->decimal('mp_amount');
			$table->string('mp_response');
			$table->text('mp_responsemsg');
			$table->string('mp_authorization');
			$table->text('mp_signature');
			$table->integer(' usu_alta_id')->unsigned();
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
		Schema::drop('success_multipagos');
	}
}
