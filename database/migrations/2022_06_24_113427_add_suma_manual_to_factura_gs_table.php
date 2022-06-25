<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSumaManualToFacturaGsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('factura_gs', function (Blueprint $table) {
            $table->double('suma_manual',10,2)->nullable();
            $table->double('diferencia_sumas',10,2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('factura_gs', function (Blueprint $table) {
            //
        });
    }
}
