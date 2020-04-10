<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddMaestroRHistoriaClienteProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('CREATE PROCEDURE maestroRHistoriaCliente(
            IN cliente INT,
            IN fecha_f DATE,
            IN fecha_t DATE
        )
        LANGUAGE SQL
        NOT DETERMINISTIC
        CONTAINS SQL
        SQL SECURITY DEFINER
        COMMENT ""
        BEGIN
            SELECT *
            from historia_clientes
            where cliente_id = cliente and evento_cliente_id = 2 and fecha >= fecha_f AND
            fecha <= fecha_t and historia_clientes.deleted_at is null limit 1;
        END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS maestroRHistoriaCliente');
    }
}
