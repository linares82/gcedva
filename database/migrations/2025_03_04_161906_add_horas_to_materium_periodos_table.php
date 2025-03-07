<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHorasToMateriumPeriodosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('materium_periodos', function (Blueprint $table) {
            $table->integer('duracion_clase')->nullable();
            $table->integer('horas_jornada')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('materium_periodos', function (Blueprint $table) {
            //
        });
    }
}
