<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCalificacionIdToCajaLnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('caja_lns', function (Blueprint $table) {
            $table->unsignedInteger('calificacion_id')->nullable();
            $table->foreign('calificacion_id')->references('id')->on('calificacions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('caja_lns', function (Blueprint $table) {
            //
        });
    }
}
