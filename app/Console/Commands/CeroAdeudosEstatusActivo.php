<?php

namespace App\Console\Commands;

use App\Adeudo;
use App\BsBaja;
use App\Caja;
use App\Cliente;
use App\HistoriaCliente;
use App\Param;
use App\Seguimiento;
use App\valenceSdk\samples\BasicSample\UsoApi;
use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Console\Command;
use Log;

class CeroAdeudosEstatusActivo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ian:CeroAdeudosEstatusActivo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Revisa clientes con estatus activo y cero adeudos, cambia estatus de cliente y seguimiento';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $hoy = Carbon::createFromFormat('Y-m-d H:i:s', Date('Y-m-d H:i:s'))->toDateTimeString();
        $ayer = Carbon::createFromFormat('Y-m-d H:i:s', Date('Y-m-d H:i:s'))->subDay()->toDateTimeString();
        $cajasPagadasHoy = Caja::whereDate('created_at', '<', $hoy)
            ->whereDate('created_at', '>', $ayer)
            ->where('cajas.st_caja_id', 1)
            ->with('cliente')
            ->get();
        //dd($cajasPagadasHoy->toArray());

        foreach ($cajasPagadasHoy as $caja) {
            //dd($caja->cliente->st_cliente_id);
            if (
                $caja->cliente->st_cliente_id == 17 or $caja->cliente->st_cliente_id == 24 or
                $caja->cliente->st_cliente_id == 25 or $caja->cliente->st_cliente_id == 26
            ) {
                $fechaActual = Carbon::createFromFormat('Y-m-d', Date('Y-m-d'));
                /*(select count(A1.id) 
                from adeudos A1 
                where A1.cliente_id = adeudos.cliente_id) as adeudos_cantidad*/
                $adeudos = Adeudo::select(DB::raw('p.razon,adeudos.cliente_id,stc.name as estatus, 
                count(adeudos.id) as adeudos_pendientes'))
                    ->join('clientes as c', 'c.id', '=', 'adeudos.cliente_id')
                    ->join('combinacion_clientes as cc', 'cc.cliente_id', '=', 'c.id')
                    ->join('plantels as p', 'p.id', '=', 'c.plantel_id')
                    ->join('st_clientes as stc', 'stc.id', '=', 'c.st_cliente_id')
                    ->join('caja_conceptos as caj_con', 'caj_con.id', '=', 'adeudos.caja_concepto_id')
                    ->join('seguimientos as ss', 'ss.cliente_id', '=', 'c.id')
                    ->where('cc.plantel_id', '>', 0)
                    ->where('cc.especialidad_id', '>', 0)
                    ->where('cc.nivel_id', '>', 0)
                    ->where('cc.grado_id', '>', 0)
                    ->where('cc.turno_id', '>', 0)
                    ->where('c.id', $caja->cliente_id)
                    ->whereColumn('adeudos.combinacion_cliente_id', 'cc.id')
                    ->where('fecha_pago', '<=', $fechaActual)
                    ->where('pagado_bnd', 0)
                    ->whereNotIn('c.plantel_id', array(54))
                    ->whereNull('cc.deleted_at')
                    ->whereNull('c.deleted_at')
                    ->distinct()
                    ->whereIn('c.st_cliente_id', array(17, 24, 25, 26))
                    ->groupBy('p.razon')
                    ->groupBy('adeudos.cliente_id')
                    ->groupBy('stc.name')
                    //->having('adeudos_pendientes', 0)
                    //->having('adeudos_cantidad', '<=', 3)
                    ->get();
                //dd($adeudos->toArray());
                if (count($adeudos) == 0) {
                    $cliente = Cliente::find($caja->cliente_id);
                    $cliente->st_cliente_id = 4;
                    $cliente->save();
                    /*$seguimiento = Seguimiento::where('cliente_id', $caja->cliente_id)
                        ->where('st_seguimiento_id', 2)
                        ->first();
                    if ($seguimiento) {
                        $seguimiento->st_seguimiento_id = 1;
                        $seguimiento->save();
                    }*/
                } else {
                    dd('con adeudos');
                }
                /*if (count($adeudos) > 0) {
                    dd($adeudos);
                    if ($adeudos->adeudos_cantidad == 0) {
                        dd($caja->cliente_id);
                    }
                }*/
            }
        }
    }
}
