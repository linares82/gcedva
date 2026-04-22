<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTpoExamenIdToIncidenciasCalificacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('incidencias_calificacions', function (Blueprint $table) {
            $table->unsignedInteger('tpo_examen_id')->nullable();
            $table->foreign('tpo_examen_id')->references('id')->on('tpo_examens');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('incidencias_calificacions', function (Blueprint $table) {
            //
        });
    }
}
