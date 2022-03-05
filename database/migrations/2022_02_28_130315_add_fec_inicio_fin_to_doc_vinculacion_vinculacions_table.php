<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFecInicioFinToDocVinculacionVinculacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doc_vinculacion_vinculacions', function (Blueprint $table) {
            $table->date('fec_inicio')->nullable();
            $table->date('fec_fin')->nullable();
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
