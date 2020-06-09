<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTipoBecaIdToAutorizacionBecasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('autorizacion_becas', function (Blueprint $table) {
            $table->integer('tipo_beca_id')->unsigned();
            $table->index('tipo_beca_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('autorizacion_becas', function (Blueprint $table) {
            //
        });
    }
}
