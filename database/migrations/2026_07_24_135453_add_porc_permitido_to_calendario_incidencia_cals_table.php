<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPorcPermitidoToCalendarioIncidenciaCalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('calendario_incidencia_cals', function (Blueprint $table) {
            $table->float('porc_permitido', 2, 2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('calendario_incidencias', function (Blueprint $table) {
            //
        });
    }
}
