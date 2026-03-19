<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBloqueoCantidadExtrasToDuracionPeriodos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('duracion_periodos', function (Blueprint $table) {
            $table->integer('bloqueo_cantidad_extras')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('duracion_periodos', function (Blueprint $table) {
            //
        });
    }
}
