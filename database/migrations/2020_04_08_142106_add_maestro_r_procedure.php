<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddMaestroRProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
            CREATE DEFINER=root@localhost PROCEDURE maestroR(
                IN plantel INT,
                IN fecha_f DATE,
                IN fecha_t DATE
            )
            LANGUAGE SQL
            NOT DETERMINISTIC
            CONTAINS SQL
            SQL SECURITY DEFINER
            COMMENT ""
            BEGIN
                select p.razon, c.id, adeudos.pagado_bnd, adeudos.monto as adeudo_planeado, cc.name as concepto,
                cc.id as concepto_id, cln.total as pago_calculado_adeudo, caj.id as caja, caj.consecutivo,
                cln.deleted_at as borrado_cln, caj.deleted_at as borrado_c, c.st_cliente_id, stc.name as st_cliente,
                s.st_seguimiento_id, sts.name as st_seguimiento
                from adeudos inner join clientes as c on c.id = adeudos.cliente_id
                inner join st_clientes as stc on stc.id = c.st_cliente_id
                inner join seguimientos as s on s.cliente_id = c.id
                inner join st_seguimientos as sts on sts.id = s.st_seguimiento_id
                inner join plantels as p on p.id = c.plantel_id
                left join caja_lns as cln on cln.adeudo_id = adeudos.id
                left join cajas as caj on caj.id = adeudos.caja_id
                inner join caja_conceptos as cc on cc.id = adeudos.caja_concepto_id
                where p.id = plantel and stc.id in (3, 4, 20, 23, 24, 25) and date(adeudos.fecha_pago) >= fecha_f and
                date(adeudos.fecha_pago) <= fecha_t and adeudos.deleted_at is null and s.deleted_at is null and
                adeudos.deleted_at is null
                order by p.id asc, adeudos.caja_concepto_id asc, c.id asc;
            END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS maestroR');
    }
}
