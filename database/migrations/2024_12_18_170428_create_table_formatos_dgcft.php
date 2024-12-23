<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableFormatosDgcft extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formato_dgcfts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('enlace_operativo')->nullable();
            $table->string('plantel')->nullable();
            $table->string('direccion')->nullable();
            $table->string('cct')->nullable();
            $table->string('especialidad')->nullable();
            $table->string('grupo')->nullable();
            $table->date('fec_elaboracion')->nullable();
            $table->date('fec_inicio')->nullable();
            $table->date('fec_fin')->nullable();
            $table->string('ciclo_escolar')->nullable();
            $table->date('fec_edad')->nullable();
            $table->string('duracion')->nullable();
            $table->string('duracion_materias')->nullable();
            $table->string('horario')->nullable();
            $table->string('horario_inicio')->nullable();
            $table->string('horario_fin')->nullable();
            $table->text('cantidad_clientes')->nullable();
            $table->text('clientes')->nullable();
            $table->text('control')->nullable();
            $table->text('escolaridad')->nullable();
            $table->text('beca')->nullable();
            $table->text('grados')->nullable();
            $table->text('materias')->nullable();
            $table->string('calificaciones')->nullable();
            $table->string('resultados')->nullable();
            $table->string('final')->nullable();
            $table->string('directora_nombre')->nullable();
            $table->string('sceo_nombre')->nullable();
            $table->integer('usu_alta_id')->unsigned();
            $table->integer('usu_mod_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('usu_alta_id')->references('id')->on('users');
            $table->foreign('usu_mod_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_formatos_dgcfts');
    }
}
