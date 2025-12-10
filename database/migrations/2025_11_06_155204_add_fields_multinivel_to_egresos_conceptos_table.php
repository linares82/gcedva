<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsMultinivelToEgresosConceptosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('egresos_conceptos', function (Blueprint $table) {
            $table->integer('nivel')->nullable();
            $table->integer('orden')->nullable();
            $table->tinyInteger('bnd_agrupador')->nullable();
            $table->tinyInteger('bnd_final')->nullable();
            $table->unsignedInteger('padre')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('egresos_conceptos', function (Blueprint $table) {
            //
        });
    }
}
