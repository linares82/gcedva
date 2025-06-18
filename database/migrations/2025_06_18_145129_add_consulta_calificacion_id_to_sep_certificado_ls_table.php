<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddConsultaCalificacionIdToSepCertificadoLsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sep_certificado_ls', function (Blueprint $table) {
            $table->integer('consulta_calificacion_id')->unsigned()->nullable();
            $table->foreign('consulta_calificacion_id')->references('id')->on('consulta_calificacions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sep_certificados', function (Blueprint $table) {
            //
        });
    }
}
