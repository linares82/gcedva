<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsCedvaToClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->string('nacionalidad')->nullable();
            $table->integer('edad')->nullable();
            $table->integer('estado_civil_id')->nullable();
            $table->index('estado_civil_id');
            $table->integer('estado_nacimiento_id')->nullable();
            $table->index('estado_nacimiento_id');
            $table->date('fec_reingreso')->nullable();
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
