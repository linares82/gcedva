<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEnlaceNombreToGradosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('grados', function (Blueprint $table) {
            $table->string('enlace_nombre')->nullable();
            $table->integer('bnd_rvoe_inactiva')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('grados', function (Blueprint $table) {
            //
        });
    }
}
