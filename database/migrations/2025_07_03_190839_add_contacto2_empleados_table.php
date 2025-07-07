<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddContacto2EmpleadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('empleados', function (Blueprint $table) {
            $table->string('contacto_emergencia2')->nullable();
            $table->string('tel_emergencia2')->nullable();
            $table->string('parentesco2')->nullable();
            $table->date('fec_inicio_contrato1')->nullable();
            $table->date('fec_inicio_contrato2')->nullable();
            $table->date('fec_inicio_contrato3')->nullable();
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
