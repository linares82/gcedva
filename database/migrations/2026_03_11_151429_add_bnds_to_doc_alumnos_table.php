<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBndsToDocAlumnosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doc_alumnos', function (Blueprint $table) {
            $table->integer('bnd_portal_alumnos')->nullable();
            $table->integer('bnd_pdf')->nullable();
            $table->integer('bnd_imagen')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('doc_alumnos', function (Blueprint $table) {
            //
        });
    }
}
