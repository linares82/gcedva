<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBndDocVincRevisadosToTitulacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('titulacions', function (Blueprint $table) {
            $table->integer('bnd_doc_vinc_revisados')->nullable();
            $table->text('obs_doc_vinc')->nullable();
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
