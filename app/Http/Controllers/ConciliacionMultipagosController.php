<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Adeudo;
use App\AdeudoPagoOnLine;
use App\Caja;
use App\ConciliacionMultipago;
use App\ConciliacionMultiDetalle;
use App\CuentaP;
use Illuminate\Http\Request;
use App\Pago;
use App\PeticionMultipago;
use Auth;
use App\Http\Requests\updateConciliacionMultipago;
use App\Http\Requests\createConciliacionMultipago;
use App\SuccessMultipago;
use Storage;
use Log;

class ConciliacionMultipagosController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$conciliacionMultipagos = ConciliacionMultipago::getAllData($request);

		return view('conciliacionMultipagos.index', compact('conciliacionMultipagos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$cuentas = CuentaP::pluck('name', 'id');
		return view('conciliacionMultipagos.create', compact('cuentas'))
			->with('list', ConciliacionMultipago::getListFromAllRelationApps());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createConciliacionMultipago $request)
	{

		$input = $request->all();

		$input['fecha_carga'] = date('Y-m-d');
		$input['registros'] = 0;
		$input['contador_ejecucion'] = 0;
		$input['usu_alta_id'] = Auth::user()->id;
		$input['usu_mod_id'] = Auth::user()->id;

		$r = $request->hasFile('archivo');
		//dd($r);
		if ($r) {
			$archivo = $request->file('archivo');
			$input['archivo'] = $archivo->getClientOriginalName();
		}

		//create data
		$e = ConciliacionMultipago::create($input);

		if ($request->hasFile('archivo')) {
			$file = $request->file('archivo');
			$extension = $file->getClientOriginalExtension();
			$nombre = date('dmYhmi') . $file->getClientOriginalName();
			$r = Storage::disk('conciliaciones')->put($nombre, \File::get($file));

			$e->archivo = $nombre;
			$e->save();
		}

		//dd($file);
		$fp = fopen($file, "r");
		$i = 0;

		while (!feof($fp)) {
			$registro = array();
			//$file=storage_path('conciliaciones\\'.$nombre);
			$linea = fgets($fp);
			Log::info("linea " . $i . ": " . $linea);
			if (trim($linea) <> "") {
				$posicion = 0;
				$longitud = 0;
				$registro['conciliacion_multipago_id'] = $e->id;
				$longitud = 26;
				$registro['fecha_pago'] = substr($linea, $posicion, $longitud);
				$posicion = $posicion + $longitud + 1; //27
				$longitud = 50;
				$registro['razon_social'] = trim(substr($linea, $posicion, $longitud));
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
				$posicion = $posicion + $longitud;
				$longitud = 100;
				$registro['banco_emisor'] = trim(substr($linea, $posicion, $longitud));
				$posicion = $posicion + $longitud;
				$longitud = 100;
				$registro['mp_customername'] = trim(substr($linea, $posicion, $longitud));
				$posicion = $posicion + $longitud;
				$longitud = 50;
				$registro['mail'] = trim(substr($linea, $posicion, $longitud));
				$posicion = $posicion + $longitud;
				$longitud = 50;
				$registro['tel_customername'] = trim(substr($linea, $posicion, $longitud));
				$registro['usu_alta_id'] = Auth::user()->id;
				$registro['usu_mod_id'] = Auth::user()->id;
				//dd($registro);
				ConciliacionMultiDetalle::create($registro);
				$i++;
				//dd($registro['archivo']);
			}
		}
		$e->registros = $i;
		$e->update();

		fclose($fp);

		return redirect()->route('conciliacionMultipagos.index')->with('message', 'Registro Creado.');
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, ConciliacionMultipago $conciliacionMultipago)
	{
		$conciliacionMultipago = $conciliacionMultipago->find($id);
		$detalle = ConciliacionMultiDetalle::where('conciliacion_multipago_id', $id)->get();
		$registrosMontoDiferente = array();
		foreach ($detalle as $d) {
			$peticionBuscado = PeticionMultipago::where('mp_reference', $d->mp_reference)
				->where('mp_order', $d->mp_order)
				//->where('mp_amount', $pagoConciliacion->importe)
				->first();
			if (!is_null($peticionBuscado)) {
				if ($peticionBuscado->mp_amount <> $d->importe) {
					//dd($peticionBuscado);
					$adeudo_pago_on_line = AdeudoPagoOnLine::where('peticion_multipago_id', $peticionBuscado->id)->first();
					if (!is_null($adeudo_pago_on_line)) {
						array_push($registrosMontoDiferente, array(
							'referencia' => $d->mp_reference,
							'orden' => $d->mp_order,
							'conciliacion_importe' => $d->importe,
							'peticion_monto' => $peticionBuscado->mp_amount,
							'caja_consecutivo' => $adeudo_pago_on_line->caja->consecutivo,
							'caja_plantel' => $adeudo_pago_on_line->caja->plantel_id,
							'msj' => 'Montos diferentes entre la peticon y la conciliacion.'
						));
					} else {
						array_push($registrosMontoDiferente, array(
							'referencia' => $d->mp_reference,
							'orden' => $d->mp_order,
							'conciliacion_importe' => $d->importe,
							'peticion_monto' => $peticionBuscado->mp_amount,
							'caja_consecutivo' => '',
							'caja_plantel' => '',
							'msj' => 'Existe la peticion en linea, sin embargo el proceso de pago en linea fue cancelado.'
						));
					}
				}
			} else {
				array_push($registrosMontoDiferente, array(
					'referencia' => $d->mp_reference,
					'orden' => $d->mp_order,
					'conciliacion_importe' => $d->importe,
					'peticion_monto' => null,
					'caja_consecutivo' => '',
					'caja_plantel' => '',
					'msj' => 'Sin peticion en linea encontrada.'
				));
			}
		}
		//dd($registrosMontoDiferente);
		//dd($conciliacionMultipago->conciliacionMultiDetalles->toArray());
		return view('conciliacionMultipagos.show', compact('conciliacionMultipago', 'registrosMontoDiferente'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, ConciliacionMultipago $conciliacionMultipago)
	{
		$conciliacionMultipago = $conciliacionMultipago->find($id);
		return view('conciliacionMultipagos.edit', compact('conciliacionMultipago'))
			->with('list', ConciliacionMultipago::getListFromAllRelationApps());
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, ConciliacionMultipago $conciliacionMultipago)
	{
		$conciliacionMultipago = $conciliacionMultipago->find($id);
		return view('conciliacionMultipagos.duplicate', compact('conciliacionMultipago'))
			->with('list', ConciliacionMultipago::getListFromAllRelationApps());
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, ConciliacionMultipago $conciliacionMultipago, updateConciliacionMultipago $request)
	{
		$input = $request->all();
		$input['usu_mod_id'] = Auth::user()->id;
		//update data
		$conciliacionMultipago = $conciliacionMultipago->find($id);
		$conciliacionMultipago->update($input);

		return redirect()->route('conciliacionMultipagos.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id, ConciliacionMultipago $conciliacionMultipago)
	{
		$conciliacionMultipago = $conciliacionMultipago->find($id);
		$conciliacionMultipago->delete();

		return redirect()->route('conciliacionMultipagos.index')->with('message', 'Registro Borrado.');
	}

	public function ejecutarConciliacion(Request $request)
	{

		$registros = ConciliacionMultiDetalle::where('conciliacion_multipago_id', $request['id'])->get();

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
			}
		}

		$conciliacion = ConciliacionMultipago::find($request['id']);
		$conciliacion->contador_ejecucion = $conciliacion->contador_ejecucion + 1;
		$conciliacion->save();
		return redirect()->route('conciliacionMultipagos.index')->with('message', 'Ejecucion Exitosa.');
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

		if ($suma >= ($caja->total - 1) and $suma < ($caja->total + 100)) {

			foreach ($caja->cajaLns as $ln) {
				if ($ln->adeudo_id > 0) {
					Adeudo::where('id', '=', $ln->adeudo_id)->update(['pagado_bnd' => 1]);
					$adeudo = Adeudo::find($ln->adeudo_id);
					$adeudo->pagado_bnd = 1;
					$adeudo->save();
				}
			}

			$caja->st_caja_id = 1;
			//$caja->fecha=date_create(date_format(date_create(date('Y/m/d')),'Y/m/d'));
			$caja->save();
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


	public function rptConciliacion($id)
	{
		$conciliacion = ConciliacionMultipago::find($id);
		//dd($conciliacion);
		if (is_null($conciliacion->cuenta_p_id)) {
			$peticionesExistentes = PeticionMultipago::select('peticion_multipagos.*')
				->where('peticion_multipagos.updated_at', '>=', $conciliacion->fec_inicio)
				->where('peticion_multipagos.updated_at', '<=', $conciliacion->fec_fin)
				->with('pago')
				->get();
		} else {
			$peticionesExistentes = PeticionMultipago::select('peticion_multipagos.*')
				->join('pagos as p', 'p.id', '=', 'peticion_multipagos.pago_id')
				->join('cajas as c', 'c.id', '=', 'p.caja_id')
				->join('plantels as pla', 'pla.id', '=', 'c.plantel_id')
				->where('pla.cuenta_p_id', '=', $conciliacion->cuenta_p_id)
				->where('peticion_multipagos.updated_at', '>=', $conciliacion->fec_inicio)
				->where('peticion_multipagos.updated_at', '<=', $conciliacion->fec_fin)
				->with('pago')
				->get();
		}

		//dd($peticionesExistentes);
		$lnsDetalleConciliacion = $conciliacion->conciliacionMultiDetalles;
		//dd($lnsDetalleConciliacion->toArray());
		$registrosConciliados = array();

		foreach ($peticionesExistentes as $peticion) {
			//dd($peticion);
			$registro = array();
			$registro['plantel'] = optional($peticion->pago->caja->plantel)->razon;
			$registro['caja_consecutivo'] = $peticion->pago->caja->consecutivo;
			$registro['caja_monto'] = $peticion->pago->caja->total;
			$registro['caja_fecha'] = $peticion->pago->caja->fecha;
			$registro['pago_consecutivo'] = $peticion->pago->consecutivo;
			$registro['pago_fecha'] = $peticion->pago->fecha;
			$registro['pago_monto'] = $peticion->pago->fecha;
			$registro['peticion_fecha'] = $peticion->created_at;
			$registro['peticion_mp_node'] = $peticion->mp_node;
			$registro['peticion_mp_order'] = $peticion->mp_order;
			$registro['peticion_mp_reference'] = $peticion->mp_reference;
			$registro['peticion_mp_amount'] = $peticion->mp_amount;
			$registro['peticion_mp_paymentmethod'] = $peticion->mp_paymentmethod;
			$filtered = $lnsDetalleConciliacion->where('mp_order', $peticion->mp_order)
				->where('mp_reference', $peticion->mp_reference)
				->where('importe', $peticion->mp_amount)
				->first();
			//dd($filtered->toArray());
			if (!is_null($filtered) and $filtered->count() > 0) {
				$registro['conciliacion_no_aprobacion'] = optional($filtered)->no_aprobacion;
				$registro['conciliacion_importe'] = $filtered->importe;
				$registro['conciliacion_comision'] = $filtered->comision;
				$registro['conciliacion_iva_comision'] = $filtered->iva_comision;
				$registro['conciliacion_fecha_dispersion'] = $filtered->fecha_dispersion;
				$registro['respuesta_mp_response'] = optional($filtered->successMultipago)->mp_response;
				$registro['respuesta_mp_responsemsg'] = optional($filtered->successMultipago)->mp_responsemsg;
			} else {
				$registro['conciliacion_no_aprobacion'] = "";
				$registro['conciliacion_importe'] = "";
				$registro['conciliacion_comision'] = "";
				$registro['conciliacion_iva_comision'] = "";
				$registro['conciliacion_fecha_dispersion'] = "";
				$registro['respuesta_mp_response'] = '';
				$registro['respuesta_mp_responsemsg'] = '';
			}
			array_push($registrosConciliados, $registro);
		}
		//dd($registrosConciliados);

		$lineasConciliacionExtra = ConciliacionMultiDetalle::where('conciliacion_multipago_id', $conciliacion->id)
			->whereNull('peticion_multipago_id')
			->get();


		//dd($lineasConciliacionExtra->toArray());

		return view('conciliacionMultipagos.reportes.rptConciliacion', compact('registrosConciliados', 'lineasConciliacionExtra'));
	}
}
