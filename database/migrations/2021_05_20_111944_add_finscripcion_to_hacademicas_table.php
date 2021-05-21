<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFinscripcionToHacademicasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hacademicas', function (Blueprint $table) {
            $table->date('fec_inscripcion')->nullable();
            $table->integer('periodo_estudio_id')->unsigned();
            $table->index('periodo_estudio_id');
            $table->integer('turno_id')->unsigned();
            $table->index('turno_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hacademicas', function (Blueprint $table) {
            //
        });
    }
}
