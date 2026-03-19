<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLectivoIdToCalendarioExaExtras extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('calendario_exa_extras', function (Blueprint $table) {
            $table->unsignedInteger('lectivo_id')->nullable();
            $table->foreign('lectivo_id')->references('id')->on('lectivos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('calendario_exa_extras', function (Blueprint $table) {
            //
        });
    }
}
