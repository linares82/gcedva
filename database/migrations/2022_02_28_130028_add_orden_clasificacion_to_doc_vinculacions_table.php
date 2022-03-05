<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOrdenClasificacionToDocVinculacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doc_vinculacions', function (Blueprint $table) {
            $table->integer('clasificacion_id')->unsigned()->nullable();
            $table->integer('orden')->nullable();
            $table->foreign('clasificacion_id')->references('id')->on('clasificacions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('doc_vinculacions', function (Blueprint $table) {
            //
        });
    }
}
