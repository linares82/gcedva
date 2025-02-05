<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSepMateriaIdToFormatoDgcftMatCalifs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('formato_dgcft_mat_califs', function (Blueprint $table) {
            $table->unsignedInteger('sep_materia_id')->nullable();
            $table->foreign('sep_materia_id')->references('id')->on('sep_materias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('formatos_dgcft_mat_calif', function (Blueprint $table) {
            //
        });
    }
}
