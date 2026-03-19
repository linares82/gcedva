<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLectivoAnteriorToLectivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lectivos', function (Blueprint $table) {
            $table->integer('lectivo_anterior_id')->unsigned()->nullable();
            $table->foreign('lectivo_anterior_id')->references('id')->on('lectivos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lectivos', function (Blueprint $table) {
            //
        });
    }
}
