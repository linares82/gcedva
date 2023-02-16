<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBndRedondeoToCargaPonderacions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('carga_ponderacions', function (Blueprint $table) {
            $table->integer('bnd_excepcion_calificacion_prohibida')->unsigned()->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('carga_ponderacions', function (Blueprint $table) {
            //
        });
    }
}
