<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddImagenToGradosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('grados', function (Blueprint $table) {
            $table->string('imagen')->nullable();
            $table->date('emision_rvoe')->nullable();
            $table->string('url_reglamento')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('grados', function (Blueprint $table) {
            //
        });
    }
}
