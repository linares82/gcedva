<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPlanEstudioIdToPeriodoEstudiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('periodo_estudios', function (Blueprint $table) {
            $table->integer('plan_estudio_id')->unsigned()->default(0);
            $table->index('plan_estudio_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('periodo_estudios', function (Blueprint $table) {
            //
        });
    }
}
