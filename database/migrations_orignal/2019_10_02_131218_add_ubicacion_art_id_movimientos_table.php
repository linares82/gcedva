<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUbicacionArtIdMovimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('movimientos', function (Blueprint $table) {
            $table->integer('ubicacion_art_id')->unsigned();
            $table->index('ubicacion_art_id');
            $table->integer('empleado_id')->unsigned();
            $table->index('empleado_id');
            $table->string('marca')->nullable();
            $table->string('modelo')->nullable();
            $table->string('no_serie')->nullable();
            $table->date('caducidad')->nullable();
            $table->string('observaciones')->nullable();
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
