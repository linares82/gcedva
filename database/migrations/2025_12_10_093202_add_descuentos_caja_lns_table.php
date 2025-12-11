<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDescuentosCajaLnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('caja_lns', function (Blueprint $table) {
            $table->double('desc_beca', 8, 2)->nullable();
            $table->double('desc_promocion', 8, 2)->nullable();
            $table->integer('autorizacion_beca_id')->unsigned()->nullable();
            $table->foreign('autorizacion_beca_id')->references('id')->on('autorizacion_becas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
