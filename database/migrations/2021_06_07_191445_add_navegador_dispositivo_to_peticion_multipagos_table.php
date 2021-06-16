<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNavegadorDispositivoToPeticionMultipagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('peticion_multipagos', function (Blueprint $table) {
            $table->string('navegador')->nullable();
            $table->string('dispositivo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('peticion_multipagos', function (Blueprint $table) {
            //
        });
    }
}
