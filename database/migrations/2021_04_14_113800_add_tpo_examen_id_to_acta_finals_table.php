<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTpoExamenIdToActaFinalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('acta_finals', function (Blueprint $table) {
            $table->integer('tpo_examen_id')->unsigned()->default(0);
            $table->index('tpo_examen_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('acta_finals', function (Blueprint $table) {
            //
        });
    }
}
