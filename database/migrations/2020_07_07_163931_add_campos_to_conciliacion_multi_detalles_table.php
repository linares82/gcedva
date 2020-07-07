<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCamposToConciliacionMultiDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('conciliacion_multi_detalles', function (Blueprint $table) {
            $table->integer('success_multipago_id')->unsigned()->nullable();
            $table->index('success_multipago_id');
            $table->integer('peticion_multipago_id')->unsigned()->nullable();
            $table->index('peticion_multipago_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('conciliacion_multi_detalles', function (Blueprint $table) {
            //
        });
    }
}
