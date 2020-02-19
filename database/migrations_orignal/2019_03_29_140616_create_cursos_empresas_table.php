<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCursosEmpresasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cursos_empresas', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('detalle');
            $table->decimal('descuento_max',8,2)->default(0);
            $table->decimal('p_asesor',8,2)->default(0);
            $table->decimal('p_ventas',8,2)->default(0);
            $table->decimal('p_instructor',8,2)->default(0);
            $table->decimal('p_ganancia',8,2)->default(0);
            $table->decimal('precio_persona',8,2)->default(0);
            $table->decimal('precio_en_linea',8,2)->default(0);
            $table->decimal('precio_demo',8,2)->default(0);
            $table->string('duracion')->default(0);
            $table->integer('usu_alta_id')->unsigned();
            $table->integer('usu_mod_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('usu_mod_id')->references('id')->on('users');
            $table->foreign('usu_alta_id')->references('id')->on('users');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cursos_empresas');
	}

}
