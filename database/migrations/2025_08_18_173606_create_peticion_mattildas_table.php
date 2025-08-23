<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeticionMattildasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peticion_mattildas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('pago_id')->unsigned()->nullable();
            $table->integer('cliente_id')->unsigned()->nullable();
            $table->integer('forma_pago_id')->unsigned()->nullable();
            $table->string('pnum_cel')->nullable();
            $table->string('pmail')->nullable();
            $table->string('pfisrt_name')->nullable();
            $table->string('plast_name')->nullable();
            $table->string('pconcept')->nullable();
            $table->string('pamount')->nullable();
            $table->string('rstatus')->nullable();
            $table->string('rmethod')->nullable();
            $table->string('rapproval_url')->nullable();
            $table->string('final_card')->nullable();
            $table->string('banco')->nullable();
            $table->string('type_card')->nullable();
            $table->string('id_transaction')->nullable();
            $table->integer('bnd_conciliado')->unsigned()->nullable();
            $table->integer('usu_alta_id')->unsigned();
            $table->integer('usu_mod_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('usu_alta_id')->references('id')->on('usuario_clientes');
            $table->foreign('usu_mod_id')->references('id')->on('usuario_clientes');
            $table->foreign('pago_id')->references('id')->on('pagos');
            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->foreign('forma_pago_id')->references('id')->on('forma_pagos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('peticion_openpay');
    }
}
