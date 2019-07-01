<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSaldoInicialCuentasEfectivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('cuentas_efectivos', function(Blueprint $table) {
            $table->double('saldo_inicial',8,2)->nullable();
            $table->double('saldo_actualizado',8,2)->nullable();
            $table->date('fecha_saldo_inicial')->nullable();
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
