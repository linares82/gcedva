<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsBajaAutomaticaStClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('st_clientes', function (Blueprint $table) {
            $table->integer('bnd_automatizar_baja')->nullable;
            $table->string('orden_ejecucion')->nullable();
            $table->integer('bnd_mensualidades')->nullable;
            $table->string('cantidad_adeudos')->nullable();
            $table->unsignedInteger('siguiente_cliente_id')->nullable();
            $table->unsignedInteger('siguiente_seguimiento_id')->nullable();
            $table->string('dias_ejecucion')->nullable();

            $table->foreign('siguiente_cliente_id')->references('id')->on('st_clientes');
            $table->foreign('siguiente_seguimiento_id')->references('id')->on('st_seguimientos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
