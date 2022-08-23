<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTitulacionEgresosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('titulacion_egresos', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('titulacion_grupo_id')->unsigned();
            $table->float('titulacion_concepto_id')->unsigned();
			$table->float('no_alumnos',8,2)->default(0);
			$table->float('cantidad',8,2)->default(0);
			$table->float('no_horas',8,2)->default(0);
			$table->float('costo_unitario',8,2)->default(0);
            $table->float('monto_total',8,2)->default(0);
            $table->date('fecha')->nullable();
			$table->string('complemento')->nullable();
            $table->text('observacion')->nullable();
            $table->integer('usu_alta_id')->unsigned();
            $table->integer('usu_mod_id')->unsigned();
            $table->timestamps();
            
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('titulacion_egresos');
	}

}
