<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToVinculacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vinculacions', function (Blueprint $table) {
            $table->string('area')->nullable();
            $table->string('puesto')->nullable();
            $table->string('aseguradora')->nullable();
            $table->string('no_poliza')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vinculacions', function (Blueprint $table) {
            //
        });
    }
}
