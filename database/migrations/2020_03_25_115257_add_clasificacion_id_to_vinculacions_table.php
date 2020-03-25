<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddClasificacionIdToVinculacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vinculacions', function (Blueprint $table) {
            $table->integer('clasificacion_id')->unsigned()->nullable();
            $table->index('clasificacion_id');
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
