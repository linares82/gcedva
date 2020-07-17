<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExcepcionesDescuentosToAdeudosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('adeudos', function (Blueprint $table) {
            $table->integer('bnd_eximir_descuento_regla')->nullable();
            $table->integer('bnd_eximir_descuento_beca')->nullable();
            $table->string('comentario')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('adeudos', function (Blueprint $table) {
            //
        });
    }
}
