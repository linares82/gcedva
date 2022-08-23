<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTitulacionGrupoIdToTitulacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('titulacions', function (Blueprint $table) {
            $table->integer('titulacion_grupo_id')->unsigned()->nullable();
            $table->index('titulacion_grupo_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('titulacions', function (Blueprint $table) {
            //
        });
    }
}
