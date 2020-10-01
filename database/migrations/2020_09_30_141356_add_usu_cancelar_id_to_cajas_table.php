<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUsuCancelarIdToCajasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cajas', function (Blueprint $table) {
            $table->integer('usu_cancelar_id')->unsigned()->nullable();
            $table->index('usu_cancelar_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cajas', function (Blueprint $table) {
            //
        });
    }
}
