<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlumnosActivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alumnos_activos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('fec_proceso');
            $table->string('razon');
            $table->index('razon');
            $table->integer('cliente_id')->unsigned();
            $table->string('matricula');
            $table->string('nombre');
            $table->string('nombre2');
            $table->string('ape_paterno');
            $table->string('ape_materno');
            $table->string('estatus_cliente');
            $table->string('concepto');
            $table->date('fec_nacimiento')->nullable();
            $table->string('especialidad')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alumnos_activos');
    }
}
