<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMateriapMateriahTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materiap_materiah', function (Blueprint $table) {
            $table->unsignedInteger('materiump_id')->nullable();
            $table->unsignedInteger('materiumh_id')->nullable();
            $table->foreign('materiump_id')->references('id')->on('materia');
            $table->foreign('materiumh_id')->references('id')->on('materia');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('materiap_materiah');
    }
}
