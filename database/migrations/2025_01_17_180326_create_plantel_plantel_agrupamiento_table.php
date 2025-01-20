<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlantelPlantelAgrupamientoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plantel_plantel_agrupamiento', function (Blueprint $table) {
            $table->unsignedInteger('plantel_id')->nullable();
            $table->unsignedInteger('plantel_agrupamiento_id')->nullable();
            $table->foreign('plantel_id')->references('id')->on('plantels');
            $table->foreign('plantel_agrupamiento_id')->references('id')->on('plantel_agrupamientos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plantel_plantel_agrupamiento');
    }
}
