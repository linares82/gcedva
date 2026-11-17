<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDevolucionesCajaIdToIncidencesClientes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('incidences_clientes', function (Blueprint $table) {
            $table->unsignedInteger('devoluciones_caja_id')->nullable();
            $table->foreign('devoluciones_caja_id')->references('id')->on('devoluciones_cajas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('incidences_clientes', function (Blueprint $table) {
            //
        });
    }
}
