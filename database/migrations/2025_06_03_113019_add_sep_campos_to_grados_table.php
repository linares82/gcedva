<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSepCamposToGradosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('grados', function (Blueprint $table) {
            $table->integer('sep_carrera_id')->unsigned()->nullable();
            $table->foreign('sep_carrera_id')->references('id')->on('sep_carreras');
            $table->integer('sep_autorizacion_reconocimiento_id')->unsigned()->nullable();
            $table->foreign('sep_autorizacion_reconocimiento_id')->references('id')->on('sep_autorizacion_reconocimientos');
            $table->integer('bnd_servicio_social')->unsigned()->default(0);
            $table->integer('sep_fundamento_legal_servicio_social_id')->unsigned()->nullable();
            $table->foreign('sep_fundamento_legal_servicio_social_id')->references('id')->on('sep_fundamento_legal_servicio_socials');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('grados', function (Blueprint $table) {
            //
        });
    }
}
