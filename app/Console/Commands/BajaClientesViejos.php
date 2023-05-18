<?php

namespace App\Console\Commands;

use App\Param;
use Exception;
use App\Adeudo;
use App\BsBaja;
use App\Cliente;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\valenceSdk\samples\BasicSample\UsoApi;

class BajaClientesViejos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ian:BajaClientesViejos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cambio de estatus de clientes con BA con adeudos pendientes con mas de 6 meses de su ultimo pago';

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


        //if ($fechaActual->day == 1 or $fechaActual->day == 2 or $fechaActual->day == 3) {
        $ruta = storage_path('app/public/atrazoPagos/');
        $archivo = date('dmY') . "_" . date('Hsi') . "_ba.csv";
        $file = fopen($ruta . $archivo, 'w');
        $columns = array('plantel', 'id_cliente', 'estatus', 'total_adeudos');
        fputcsv($file, $columns);
        $bajas = Cliente::where('st_cliente_id', 26)->where('id', 4264)->chunk(100, function ($bas) use ($file) {
            
            $fechaActual = Carbon::createFromFormat('Y-m-d', Date('Y-m-d'));
            foreach ($bas as $ba) {
                
                //dd($egresado->id);
                $adeudos = Adeudo::select(DB::raw('p.razon,adeudos.cliente_id, stc.id ,stc.name as estatus, count(adeudos.cliente_id) as adeudos_cantidad'))
                    ->join('clientes as c', 'c.id', '=', 'adeudos.cliente_id')
                    ->join('combinacion_clientes as cc', 'cc.cliente_id', '=', 'c.id')
                    ->join('plantels as p', 'p.id', '=', 'c.plantel_id')
                    ->join('st_clientes as stc', 'stc.id', '=', 'c.st_cliente_id')
                    ->join('caja_conceptos as caj_con', 'caj_con.id', '=', 'adeudos.caja_concepto_id')
                    ->where('c.id', '>', 0)
                    ->where('cc.plantel_id', '>', 0)
                    ->where('cc.especialidad_id', '>', 0)
                    ->where('cc.nivel_id', '>', 0)
                    ->where('cc.grado_id', '>', 0)
                    ->where('cc.turno_id', '>', 0)
                    ->whereColumn('adeudos.combinacion_cliente_id', 'cc.id')
                    ->where('caj_con.bnd_mensualidad', 1)
                    ->where('fecha_pago', '<', $fechaActual)
                    ->where('pagado_bnd', 0)
                    ->whereNotIn('c.plantel_id', array(54, 48, 26, 19))
                    ->whereNull('cc.deleted_at')
                    ->whereNull('c.deleted_at')
                    ->where('c.id', $ba->id)
                    ->groupBy('p.razon')
                    ->groupBy('adeudos.cliente_id')
                    ->groupBy('stc.id')
                    ->groupBy('stc.name')
                    ->having('adeudos_cantidad', '>=', 3)
                    ->get();
                    
                if (!empty($adeudos->toArray())) {
                    $ultima_mensualidad = Adeudo::select('adeudos.*')
                        ->join('caja_conceptos as cc', 'cc.id', 'adeudos.caja_concepto_id')
                        ->where('cc.bnd_mensualidad', 1)
                        ->where('cliente_id', $ba->id)
                        ->where('pagado_bnd', 1)
                        ->orderBy('fecha_pago', 'desc')
                        ->first();
                    
                    $fechaConcepto = Carbon::createFromFormat('Y-m-d', $ultima_mensualidad->fecha_pago);
                    $dias_diferencia=$fechaActual->diffInDays($fechaConcepto);
                    //dd($dias_diferencia);
                    if ($dias_diferencia > 90) {
                        
                        fputcsv($file, array(
                            'plantel' => $ba->plantel_id,
                            'id_cliente' => $ba->id,
                            'estatus' => $ba->st_cliente_id,
                            'adeudos_cantidad' => 0
                        ));
                        $ba->st_cliente_id=27;
                        $ba->save();
                    }
                }
            }
        });
        fclose($file);
    }

    
}
