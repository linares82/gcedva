<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFolioToFacturaGLineasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('factura_g_lineas', function (Blueprint $table) {
            $table->string('folio')->nullable();
            $table->string('origen')->nullable();
            $table->date('fecha_operacion')->nullable()->change();
            $table->string('concepto')->nullable()->change();
            $table->string('referencia')->nullable()->change();
            $table->string('referencia_ampliada')->nullable()->change();
            //$table->double('saldo',10,2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('factura_g_lineas', function (Blueprint $table) {
            //
        });
    }
}
