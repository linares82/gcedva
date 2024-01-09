<?php

namespace App\Console\Commands;

use App\Caja;
use App\Pago;
use App\Adeudo;
use App\Plantel;
use Carbon\Carbon;
use App\SuccessMultipago;
use App\PeticionMultipago;
use Illuminate\Support\Arr;
use App\ConciliacionMultipago;
use App\SerieFolioSimplificado;
use Illuminate\Console\Command;
use App\ConciliacionMultiDetalle;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ConciliacionAutomatica extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ian:ConciliacionAutomatica';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Detecta archivos nuevos de conciliacion, carga y jecuta proceso de conciliacion';

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
	$directorio = storage_path('conciliaciones/sftp');
        $directorio_origen = storage_path('conciliaciones/sftp/workarea');
	$directorio_destino = storage_path('conciliaciones_realizadas');
        //dd($directorio);
        //obtener lista de archivos recibidos
        $archivos = [];
        if ($handler = opendir($directorio)) {
            while (false !== ($file = readdir($handler))) {
                array_push($archivos, $file);
            }
            closedir($handler);
        }
	
        //validar archivos con extension .des
        $archivos_bancarios = Arr::where($archivos, function ($registro) {
            if (substr($registro, -4) == ".des") {
                return $registro;
            }
        });

	//dd($archivos_bancarios);
        foreach ($archivos_bancarios as $archivo) {
            $cuenta_p="procesados";
            $input['fecha_carga'] = date('Y-m-d');
	    $input['fec_inicio'] = date("Y-m-d",strtotime($input['fecha_carga']."- 10 days"));
	    $input['fec_fin'] = date('Y-m-d');
            $input['registros'] = 0;
            $input['contador_ejecucion'] = 0;
            $input['usu_alta_id'] = 1;
            $input['usu_mod_id'] = 1;
            $input['archivo'] = $archivo;
	    //dd($input);
            $cabecera = ConciliacionMultipago::create($input);
            //dd(Storage::disk('conciliaciones')->path('sftp\\'.$archivo));
            $fp = fopen(Storage::disk('conciliaciones')->path('sftp//'.$archivo), "r");
            $i = 0;
	    
            while (!feof($fp)) {
                $registro = array();
                //$file=storage_path('conciliaciones\\'.$nombre);


                $linea_aux = fgets($fp);
                $linea = utf8_decode($linea_aux);
                //dd(utf8_encode($linea));
                Log::info("linea " . $i . ": " . $linea);

                if (trim($linea) <> "") {
                    //dd();
                    $posicion = 0;
                    $longitud = 0;
                    $registro['conciliacion_multipago_id'] = $cabecera->id;
                    $longitud = 26;
                    $registro['fecha_pago'] = substr($linea, $posicion, $longitud);
                    $posicion = $posicion + $longitud; //27
                    //$posicion = $posicion + $longitud;
                    $longitud = 50;
                    $registro['razon_social'] = utf8_encode(trim(substr($linea, $posicion, $longitud)));
                    $posicion = $posicion + $longitud; //77
                    $longitud = 10;
                    $registro['mp_node'] = trim(substr($linea, $posicion, $longitud));
                    $posicion = $posicion + $longitud;
                    $longitud = 10;
                    $registro['mp_concept'] = trim(substr($linea, $posicion, $longitud));
                    $posicion = $posicion + $longitud;
                    $longitud = 10;
                    $registro['mp_paymentmethod'] = trim(substr($linea, $posicion, $longitud));
                    $posicion = $posicion + $longitud;
                    $longitud = 40;
                    $registro['mp_reference'] = trim(substr($linea, $posicion, $longitud));
                    $posicion = $posicion + $longitud;
                    $longitud = 40;
                    $registro['mp_order'] = trim(substr($linea, $posicion, $longitud));
                    $posicion = $posicion + $longitud;
                    $longitud = 10;
                    $registro['no_aprobacion'] = trim(substr($linea, $posicion, $longitud));
                    $posicion = $posicion + $longitud;
                    $longitud = 20;
                    $registro['identificador_venta'] = trim(substr($linea, $posicion, $longitud));
                    $posicion = $posicion + $longitud;
                    $longitud = 20;
                    $registro['ref_medio_pago'] = trim(substr($linea, $posicion, $longitud));
                    $posicion = $posicion + $longitud;
                    $longitud = 22;
                    $registro['importe'] = floatval(trim(substr($linea, $posicion, $longitud)));
                    $posicion = $posicion + $longitud;
                    $longitud = 22;
                    $registro['comision'] = floatval(trim(substr($linea, $posicion, $longitud)));
                    $posicion = $posicion + $longitud;
                    $longitud = 22;
                    $registro['iva_comision'] = floatval(trim(substr($linea, $posicion, $longitud)));
                    $posicion = $posicion + $longitud;
                    $longitud = 10;
                    $registro['fecha_dispersion'] = substr($linea, $posicion, $longitud);
                    $posicion = $posicion + $longitud;
                    $longitud = 2;
                    $registro['periodo_financiamiento'] = trim(substr($linea, $posicion, $longitud));
                    $posicion = $posicion + $longitud;
                    $longitud = 1;
                    $registro['moneda'] = substr($linea, $posicion, $longitud);
                    //dd($registro);
                    $posicion = $posicion + $longitud;
                    $longitud = 100;
                    $registro['banco_emisor'] = trim(substr($linea, $posicion, $longitud));
                    $posicion = $posicion + $longitud;
                    $longitud = 100;
                    $registro['mp_customername'] = utf8_encode(trim(substr($linea, $posicion, $longitud)));
                    $posicion = $posicion + $longitud;
                    $longitud = 50;
                    $registro['mail'] = utf8_encode(trim(substr($linea, $posicion, $longitud)));
                    $posicion = $posicion + $longitud;
                    $longitud = 50;
                    $registro['tel_customername'] = trim(substr($linea, $posicion, $longitud));
                    $registro['usu_alta_id'] = 1;
                    $registro['usu_mod_id'] = 1;
                    //dd($registro);
                    ConciliacionMultiDetalle::create($registro);
                    /*if($i==0){
                        $plantel=Plantel::where('nombre_corto', 'like', $registro['razon_social'])->first();
                        $cuenta_p=$plantel->cuentaP->name;
                        $cabecera->cuenta_p_id=$plantel->cuentaP->id;
                        $cabecera->save();
                    }*/
                    $i++;
                    //dd($registro['archivo']);
                }
            }
            $cabecera->registros = $i;
            $cabecera->update();

            fclose($fp);

            Storage::disk('conciliaciones')->move('sftp//'.$archivo, 'sftp//'.$cuenta_p."//".$archivo);
	    //Storage::move($directorio_origen.'//'.$archivo, $directorio_destino.'//'.$cuenta_p."//".$archivo);
	    //Storage::disk('conciliaciones')->path('sftp//'.$archivo)
            $this->ejecutarConciliacion($cabecera->id);
            sleep(120);
        }
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
