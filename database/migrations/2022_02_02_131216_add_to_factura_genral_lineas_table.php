<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddToFacturaGenralLineasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('factura_general_lineas', function (Blueprint $table) {
            $table->integer('pago_id')->unsigned()->nullable()->change();
            $table->integer('caja_id')->unsigned()->nullable()->change();
            $table->integer('cliente_id')->unsigned()->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('factura_genral_lineas', function (Blueprint $table) {
            //
        });
    }
}
