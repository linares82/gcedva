<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSeriaFolioToFacturaGeneralLineasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('factura_general_lineas', function (Blueprint $table) {
            $table->string('serie_factura')->nullable();
            $table->string('folio_facturado')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('factura_general_lineas', function (Blueprint $table) {
            //
        });
    }
}
