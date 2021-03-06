<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCicloMatriculaIdToPlanPagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plan_pagos', function (Blueprint $table) {
            $table->integer('ciclo_matricula_id')->unsigned()->nullable();
            $table->index('ciclo_matricula_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plan_pagos', function (Blueprint $table) {
            //
        });
    }
}
