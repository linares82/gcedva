<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableFormatosDgcftDetalle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formato_dgcft_detalles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('formato_dgcft_id')->unsigned()->nullable();
            $table->string('num')->nullable();
            $table->string('control')->nullable();
            $table->unsignedInteger('cliente_id')->nullable();
            $table->string('nombre')->nullable();
            $table->string('curp')->nullable();
            $table->string('edad')->nullable();
            $table->string('fec_sexo')->nullable();
            $table->string('escolaridad')->nullable();
            $table->string('beca')->nullable();
            $table->string('resultado')->nullable();
            $table->string('final')->nullable();
            $table->integer('usu_alta_id')->unsigned();
            $table->integer('usu_mod_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('usu_alta_id')->references('id')->on('users');
            $table->foreign('usu_mod_id')->references('id')->on('users');
            $table->foreign('formato_dgcft_id')->references('id')->on('formato_dgcfts');
            $table->foreign('cliente_id')->references('id')->on('clientes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_formatos_dgcft_detalle');
    }
}
