<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCedvaFieldsToEmpleadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('empleados', function (Blueprint $table) {
            $table->date('fec_nacimiento')->nullable();
            $table->integer('estado_nacimiento_id')->unsigned()->nullable();
            $table->index('estado_nacimiento_id');
            $table->string('pais_nacimiento')->nullable();
            $table->integer('nivel_estudio_id')->unsigned()->nullable();
            $table->index('nivel_estudio_id');
            $table->string('profesion')->nullable();
            $table->string('cedula')->nullable();
            $table->string('anios_servicio_escuela')->nullable();
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
