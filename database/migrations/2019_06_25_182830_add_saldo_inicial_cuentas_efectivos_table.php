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
        Schema::table('cuentas_efectivos', function (Blueprint $table) {
            $table->decimal('saldo_inicial', 20, 2)->nullable();
            $table->decimal('saldo_actualizado', 20, 2)->nullable();
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
