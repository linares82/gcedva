<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPlantelInventarioIdToInventarioLevantamientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inventario_levantamientos', function (Blueprint $table) {
            $table->integer('plantel_inventario_id')->unsigned()->nullable();
            $table->index('plantel_inventario_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inventario_levantamientos', function (Blueprint $table) {
            //
        });
    }
}
