<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromoPlanLnsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('promo_plan_lns', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('plan_pago_ln_id')->unsigned();
            $table->date('fec_inicio')->nullable();
            $table->date('fec_fin')->nullable;
            $table->float('descuento',7,3)->default(0);
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
		Schema::drop('promo_plan_lns');
	}

}
