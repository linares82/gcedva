<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeticionPaycodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peticion_paycodes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('pago_id')->unsigned()->nullable();
            $table->integer('cliente_id')->unsigned()->nullable();
            $table->integer('forma_pago_id')->unsigned()->nullable();
            $table->string('pnum_cel')->nullable();
            $table->string('pfisrt_name')->nullable();
            $table->string('ppaternal_surname')->nullable();
            $table->string('pmaternal_surname')->nullable();
            $table->string('pconcept')->nullable();
            $table->string('pamount')->nullable();
            $table->string('rsuccess')->nullable();
            $table->string('rdisplay_message')->nullable();
            $table->string('rreference_number')->nullable();
            $table->string('rtrack_code')->nullable();
            $table->string('rtocken_card')->nullable();
            $table->string('rtoken_error')->nullable();
            $table->text('rmetadata')->nullable();
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
