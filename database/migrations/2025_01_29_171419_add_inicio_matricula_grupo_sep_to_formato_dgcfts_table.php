<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInicioMatriculaGrupoSepToFormatoDgcftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('formato_dgcfts', function (Blueprint $table) {
            $table->string('inicio_matricula')->nullable();
            $table->unsignedInteger('sep_grupo_id')->nullable();
            $table->foreign('sep_grupo_id')->references('id')->on('sep_grupos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('formato_dgcfts', function (Blueprint $table) {
            //
        });
    }
}
