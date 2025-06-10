<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSepFieldsToTitulacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('titulacions', function (Blueprint $table) {
            $table->date('fecha_expedicion')->nullable();
            $table->date('fecha_examen_profesional')->nullable();
            $table->date('fecha_excencion_examen_profesional')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('titulacions', function (Blueprint $table) {
            //
        });
    }
}
