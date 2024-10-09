<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCompletarSeccionesToSeccionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('seccions', function (Blueprint $table) {
            $table->integer('bnd_valida_portal')->nullable();
            $table->integer('clasificacion_seccion_id')->unsigned()->nullable();
            $table->foreign('clasificacion_seccion_id')->references('id')->on('clasificacion_seccions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('seccions', function (Blueprint $table) {
            //
        });
    }
}
