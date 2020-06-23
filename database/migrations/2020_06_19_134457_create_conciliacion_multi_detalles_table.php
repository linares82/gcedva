<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConciliacionMultiDetallesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('conciliacion_multi_detalles', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('conciliacion_multipago_id')->unsigned();
            $table->string('fecha_pago');
            $table->string('razon_social');
            $table->text('mp_node');
            $table->text('mp_concept');
            $table->string('mp_paymentmethod');
            $table->string('mp_reference');
            $table->string('mp_order');
            $table->string('no_aprobacion');
            $table->string('identificador_venta');
            $table->string('ref_medio_pago');
            $table->decimal('importe',10,2);
            $table->decimal('comision',10,2);
            $table->decimal('iva_comision',10,2);
            $table->string('fecha_dispersion');
            $table->string('periodo_financiamiento');
            $table->integer('moneda');
            $table->string('banco_emisor');
            $table->string('mp_customername');
            $table->string('mail');
            $table->string('tel_customername');
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
		Schema::drop('conciliacion_multi_detalles');
	}

}
