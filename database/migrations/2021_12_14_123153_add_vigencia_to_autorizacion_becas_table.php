<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVigenciaToAutorizacionBecasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('autorizacion_becas', function (Blueprint $table) {
            $table->integer('bnd_tiene_vigencia')->nullable();
            $table->date('vigencia')->nullable();
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
