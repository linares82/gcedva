<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTecnicaToPeriodoEstudiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('periodo_estudios', function (Blueprint $table) {
            $table->integer('bnd_carrera_tecnica')->nullable();
            $table->integer('orden_carrera_tecnica')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('periodo_estudios', function (Blueprint $table) {
            //
        });
    }
}
