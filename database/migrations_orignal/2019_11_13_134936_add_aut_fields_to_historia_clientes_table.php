<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAutFieldsToHistoriaClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('historia_clientes', function (Blueprint $table) {
            $table->integer('st_historia_cliente_id')->integer()->default(0);
            $table->integer('aut_ser_esc')->integer()->default(0);
            $table->integer('aut_caja')->integer()->default(0);
            $table->integer('aut_ser_esc_corp')->integer()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
