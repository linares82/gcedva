<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMateriaSepMateria extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materia_sep_materia', function (Blueprint $table) {
            $table->unsignedInteger('materia_id')->nullable();
            $table->unsignedInteger('sep_materia_id')->nullable();
            $table->foreign('sep_materia_id')->references('id')->on('sep_materias');
            $table->foreign('materia_id')->references('id')->on('materia');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('materia_sep_materia');
    }
}
