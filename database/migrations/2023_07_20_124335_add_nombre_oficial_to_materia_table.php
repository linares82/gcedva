<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNombreOficialToMateriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('materia', function (Blueprint $table) {
            $table->integer('bnd_tiene_nombre_oficial')->nullable();
            $table->string('nombre_oficial')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('materia', function (Blueprint $table) {
            //
        });
    }
}
