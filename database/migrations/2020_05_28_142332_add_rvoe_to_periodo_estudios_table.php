<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRvoeToPeriodoEstudiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('periodo_estudios', function (Blueprint $table) {
            $table->string('rvoe')->nullable();
            $table->string('cct')->nullable();
            $table->date('fec_vigencia_rvoe')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('periodo_estudios', function (Blueprint $table) {
            //
        });
    }
}
