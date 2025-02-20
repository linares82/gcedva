<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeriodoEstudioPlanEstudioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('periodo_estudio_plan_estudio', function (Blueprint $table) {
            $table->unsignedInteger('periodo_estudio_id')->nullable();
            $table->unsignedInteger('plan_estudio_id')->nullable();
            $table->foreign('plan_estudio_id')->references('id')->on('plan_estudios');
            $table->foreign('periodo_estudio_id')->references('id')->on('periodo_estudios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('materia_plan_estudio');
    }
}
