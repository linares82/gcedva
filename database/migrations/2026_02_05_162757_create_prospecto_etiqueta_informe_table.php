<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProspectoEtiquetaInformeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prospecto_etiqueta_informe', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('etiqueta_id');
            $table->unsignedInteger('informe_id');
            $table->unsignedInteger('usu_alta_id');
            $table->unsignedInteger('usu_mod_id');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('usu_alta_id')->references('id')->on('users');
            $table->foreign('usu_mod_id')->references('id')->on('users');
            $table->foreign('etiqueta_id')->references('id')->on('prospecto_etiquetas');
            $table->foreign('informe_id')->references('id')->on('prospecto_informes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prospecto_etiqueta_prospecto_informe');
    }
}
