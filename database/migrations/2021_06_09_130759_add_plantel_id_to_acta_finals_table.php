<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPlantelIdToActaFinalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('acta_finals', function (Blueprint $table) {
            $table->integer('plantel_id')->unsigned()->index();
            $table->integer('lectivo_oficial_id')->unsigned()->index();
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
