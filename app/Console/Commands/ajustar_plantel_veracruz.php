<?php

namespace App\Console\Commands;

use App\Caja;
use App\Pago;
use App\Plantel;
use Carbon\Carbon;
use App\SerieFolioSimplificado;
use Illuminate\Console\Command;

class ajustar_plantel_veracruz extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ian:ajustarPlantelVeracruz';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $plantel=Plantel::find(92);
        $cajas=Caja::select('cajas.*')->where('plantel_id',92)
        ->join('pagos as p', 'p.caja_id','cajas.id')
        ->where('st_caja_id', 1)
        ->whereRaw('year(p.fecha)=2025')
        //->where('id', 492421)
        ->get();
        echo "cajas encontradas para veracruz: ".count($cajas)."--";
        //dd($cajas->toArray());
        $i=0;
        foreach($cajas as $caja){
            //dd($caja->toArray());
            echo "caja ".++$i." procesando...";
            $pago_final = Pago::where('caja_id', '=', $caja->id)->orderBy('id', 'desc')->first();
            $pagos = Pago::where('caja_id', '=', $caja->id)->orderBy('id', 'desc')->whereNull('deleted_at')->get();
            //dd($pagos->toArray());

            $mes = Carbon::createFromFormat('Y-m-d', $pago_final->fecha)->month;
            $anio = Carbon::createFromFormat('Y-m-d', $pago_final->fecha)->year;

            $concepto = 0;
            foreach ($caja->cajaLns as $ln) {
                $concepto = $ln->cajaConcepto->bnd_mensualidad;
            }
            //dd($concepto);
            if ($concepto == 1 and is_null($pago_final->csc_simplificado)) {
                if ($plantel->cuenta_p_id <> 0) {
                    $serie_folio_simplificado = SerieFolioSimplificado::where('cuenta_p_id', $plantel->cuenta_p_id)
                        ->where('anio', $anio)
                        ->where('mese_id', 13)
                        ->where('bnd_activo', 1)
                        ->where('bnd_fiscal', 1)
                        ->first();

                    $serie_folio_simplificado->folio_actual = $serie_folio_simplificado->folio_actual + 1;
                    $folio_actual = $serie_folio_simplificado->folio_actual;
                    $serie = $serie_folio_simplificado->serie;
                    $serie_folio_simplificado->save();

                    $relleno = "0000";
                    $consecutivo = substr($relleno, 0, 4 - strlen($folio_actual)) . $folio_actual;
                    foreach ($pagos as $pago) {
                        $pago->csc_simplificado = $serie . "-" . $consecutivo;
                        $pago->save();
                        //dd($pago);
                    }
                }
            } elseif ($concepto == 0 and is_null($pago_final->csc_simplificado)) {
                if ($plantel->cuenta_p_id <> 0) {
                    $serie_folio_simplificado = SerieFolioSimplificado::where('cuenta_p_id', $plantel->cuenta_p_id)
                        ->where('anio', $anio)
                        ->where('mese_id', $mes)
                        ->where('bnd_activo', 1)
                        ->where('bnd_fiscal', 0)
                        ->first();
                    //dd($serie_folio_simplificado);
                    $serie_folio_simplificado->folio_actual = $serie_folio_simplificado->folio_actual + 1;
                    $serie_folio_simplificado->save();
                    $folio_actual = $serie_folio_simplificado->folio_actual;
                    $mes_prefijo = $serie_folio_simplificado->mes1->abreviatura;
                    $anio_prefijo = $anio - 2000;
                    $serie = $serie_folio_simplificado->serie;


                    $relleno = "0000";
                    $consecutivo = substr($relleno, 0, 4 - strlen($folio_actual)) . $folio_actual;
                    foreach ($pagos as $pago) {
                        $pago->csc_simplificado = $serie . "-" . $mes_prefijo . $anio_prefijo . "-" . $consecutivo;
                        $pago->save();
                    }
                }
            }
            echo $caja->id;
            //dd($caja->toArray());
        }
    }
}
