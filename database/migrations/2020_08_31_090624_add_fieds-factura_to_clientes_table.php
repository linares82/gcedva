<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFiedsFacturaToClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->integer('tipo_persona_id')->unsigned()->nullable();
            $table->index('tipo_persona_id');
            $table->string('frazon')->nullable();
            $table->string('frfc')->nullable();
            $table->string('fpais')->nullable();
            $table->string('festado')->nullable();
            $table->string('fciudad')->nullable();
            $table->string('fmunicipio')->nullable();
            $table->string('fcolonia')->nullable();
            $table->string('fcp')->nullable();
            $table->string('fcalle')->nullable();
            $table->string('fno_exterior')->nullable();
            $table->string('fno_interior')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clientes', function (Blueprint $table) {
            //
        });
    }
}
