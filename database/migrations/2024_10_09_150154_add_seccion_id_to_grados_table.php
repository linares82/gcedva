<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSeccionIdToGradosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('grados', function (Blueprint $table) {
            $table->unsignedInteger('seccion_id')->nullable();
            $table->foreign('seccion_id')->references('id')->on('seccions');
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
