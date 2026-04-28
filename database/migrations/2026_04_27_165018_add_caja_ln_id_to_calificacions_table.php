<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCajaLnIdToCalificacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('calificacions', function (Blueprint $table) {
            $table->unsignedInteger('caja_ln_id')->nullable();
            $table->foreign('caja_ln_id')->references('id')->on('caja_lns');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('calificacions', function (Blueprint $table) {
            //
        });
    }
}
