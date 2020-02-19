<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanCondicionFiltrosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    Schema::create('plan_condicion_filtros', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('plantilla_id')->unsigned();
            $table->string('operador_condicion');
            $table->integer('plan_campo_filtro_id')->unsigned();
            $table->string('signo_comparacion');
            $table->string('valor_condicion');
            $table->string('interpretacion');
            $table->integer('usu_alta_id')->unsigned();
            $table->integer('usu_mod_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('plan_campo_filtro_id')->references('id')->on('plan_campo_filtros');
            $table->foreign('plantilla_id')->references('id')->on('plantillas');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('plan_condicion_filtros');
	}

}
