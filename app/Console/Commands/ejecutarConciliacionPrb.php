<?php

namespace App\Console\Commands;


use Log;
use Auth;

use Storage;
use App\Caja;
use App\Pago;
use App\Adeudo;
use App\CuentaP;
use App\Plantel;
use Carbon\Carbon;
use App\Http\Requests;
use App\AdeudoPagoOnLine;
use App\SuccessMultipago;
use App\PeticionMultipago;

use App\ConciliacionMultipago;
use App\SerieFolioSimplificado;
use App\ConciliacionMultiDetalle;
use Illuminate\Console\Command;

class ejecutarConciliacionPrb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

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
        $this->ejecutarConciliacion(5939);
    }

    public function ejecutarConciliacion($conciliacion)
	{

		$registros = ConciliacionMultiDetalle::where('conciliacion_multipago_id', $conciliacion)->get();

		//dd($registros->toArray());

		foreach ($registros as $pagoConciliacion) {
			//Busca la peticion inicial
			$peticionBuscado = PeticionMultipago::where('mp_reference', $pagoConciliacion->mp_reference)
				->where('mp_order', $pagoConciliacion->mp_order)
				->where('mp_amount', $pagoConciliacion->importe)
				->first();
			//Buscar la respues a la peticion
			$successBuscado = SuccessMultipago::where('mp_reference', $pagoConciliacion->mp_reference)
				->where('mp_order', $pagoConciliacion->mp_order)
				->where('mp_amount', $pagoConciliacion->importe)
				->first();
			/*if ($pagoConciliacion->mp_reference == "017000000041000021") {
				dd($peticionBuscado->pago);
			}*/
			//dd($successBuscado);

			//Si existe la peticion y no esta pagada entra en la condicion
			if (
				!is_null($peticionBuscado) and
				!is_null($peticionBuscado->pago) and
				$peticionBuscado->pago->bnd_pagado <> 1
			) {
				//Marca como pagado el pago
				$peticionBuscado->pago->bnd_pagado = 1;
				$peticionBuscado->pago->save();

				//Referencia la linea de conciliacion con la peticion inicial
				$pagoConciliacion->peticion_multipago_id = $peticionBuscado->id;
				if (!is_null($successBuscado)) {
					//Si la respuesta existe se guarda referencia con la linea de conciliacion
					//Y guarda en la respuesta una referencia de la linea de conciliacion
					$pagoConciliacion->success_multipago_id = $successBuscado->id;
					$successBuscado->conciliacion_multi_detalle_id = $pagoConciliacion->id;
					$successBuscado->save();
				} else {
					$pagoConciliacion->success_multipago_id = 0;
				}

				$pagoConciliacion->save();

				//Se actualiza estatus de caja
				$caja = $peticionBuscado->pago->caja;
				$this->actualizaEstatusCaja($caja->id);
				//dd($pagoConciliacion);
			} elseif (
				!is_null($peticionBuscado) and
				!is_null($peticionBuscado->pago) and
				$peticionBuscado->pago->bnd_pagado == 1
			) {
				//Solo se guardan referencias de la linea del archivo de conciliacion
				$pagoConciliacion->peticion_multipago_id = $peticionBuscado->id;
				if (!is_null($successBuscado)) {
					$pagoConciliacion->success_multipago_id = $successBuscado->id;
					$successBuscado->conciliacion_multi_detalle_id = $pagoConciliacion->id;
					$successBuscado->save();
				} else {
					$pagoConciliacion->success_multipago_id = 0;
				}
				$pagoConciliacion->save();

				$caja = $peticionBuscado->pago->caja;
				if($caja->st_caja_id==0){
					$this->actualizaEstatusCaja($caja->id);
				}
			}
		}

		$conciliacion = ConciliacionMultipago::find($conciliacion);
		$conciliacion->contador_ejecucion = $conciliacion->contador_ejecucion + 1;
		$conciliacion->save();
		
	}

	public function actualizaEstatusCaja($caja_id)
	{
		//$pago = Pago::find($pago_id);
        $caja = Caja::find($caja_id);

        $suma_pagos = Pago::select('monto')
            ->where('caja_id', '=', $caja->id)
            ->where('bnd_referenciado', 0)
            ->sum('monto');

        $suma_pagos_referenciados = Pago::select('monto')
            ->where('caja_id', '=', $caja->id)
            ->where('bnd_referenciado', 1)
            ->where('bnd_pagado', 1)
            ->sum('monto');

        $suma = $suma_pagos + $suma_pagos_referenciados;

        if ($suma >= ($caja->total - 1) and $suma <= ($caja->total + 100)) {

            foreach ($caja->cajaLns as $ln) {
                if ($ln->adeudo_id > 0) {
                    //Adeudo::where('id', '=', $ln->adeudo_id)->update(['pagado_bnd' => 1]);
                    $adeudo = Adeudo::find($ln->adeudo_id);
					if(!is_null($adeudo)){
						$adeudo->pagado_bnd = 1;
                    	$adeudo->save();
					}
                }
            }

            $caja->st_caja_id = 1;
            //$caja->fecha=date_create(date_format(date_create(date('Y/m/d')),'Y/m/d'));
            $caja->save();

            //Generar consecutivo pago simplificado
            $plantel = Plantel::find($caja->plantel_id);
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
            //Fin crear consecutivo simplificado

        } elseif ($suma > 0 and $suma < ($caja->total - 1)) {
            $caja->st_caja_id = 3;
            $caja->save();
            foreach ($caja->cajaLns as $ln) {
                if ($ln->adeudo_id > 0) {
                    Adeudo::where('id', '=', $ln->adeudo_id)->update(['pagado_bnd' => 0]);
                }
            }
        } else {
            $caja->st_caja_id = 0;
            $caja->save();

            foreach ($caja->cajaLns as $ln) {
                if ($ln->adeudo_id > 0) {
                    Adeudo::where('id', '=', $ln->adeudo_id)->update(['pagado_bnd' => 0]);
                }
            }
        }
    }
}
