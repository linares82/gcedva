<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacturaGsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('factura_gs', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('cuentas_efectivo_id')->unsigned();
            $table->string('serie')->nullable();
            $table->string('folio')->nullable();
            $table->datetime('fecha')->useCurrent = true;
            $table->string('tipo_comprobante');
            $table->string('lugar_expedicion');
            $table->string('exportacion')->default('01'); 
            $table->string('forma_pago')->default('01');
            $table->string('periodicidad')->default('01');
            $table->string('meses');
            $table->string('anio');
			$table->integer('plantel_id')->nullable()->unsigned();
            $table->string('emisor_rfc');
            $table->string('emisor_nombre');
            $table->string('emisor_regimen_fiscal');
            $table->string('uuid')->nullable();
			$table->text('xml')->nullable();
			$table->double('total','10','2')->nullable();
            $table->integer('usu_alta_id')->unsigned();
            $table->integer('usu_mod_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
			$table->foreign('usu_alta_id')->references('id')->on('users');
			$table->foreign('usu_mod_id')->references('id')->on('users');
			$table->foreign('plantel_id')->references('id')->on('plantels');
            
            
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('factura_gs');
	}

}
