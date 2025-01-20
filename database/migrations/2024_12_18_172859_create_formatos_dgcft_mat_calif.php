<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormatosDgcftMatCalif extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formato_dgcft_mat_califs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('formato_dgcft_detalle_id')->unsigned()->nullable();
            $table->string('grado')->nullable();
            $table->string('materia')->nullable();
            $table->string('calificacion')->nullable();
            $table->integer('usu_alta_id')->unsigned();
            $table->integer('usu_mod_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('usu_alta_id')->references('id')->on('users');
            $table->foreign('usu_mod_id')->references('id')->on('users');
            $table->foreign('formato_dgcft_detalle_id')->references('id')->on('formatos_dgcft_detalles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('formatos_dgcft_mat_calif');
    }
}
