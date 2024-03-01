<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProcesoActivoABajasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proceso_activo_a_bajas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('orden')->nullable();
            $table->integer('bnd_mensualidades')->nullable();
            $table->string('simbolo_cantidad_adeudos')->nullable();
            $table->integer('cantidad_adeudos')->nullable();
            $table->unsignedInteger('st_cliente_id')->nullable();
            $table->unsignedInteger('st_seguimiento_id')->nullable();
            $table->unsignedInteger('bnd_borrar_adeudos')->nullable();
            $table->string('excepcion_estatus')->nullable();
            $table->string('dias')->nullable();
            $table->integer('usu_alta_id')->unsigned();
            $table->integer('usu_mod_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
			$table->foreign('usu_alta_id')->references('id')->on('users');
			$table->foreign('usu_mod_id')->references('id')->on('users');
            $table->foreign('st_cliente_id')->references('id')->on('st_clientes');
            $table->foreign('st_seguimiento_id')->references('id')->on('st_seguimientos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_proceso_activo_a_bajas');
    }
}
