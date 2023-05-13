<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsContrato2ToEmpleadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('empleados', function (Blueprint $table) {
            $table->integer('plantel_contrato1_id')->unsigned()->nullable();
            $table->integer('plantel_contrato2_id')->unsigned()->nullable();
            $table->integer('tipo_contrato2_id')->unsigned()->nullable();
            $table->integer('resp_alerta2_id')->unsigned()->nullable();
            $table->date('fec_fin_contrato2')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('empleados', function (Blueprint $table) {
            //
        });
    }
}
