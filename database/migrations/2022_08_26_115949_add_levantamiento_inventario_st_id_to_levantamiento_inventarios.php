<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLevantamientoInventarioStIdToLevantamientoInventarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inventario_levantamientos', function (Blueprint $table) {
            $table->integer('inventario_levantamiento_st_id')->unsigned()->nullable();
            $table->index('inventario_levantamiento_st_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('levantamiento_inventarios', function (Blueprint $table) {
            //
        });
    }
}
