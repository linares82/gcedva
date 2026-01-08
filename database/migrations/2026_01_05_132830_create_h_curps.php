<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHCurps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('h_curps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('curp_anterior')->nullable();
            $table->string('curp_nueva')->nullable();
            $table->unsignedInteger('cliente_id');
            $table->integer('usu_alta_id')->unsigned();
            $table->integer('usu_mod_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('usu_alta_id')->references('id')->on('users');
            $table->foreign('usu_mod_id')->references('id')->on('users');
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
        Schema::dropIfExists('table_h_curp');
    }
}
