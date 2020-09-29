<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAutToHistoriaClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('historia_clientes', function (Blueprint $table) {
            $table->integer('aut_director')->nullable();
            $table->index('aut_director');
            $table->integer('aut_caja_corp')->nullable();
            $table->index('aut_caja_corp');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('historia_clientes', function (Blueprint $table) {
            //
        });
    }
}
