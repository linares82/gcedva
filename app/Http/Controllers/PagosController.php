<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Adeudo;

use App\Caja;
use App\CuentasEfectivo;
use App\Cliente;
use App\CajaLn;
use App\CombinacionCliente;
use App\Empleado;
use App\Egreso;
use App\Mese;
use App\Exports\PagosExport;
use App\FormaPago;
use App\Inscripcion;
use App\Pago;
use App\PeticionMultipago;
use App\Param;
use App\Plantel;
use App\SuccessMultipago;
use App\FailMultipago;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updatePago;
use App\Http\Requests\createPago;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use App\ImpresionTicket;
use App\IngresoEgreso;
use App\SerieFolioSimplificado;
use App\Transference;
use DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Facades\Excel;
use Log;
use Luecano\NumeroALetras\NumeroALetras;

use Carbon\Carbon;

class PagosController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $pagos = Pago::getAllData($request);

        return view('pagos.index', compact('pagos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('pagos.create')
            ->with('list', Pago::getListFromAllRelationApps());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(createPago $request)
    {
        $input = $request->all();
        //dd($input);
        $caja = Caja::find($input['caja_id']);
        $input['usu_alta_id'] = Auth::user()->id;
        $input['usu_mod_id'] = Auth::user()->id;

        if (!isset($input['bnd_referenciado'])) {
            $input['bnd_referenciado'] = 0;
            $input['bnd_pagado'] = 1;
        }

        if ($input['bnd_referenciado'] == 1) {
            $input['bnd_pagado'] = 0;
        } else {
            $input['bnd_pagado'] = 1;
        }

        $plantel = Plantel::find($caja->plantel_id);
        $plantel->consecutivo_pago = $plantel->consecutivo_pago + 1;
        $plantel->save();
        $input['consecutivo'] = $plantel->consecutivo_pago;

        if ($input['forma_pago_id'] == 1) {
            $cuenta_efectivo = CuentasEfectivo::find($input['cuenta_efectivo_id']);
            $cuenta_efectivo->csc_efectivo = $cuenta_efectivo->csc_efectivo + 1;
            $cuenta_efectivo->save();
            $input['referencia'] = $cuenta_efectivo->csc_efectivo;
        }

        //create data
        //dd($input);
        $pago = Pago::create($input);


        //dd($caja->cajaLns);

        foreach ($caja->cajaLns as $ln) {
            if ($ln->adeudo_id > 0) {
                Adeudo::where('id', '=', $ln->adeudo_id)->update(['caja_id' => $caja->id]);
            }
        }

        $this->actualizaEstatusCaja($caja->id);
        $lineaCaja = CajaLn::where('caja_id', $caja->id)->first();

        if ($pago->bnd_referenciado == 1) {
            $datosMultipagos = array();
            $datosMultipagos['pago_id'] = $pago->id;
            $datosMultipagos['mp_account'] = 6683;
            $datosMultipagos['mp_product'] = $lineaCaja->cajaConcepto->cve_multipagos;
            $datosMultipagos['mp_order'] = $this->formatoDato('000', $caja->plantel_id) . $this->formatoDato('000000000', $caja->id) . $this->formatoDato('000000', $caja->consecutivo);
            $datosMultipagos['mp_reference'] = $this->formatoDato('000', $caja->plantel_id) . $this->formatoDato('000000000', $pago->id) . $this->formatoDato('000000', $pago->consecutivo);

            $datosMultipagos['mp_node'] = $pago->caja->plantel->cve_multipagos; //VAlor depente del plantel por ahora default
            $datosMultipagos['mp_concept'] = 1; //Valor depende del caja_conceptos por ahora default

            $datosMultipagos['mp_amount'] = number_format((float) $pago->monto, 2, '.', '');
            $cliNombre = $caja->cliente->nombre . " " . $caja->cliente->nombre2 . " " . $caja->cliente->ape_paterno . " " . $caja->cliente->ape_materno;
            $datosMultipagos['mp_customername'] = substr($cliNombre, 0, 50);
            $datosMultipagos['mp_currency'] = 1;
            $cadenaCifrar = $datosMultipagos['mp_order'] . $datosMultipagos['mp_reference'] . $datosMultipagos['mp_amount'];
            $parametros = Param::where('llave', 'cifrado_multipagos')->first();
            $datosMultipagos['mp_signature'] = hash_hmac('sha256', $cadenaCifrar, $parametros->valor);
            $parametros = Param::where('llave', 'url_success_multipagos')->first();
            $datosMultipagos['mp_urlsuccess'] = url($parametros->valor);
            $parametros = Param::where('llave', 'url_fail_multipagos')->first();
            $datosMultipagos['mp_urlfailure'] = url($parametros->valor);
            $datosMultipagos['usu_alta_id'] = 1;
            $datosMultipagos['usu_mod_id'] = 1;
            $parametros = Param::where('llave', 'url_multipagos')->first();
            $datosMultipagos['url_peticion'] = $parametros->valor;
            $datosMultipagos['mp_paymentmethod'] = $pago->forma_pago->cve_multipagos;
            //$respuesta = $this->multipagosSolicitud($datosMultipagos);

            //if ($respuesta) {
            //dd($datosMultipagos);
            PeticionMultipago::create($datosMultipagos);

            return response()->json([
                'datos' => $datosMultipagos,
            ], 200);
            //}
        }


        //dd($suma_pagos);
        //return redirect()->route('cajas.caja')->with('message', 'Registro Creado.');
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
                    Adeudo::where('id', '=', $ln->adeudo_id)->update(['pagado_bnd' => 1]);
                    $adeudo = Adeudo::find($ln->adeudo_id);
                    $adeudo->pagado_bnd = 1;
                    $adeudo->save();
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
            } elseif ($concepto == 0 and is_null($pago_final->csc_simplificado)) {
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

    public function formatoDato($cadena0, $dato)
    {
        return substr($cadena0, 1, (strlen($cadena0) - strlen($dato))) . $dato;
    }

    public function repetirMultipagosSolicitud(Request $request)
    {
        $datos = $request->all();
        $pago = Pago::find($datos['pago']);

        $peticionMultipago = $pago->peticionMultipago;
        $datosMultipagos = $peticionMultipago->toArray();
        unset($datosMultipagos['id']);
        unset($datosMultipagos['pago_id']);
        unset($datosMultipagos['contador_peticiones']);
        unset($datosMultipagos['usu_alta_id']);
        unset($datosMultipagos['usu_mod_id']);
        unset($datosMultipagos['created_at']);
        unset($datosMultipagos['updated_at']);
        unset($datosMultipagos['deleted_at']);
        $parametros = Param::where('llave', 'url_multipagos')->first();
        $datosMultipagos['url_peticion'] = $parametros->valor;
        //dd($datosMultipagos);
        //$respuesta = $this->multipagosSolicitud($datosMultipagos);
        $peticionMultipago->contador_peticiones = $peticionMultipago->contador_peticiones + 1;
        $peticionMultipago->update();

        return response()->json([
            'datos' => $datosMultipagos,
        ], 200);

        /*return view('cajas.caja', compact('cliente', 'caja', 'combinaciones', 'cajas'))
            ->with('list', Caja::getListFromAllRelationApps())
            ->with('list1', CajaLn::getListFromAllRelationApps());
            */
    }

    public function multipagosSolicitud($datosMultipagos)
    {
        $client = new Client([
            'headers' => ['Content-Type' => 'application/json']
        ]);

        $parametros = Param::where('llave', 'url_multipagos')->first();

        $res = $client->post(
            $parametros->valor,
            ['body' => json_encode(
                [
                    'mp_account' => $datosMultipagos['mp_account'],
                    'mp_product' => $datosMultipagos['mp_product'],
                    'mp_order' => $datosMultipagos['mp_order'],
                    'mp_reference' => $datosMultipagos['mp_reference'],
                    'mp_node' => $datosMultipagos['mp_node'],
                    'mp_concept' => $datosMultipagos['mp_concept'],
                    'mp_amount' => $datosMultipagos['mp_amount'],
                    'mp_customername' => $datosMultipagos['mp_customername'],
                    'mp_currency' => $datosMultipagos['mp_currency'],
                    'mp_signature' => $datosMultipagos['mp_signature'],
                    'mp_urlsuccess' => $datosMultipagos['mp_urlsuccess'],
                    'mp_urlfailure' => $datosMultipagos['mp_urlfailure']
                ]
            )]
        );

        //$response = $request->send();

        return $res->getStatusCode();
    }

    public function successMultipagos(Request $request)
    {

        $param = Param::where('llave', 'servidor_respuesta_multipagos')->first();

        //if ($dominio == $param->valor) {
        $datos = $request->all();
        //dd($datos);

        $crearRegistro = array();
        $crearRegistro['mp_order'] = $datos['mp_order'];
        $crearRegistro['mp_reference'] = $datos['mp_reference'];
        $crearRegistro['mp_amount'] = $datos['mp_amount'];
        $crearRegistro['mp_response'] = $datos['mp_response'];
        $crearRegistro['mp_responsemsg'] = $datos['mp_responsemsg'];
        $crearRegistro['mp_authorization'] = $datos['mp_authorization'];
        $crearRegistro['mp_signature'] = $datos['mp_signature'];
        $crearRegistro['mp_paymentmethod'] = $datos['mp_paymentmethod'];
        $crearRegistro[' usu_alta_id'] = 1;
        $crearRegistro['usu_mod_id'] = 1;

        $parametros = Param::where('llave', 'cifrado_multipagos')->first();
        $cadenaCifrar = $crearRegistro['mp_order'] . $crearRegistro['mp_reference'] . $crearRegistro['mp_amount'] . $crearRegistro['mp_authorization'];
        $nuevaFirma = hash_hmac('sha256', $cadenaCifrar, $parametros->valor);
        //dd($cadenaCifrar." - ".$nuevaFirma);    
        if ($nuevaFirma == $crearRegistro['mp_signature']) {
            $buscarRegistro = SuccessMultipago::where('mp_order', $crearRegistro['mp_order'])
                ->where('mp_reference', $crearRegistro['mp_reference'])
                ->where('mp_amount', $crearRegistro['mp_amount'])
                ->where('mp_signature', $crearRegistro['mp_signature'])
                ->first();
            if (is_null($buscarRegistro)) {
                SuccessMultipago::create($crearRegistro);
            }

            $peticion = PeticionMultipago::where('mp_order', $crearRegistro['mp_order'])
                ->where('mp_reference', $crearRegistro['mp_reference'])
                ->where('mp_amount', $crearRegistro['mp_amount'])
                ->first();
            $pago = Pago::find($peticion->pago_id);

            //dd($peticion->toArray());
            if ($datos['mp_response'] == '00') {
                //$pago = Pago::find($peticion->pago_id);
                $pago->bnd_pagado = 1;
                $pago->save();
                $this->actualizaEstatusCaja($pago->caja->id);
            }

            //dd($pago);
            $caja = $pago->caja;

            $errors = collect();

            /*
        return view('cajas.caja', 
        array('plantel'=>$caja->plantel_id,'consecutivo'=>$caja->consecutivo), 
        compact('errors'))
            ->with('list', Caja::getListFromAllRelationApps())
            ->with('list1', CajaLn::getListFromAllRelationApps());
            */
            //dd($caja->toArray());
            return redirect()->route('cajas.caja', array('plantel' => $caja->plantel_id, 'consecutivo' => $caja->consecutivo));
        } else {
            dd('Firma incorrecta');
        }
    }

    public function failMultipagos(Request $request)
    {
        $param = Param::where('llave', 'servidor_respuesta_multipagos')->first();
        Log::info("Se recibio peticion de: " . $request->path());
        if ($request->path() == $param->valor) {
            $datos = $request->all();
            $crearRegistro = array();
            $crearRegistro['mp_order'] = $datos['mp_order'];
            $crearRegistro['mp_reference'] = $datos['mp_reference'];
            $crearRegistro['mp_amount'] = $datos['mp_amount'];
            $crearRegistro['mp_response'] = $datos['mp_response'];
            $crearRegistro['mp_responsemsg'] = $datos['mp_responsemsg'];
            $crearRegistro['mp_authorization'] = $datos['mp_authorization'];
            $crearRegistro['mp_signature'] = $datos['mp_signature'];
            $crearRegistro[' usu_alta_id'] = 1;
            $crearRegistro['usu_mod_id'] = 1;

            FailMultipago::create($crearRegistro);
            $peticion = PeticionMultipago::where('mp_order', $crearRegistro['mp_order'])
                ->where('mp_reference', $crearRegistro['mp_reference'])
                ->where('mp_amount', $crearRegistro['mp_amount'])
                ->where('mp_signature', $crearRegistro['mp_signature'])
                ->first();
            $pago = Pago::find($peticion->pago_id);
            $pago->bnd_pagado = 0;
            return response()->json(['msj' => 'Peticion procesada'], 200);
        } else {
            return response()
                ->json(['msj' => 'Dominio de origen invalido'], 203);
        }
    }

    public function conciliacionMultipagos()
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id, Pago $pago)
    {
        $pago = $pago->find($id);
        return view('pagos.show', compact('pago'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id, Pago $pago)
    {
        $pago = $pago->find($id);
        return view('pagos.edit', compact('pago'))
            ->with('list', Pago::getListFromAllRelationApps());
    }

    /**
     * Show the form for duplicatting the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function duplicate($id, Pago $pago)
    {
        $pago = $pago->find($id);
        return view('pagos.duplicate', compact('pago'))
            ->with('list', Pago::getListFromAllRelationApps());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param Request $request
     * @return Response
     */
    public function update($id, Pago $pago, updatePago $request)
    {
        $input = $request->all();
        $input['usu_mod_id'] = Auth::user()->id;
        //update data
        $pago = $pago->find($id);
        $pago->update($input);

        return redirect()->route('pagos.index')->with('message', 'Registro Actualizado.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id, Pago $pago)
    {
        $pago = $pago->find($id);
        $pago->usu_delete_id = Auth::user()->id;
        $pago->save();
        $caja = Caja::find($pago->caja_id);
        //dd($caja);
        $pago->delete();


        //dd($caja->toArray());
        $combinaciones = CombinacionCliente::where('cliente_id', '=', $caja->cliente_id)->get();
        //dd($combinaciones->toArray());
        $cliente = Cliente::find($caja->cliente_id);
        $cajas = Caja::select('cajas.consecutivo as caja', 'ln.caja_concepto_id as concepto_id', 'cc.name as concepto', 'ln.total', 'st.name as estatus')
            ->join('caja_lns as ln', 'ln.caja_id', '=', 'cajas.id')
            ->join('caja_conceptos as cc', 'cc.id', '=', 'ln.caja_concepto_id')
            ->join('st_cajas as st', 'st.id', '=', 'cajas.st_caja_id')
            ->where('cliente_id', $cliente->id)
            ->get();

        $suma_pagos = Pago::select('monto')->where('caja_id', '=', $caja->id)->whereNull('deleted_at')->sum('monto');
        if ($suma_pagos == $caja->total) {
            $caja->st_caja_id = 1;
            $caja->save();

            foreach ($caja->cajaLns as $ln) {
                if ($ln->adeudo_id > 0) {
                    Adeudo::where('id', '=', $ln->adeudo_id)->update(['pagado_bnd' => 1]);
                }
            }
        } elseif ($suma_pagos == 0) {
            $caja->st_caja_id = 0;
            $caja->save();

            foreach ($caja->cajaLns as $ln) {
                if ($ln->adeudo_id > 0) {
                    Adeudo::where('id', '=', $ln->adeudo_id)->update(['pagado_bnd' => 0]);
                }
            }
        }
        if ($caja->st_caja_id == 1) {
            $caja->st_caja_id = 0;
            $caja->save();

            foreach ($caja->cajaLns as $ln) {
                if ($ln->adeudo_id > 0) {
                    Adeudo::where('id', '=', $ln->adeudo_id)->update(['pagado_bnd' => 0]);
                }
            }
        }

        /*
        if (count($caja->pagos) == 0)
            foreach ($caja->cajaLns as $ln) {
                if ($ln->adeudo_id > 0) {
                    Adeudo::where('id', '=', $ln->adeudo_id)->update(['caja_id' => 0]);
                }
            }
        */
        return view('cajas.caja', compact('cliente', 'caja', 'combinaciones', 'cajas'))
            ->with('list', Caja::getListFromAllRelationApps())
            ->with('list1', CajaLn::getListFromAllRelationApps());
    }

    public function imprimirFiscal(Request $request)
    {
        $data = $request->all();

        $pago = Pago::find($data['pago']);

        $caja = Caja::find($pago->caja_id);

        $atendio_pago = Empleado::where('user_id', $pago->usu_alta_id)->first();

        $input['caja_id'] = $caja->id;
        $input['pago_id'] = $pago->id;
        $input['cliente_id'] = $caja->cliente_id;
        $input['plantel_id'] = $caja->plantel_id;
        $input['consecutivo'] = $caja->consecutivo;
        $input['monto'] = $pago->monto;
        $input['toke_unico'] = uniqid(base64_encode(str_random(6)));
        $input['usu_alta_id'] = Auth::user()->id;
        $input['usu_mod_id'] = Auth::user()->id;
        $input['fecha_pago'] = $pago->fecha;
        $impresion_token = ImpresionTicket::create($input);

        $acumulado = Pago::select('monto')->where('caja_id', '=', $caja->id)->sum('monto');

        $adeudo = Adeudo::where('caja_id', '=', $caja->id)->first();

        if (!is_null($adeudo)) {
            $combinacion = CombinacionCliente::find($adeudo->combinacion_cliente_id);
            //dd($combinacion);
            $cliente = Cliente::find($caja->cliente_id);
            $empleado = Empleado::where('user_id', '=', Auth::user()->id)->first();

            $carbon = new \Carbon\Carbon();
            $date = $carbon->now();
            $date = $date->format('d-m-Y h:i:s');

            //dd($adeudo->toArray());
            /*return view('cajas.imprimirTicketPago', array(
                'cliente' => $cliente,
                'caja' => $caja,
                'empleado' => $empleado,
                'fecha' => $date,
                'combinacion' => $combinacion,
                'pago' => $pago,
                'acumulado' => $acumulado
            ));*/
        } else {
            $combinacion = 0;
            $cliente = Cliente::find($caja->cliente_id);
            $empleado = Empleado::where('user_id', '=', $pago->usua_alta_id)->first();

            $carbon = new \Carbon\Carbon();
            $date = $carbon->now();
            $date = $date->format('d-m-Y h:i:s');

            //dd($adeudo->toArray());

        }

        $formatter = new NumeroALetras;
        $totalEntero = intdiv($pago->monto, 1);
        $centavos = ($pago->monto - $totalEntero) * 100;
        $totalLetra = $formatter->toMoney($totalEntero, 2, "Pesos", 'Centavos');
        //dd($centavos);

        //dd($fechaLetra);


        return view('cajas.imprimirTicketPagoFiscal', array(
            'cliente' => $cliente,
            'caja' => $caja,
            'empleado' => $empleado,
            'fecha' => $date,
            'combinacion' => $combinacion,
            'pago' => $pago,
            'acumulado' => $acumulado,
            'impresion_token' => $impresion_token,
            'totalLetra' => $totalLetra,
            'centavos' => $centavos,
            'atendio_pago' => $atendio_pago
        ));
    }

    public function imprimirNoFiscal(Request $request)
    {
        $data = $request->all();

        $pago = Pago::find($data['pago']);

        $caja = Caja::find($pago->caja_id);

        $atendio_pago = Empleado::where('user_id', $pago->usu_alta_id)->first();

        $input['caja_id'] = $caja->id;
        $input['pago_id'] = $pago->id;
        $input['cliente_id'] = $caja->cliente_id;
        $input['plantel_id'] = $caja->plantel_id;
        $input['consecutivo'] = $caja->consecutivo;
        $input['monto'] = $pago->monto;
        $input['toke_unico'] = uniqid(base64_encode(str_random(6)));
        $input['usu_alta_id'] = Auth::user()->id;
        $input['usu_mod_id'] = Auth::user()->id;
        $input['fecha_pago'] = $pago->fecha;
        $impresion_token = ImpresionTicket::create($input);

        $acumulado = Pago::select('monto')->where('caja_id', '=', $caja->id)->sum('monto');

        $adeudo = Adeudo::where('caja_id', '=', $caja->id)->first();

        if (!is_null($adeudo)) {
            $combinacion = CombinacionCliente::find($adeudo->combinacion_cliente_id);
            //dd($combinacion);
            $cliente = Cliente::find($caja->cliente_id);
            $empleado = Empleado::where('user_id', '=', Auth::user()->id)->first();

            $carbon = new \Carbon\Carbon();
            $date = $carbon->now();
            $date = $date->format('d-m-Y h:i:s');

            //dd($adeudo->toArray());
            /*return view('cajas.imprimirTicketPago', array(
                'cliente' => $cliente,
                'caja' => $caja,
                'empleado' => $empleado,
                'fecha' => $date,
                'combinacion' => $combinacion,
                'pago' => $pago,
                'acumulado' => $acumulado
            ));*/
        } else {
            $combinacion = 0;
            $cliente = Cliente::find($caja->cliente_id);
            $empleado = Empleado::where('user_id', '=', $pago->usua_alta_id)->first();

            $carbon = new \Carbon\Carbon();
            $date = $carbon->now();
            $date = $date->format('d-m-Y h:i:s');

            //dd($adeudo->toArray());

        }

        $formatter = new NumeroALetras;
        $totalEntero = intdiv($pago->monto, 1);
        $centavos = ($pago->monto - $totalEntero) * 100;
        $totalLetra = $formatter->toMoney($totalEntero, 2, "Pesos", 'Centavos');
        //dd($centavos);

        //dd($fechaLetra);


        return view('cajas.imprimirTicketPagoNoFiscal', array(
            'cliente' => $cliente,
            'caja' => $caja,
            'empleado' => $empleado,
            'fecha' => $date,
            'combinacion' => $combinacion,
            'pago' => $pago,
            'acumulado' => $acumulado,
            'impresion_token' => $impresion_token,
            'totalLetra' => $totalLetra,
            'centavos' => $centavos,
            'atendio_pago' => $atendio_pago
        ));
    }

    public function imprimirTodosFiscal(Request $request)
    {
        $data = $request->all();
        //dd($data);
        //$pago = Pago::find($data['pago']);

        $caja = Caja::find($data['caja']);

        $token = uniqid(base64_encode(str_random(6)));
        foreach ($caja->pagos as $pago) {
            $input['caja_id'] = $caja->id;
            $input['pago_id'] = $pago->id;
            $input['cliente_id'] = $caja->cliente_id;
            $input['plantel_id'] = $caja->plantel_id;
            $input['consecutivo'] = $caja->consecutivo;
            $input['monto'] = $pago->monto;
            $input['toke_unico'] = $token;
            $input['usu_alta_id'] = Auth::user()->id;
            $input['usu_mod_id'] = Auth::user()->id;
            $input['fecha_pago'] = $pago->fecha;
            $impresion_token = ImpresionTicket::create($input);
        }

        $acumulado = Pago::select('monto')->where('caja_id', '=', $caja->id)->sum('monto');

        $adeudo = Adeudo::where('caja_id', '=', $caja->id)->first();

        if (!is_null($adeudo)) {
            $combinacion = CombinacionCliente::find($adeudo->combinacion_cliente_id);
            //dd($combinacion);
            $cliente = Cliente::find($caja->cliente_id);
            $empleado = Empleado::where('user_id', '=', Auth::user()->id)->first();

            $carbon = new \Carbon\Carbon();
            $date = $carbon->now();
            $date = $date->format('d-m-Y h:i:s');
        } else {
            $combinacion = 0;
            $cliente = Cliente::find($caja->cliente_id);
            $empleado = Empleado::where('user_id', '=', Auth::user()->id)->first();

            $carbon = new \Carbon\Carbon();
            $date = $carbon->now();
            $date = $date->format('d-m-Y h:i:s');

            //dd($adeudo->toArray());

        }

        foreach ($caja->pagos as $p) {
            $usu_alta = $p->usu_alta_id;
            break;
        }
        $atendio_pago = Empleado::where('user_id', $usu_alta)->first();


        $suma_pagos = 0;
        foreach ($caja->pagos as $pago) {
            $suma_pagos = $pago->monto + $suma_pagos;
        }
        $formatter = new NumeroALetras;
        $totalEntero = intdiv($suma_pagos, 1);
        $centavos = ($suma_pagos - $totalEntero) * 100;
        $totalLetra = $formatter->toMoney($totalEntero, 2, "Pesos", 'Centavos');

        return view('cajas.imprimirTicketFiscalPagos', array(
            'cliente' => $cliente,
            'caja' => $caja,
            'empleado' => $empleado,
            'fecha' => $date,
            'combinacion' => $combinacion,
            'pagos' => $caja->pagos,
            'acumulado' => $acumulado,
            'impresion_token' => $impresion_token,
            'atendio_pago' => $atendio_pago,
            'suma_pagos' => $suma_pagos,
            'totalLetra' => $totalLetra
        ));
    }

    public function imprimirTodosNoFiscal(Request $request)
    {
        $data = $request->all();

        //$pago = Pago::find($data['pago']);

        $caja = Caja::find($data['caja']);

        $token = uniqid(base64_encode(str_random(6)));
        foreach ($caja->pagos as $pago) {
            $input['caja_id'] = $caja->id;
            $input['pago_id'] = $pago->id;
            $input['cliente_id'] = $caja->cliente_id;
            $input['plantel_id'] = $caja->plantel_id;
            $input['consecutivo'] = $caja->consecutivo;
            $input['monto'] = $pago->monto;
            $input['toke_unico'] = $token;
            $input['usu_alta_id'] = Auth::user()->id;
            $input['usu_mod_id'] = Auth::user()->id;
            $input['fecha_pago'] = $pago->fecha;
            $impresion_token = ImpresionTicket::create($input);
        }

        $acumulado = Pago::select('monto')->where('caja_id', '=', $caja->id)->sum('monto');

        $adeudo = Adeudo::where('caja_id', '=', $caja->id)->first();

        if (!is_null($adeudo)) {
            $combinacion = CombinacionCliente::find($adeudo->combinacion_cliente_id);
            //dd($combinacion);
            $cliente = Cliente::find($caja->cliente_id);
            $empleado = Empleado::where('user_id', '=', Auth::user()->id)->first();

            $carbon = new \Carbon\Carbon();
            $date = $carbon->now();
            $date = $date->format('d-m-Y h:i:s');
        } else {
            $combinacion = 0;
            $cliente = Cliente::find($caja->cliente_id);
            $empleado = Empleado::where('user_id', '=', Auth::user()->id)->first();

            $carbon = new \Carbon\Carbon();
            $date = $carbon->now();
            $date = $date->format('d-m-Y h:i:s');

            //dd($adeudo->toArray());

        }

        foreach ($caja->pagos as $p) {
            $usu_alta = $p->usu_alta_id;
            break;
        }
        $atendio_pago = Empleado::where('user_id', $usu_alta)->first();

        $suma_pagos = 0;
        foreach ($caja->pagos as $pago) {
            $suma_pagos = $pago->monto + $suma_pagos;
        }
        $formatter = new NumeroALetras;
        $totalEntero = intdiv($suma_pagos, 1);
        $centavos = ($suma_pagos - $totalEntero) * 100;
        $totalLetra = $formatter->toMoney($totalEntero, 2, "Pesos", 'Centavos');


        return view('cajas.imprimirTicketNoFiscalPagos', array(
            'cliente' => $cliente,
            'caja' => $caja,
            'empleado' => $empleado,
            'fecha' => $date,
            'combinacion' => $combinacion,
            'pagos' => $caja->pagos,
            'acumulado' => $acumulado,
            'impresion_token' => $impresion_token,
            'atendio_pago' => $atendio_pago,
            'suma_pagos' => $suma_pagos,
            'totalLetra' => $totalLetra
        ));
    }

    public function pagosXPeriodoXPlantelXConcepto()
    {
        return view('pagos.reportes.pagosXplantelXPeriodoXConcepto')
            ->with('list', Pago::getListFromAllRelationApps())
            ->with('list2', Caja::getListFromAllRelationApps());
    }

    public function pagosXPeriodoXPlantelXConceptoR(Request $request)
    {
        $datos = $request->all();
        $plantel = Plantel::find($datos['plantel_f']);

        $registros_pagados = Caja::select('cc.name as concepto', DB::raw('sum(cln.total) as total'))
            ->join('caja_lns as cln', 'cln.caja_id', '=', 'cajas.id')
            ->join('pagos as p', 'p.caja_id', '=', 'cajas.id')
            ->join('caja_conceptos as cc', 'cc.id', '=', 'cln.caja_concepto_id')
            ->where('cajas.st_caja_id', 1)
            ->where('p.fecha', '>=', $datos['fecha_f'])
            ->where('p.fecha', '<=', $datos['fecha_t'])
            ->where('cajas.plantel_id', '=', $datos['plantel_f'])
            //->where('cajas.plantel_id','<=',$datos['plantel_t'])
            ->whereNull('cajas.deleted_at')
            ->whereNull('cln.deleted_at')
            ->whereNull('p.deleted_at')
            ->groupBy('cc.name')
            ->distinct()
            ->get();
        //dd($registros_pagados->toArray());

        $registros_parciales = Caja::select(DB::raw('sum(p.monto) as total'))
            ->join('pagos as p', 'p.caja_id', '=', 'cajas.id')
            ->join('caja_lns as cln', 'cln.caja_id', '=', 'cajas.id')
            ->join('caja_conceptos as cc', 'cc.id', '=', 'cln.caja_concepto_id')
            ->where('cajas.st_caja_id', 3)
            ->where('p.fecha', '>=', $datos['fecha_f'])
            ->where('p.fecha', '<=', $datos['fecha_t'])
            ->where('cajas.plantel_id', '=', $datos['plantel_f'])
            ->whereNull('cajas.deleted_at')
            ->whereNull('cln.deleted_at')
            ->whereNull('p.deleted_at')
            //->where('cajas.plantel_id','<=',$datos['plantel_t'])
            ->groupBy('cc.name')
            ->value('total');
        //dd($registros_pagados->toArray());

        return view('pagos.reportes.pagosXplantelXPeriodoXConceptoR', array(
            'registros_pagados' => $registros_pagados,
            'registros_parciales' => $registros_parciales,
            'plantel' => $plantel,
            'datos' => $datos
        ));
    }

    public function validarReferencia(Request $request)
    {
        if ($request->ajax()) {
            $datos = $request->all();
            //dd($datos);
            $registros = Pago::select('caja_id', 'plantel_id', 'p.cve_plantel', 'c.consecutivo')
                ->join('cajas as c', 'c.id', '=', 'pagos.caja_id')
                ->join('plantels as p', 'p.id', '=', 'c.plantel_id')
                ->where('pagos.referencia', $datos['referencia'])
                ->where('cuenta_efectivo_id', $datos['cuenta_efectivo_id'])
                ->get();
            return $registros;
            /*$resultado=array();
            if(count($registros)>0){
                array_push($resultado, array('total_coincidencias'=>count($registros)));
                array_push($resultado,array('pagos_coincidentes'=>$registros->toArray()));
                
            }else{
                array_push($resultado, array('total_coincidencias'=>0));
                
            }
            return response()->json($resultado);
            */
        }
    }

    public function getRptPagos()
    {
        $empleados = Empleado::select(DB::raw('concat(nombre," ",ape_paterno," ",ape_materno) as name, id'))->pluck('name', 'id');
        return view('pagos.reportes.inscritosPagos', compact('empleados'))
            ->with('list', Inscripcion::getListFromAllRelationApps());
    }

    public function postRptPagos(Request $request)
    {
        $data = $request->all();
        //dd($data);
        if (!$request->has('plantel_f')) {
            $data['plantel_f'] = DB::table('empleados as e')
                ->where('e.user_id', Auth::user()->id)->value('plantel_id');
            //$data['plantel_t'] = $datos['plantel_f'];
        }

        $plantel = Plantel::find($data['plantel_f']);
        //dd($data);
        $usuario = Empleado::whereIn('id', $data['empleado_f'])->pluck('user_id');
        //dd($usuario);

        $registros_pagados_aux = Caja::select(
            'pla.razon',
            'c.id',
            DB::raw('c.id as cliente_id,'
                . 'c.nombre, c.nombre2, c.ape_paterno, c.ape_materno, cajas.id as caja, cajas.consecutivo,'
                . 'c.beca_bnd, st.name as estatus_caja, fp.id as forma_pago_id, cajas.st_caja_id,'
                . 'pag.monto as monto_pago, fp.name as forma_pago, pag.fecha as fecha_pago, pag.created_at, cajas.fecha as fecha_caja,'
                . 'up.name as creador_pago, cln.caja_concepto_id')
        )
            ->join('clientes as c', 'c.id', '=', 'cajas.cliente_id')
            ->join('plantels as pla', 'pla.id', '=', 'c.plantel_id')
            ->join('st_cajas as st', 'st.id', '=', 'cajas.st_caja_id')
            ->join('pagos as pag', 'pag.caja_id', '=', 'cajas.id')
            ->join('users as up', 'up.id', 'pag.usu_alta_id')
            ->join('forma_pagos as fp', 'fp.id', '=', 'pag.forma_pago_id')
            ->join('caja_lns as cln', 'cln.caja_id', '=', 'cajas.id')
            ->where('cajas.plantel_id', '=', $data['plantel_f'])
            ->whereIn('cajas.usu_alta_id', $usuario)
            ->whereNull('pag.deleted_at')
            ->whereNull('cajas.deleted_at')
            ->where('cajas.st_caja_id', '=', 1)
            ->orderBy('fp.id')
            ->orderBy('cln.caja_concepto_id')
            //->orderBy('pag.fecha')
            ->distinct();
        if ($data['fecha_pago'] == 1) {
            $registros_pagados_aux->where('pag.fecha', '>=', $data['fecha_f'])
                ->whereDate('pag.fecha', '<=', $data['fecha_t']);
        } else {
            $registros_pagados_aux->where('pag.created_at', '>=', $data['fecha_f'])
                ->whereDate('pag.created_at', '<=', $data['fecha_t']);
        }
	$registros_pagados_aux2 = $registros_pagados_aux->get();
        //$registros_pagados=$registros_pagados_aux2->unique('consecutivo')->values()->all();

        $registros_pagados= $registros_pagados_aux2->unique(function ($item) {
            return $item['consecutivo'].$item['monto_pago'].$item['created_at'];
        })->values()->all();
        //dd($registros_pagados);
        $empleado = Empleado::where('user_id', Auth::user()->id)->first();

        $transferencias = Transference::select(
            'ceo.name as origen',
            'ced.name as destino',
            'po.razon as plantel_origen',
            'pd.razon as plantel_destino',
            'e.nombre',
            'e.ape_paterno',
            'e.ape_materno',
            'fecha',
            'monto'
        )
            ->join('cuentas_efectivos as ceo', 'ceo.id', '=', 'origen_id')
            ->join('cuentas_efectivos as ced', 'ced.id', '=', 'destino_id')
            ->join('plantels as po', 'po.id', '=', 'transferences.plantel_id')
            ->join('plantels as pd', 'pd.id', '=', 'transferences.plantel_destino_id')
            ->join('empleados as e', 'e.id', '=', 'transferences.responsable_id')
            ->whereDate('transferences.fecha', '>=', $data['fecha_f'])
            ->whereDate('transferences.fecha', '<=', $data['fecha_t'])
            ->WhereRaw('(transferences.plantel_id=? or transferences.plantel_destino_id=?)', [$data['plantel_f'], $data['plantel_f']])
            ->get();

        //dd($registros_pagados->toArray());

        $registros_parciales_aux = Caja::select(
            'pla.razon',
            'c.id',
            DB::raw(''
                . 'c.nombre, c.nombre2, c.ape_paterno, c.ape_materno, cajas.id as caja, cajas.consecutivo,'
                . 'c.beca_bnd, st.name as estatus_caja, cajas.total as total_caja, fp.id as forma_pago_id, cajas.st_caja_id,'
                . 'pag.monto as monto_pago, fp.name as forma_pago, pag.fecha as fecha_pago,pag.created_at, cajas.fecha as fecha_caja')
        )
            ->join('clientes as c', 'c.id', '=', 'cajas.cliente_id')
            ->join('plantels as pla', 'pla.id', '=', 'c.plantel_id')
            ->join('st_cajas as st', 'st.id', '=', 'cajas.st_caja_id')
            ->join('pagos as pag', 'pag.caja_id', '=', 'cajas.id')
            ->join('forma_pagos as fp', 'fp.id', '=', 'pag.forma_pago_id')
            ->where('cajas.plantel_id', '=', $data['plantel_f'])
            //->where('pag.fecha', '>=', $data['fecha_f'])
            //->where('pag.fecha', '<=', $data['fecha_t'])
            ->whereIn('cajas.usu_alta_id',  $usuario)
            ->whereNull('pag.deleted_at')
            ->where('cajas.st_caja_id', '=', 3)
            ->orderBy('fp.id')
            ->orderBy('pag.fecha')
            ->distinct();
        //->get();
        if ($data['fecha_pago'] == 1) {
            $registros_parciales_aux->where('pag.fecha', '>=', $data['fecha_f'])
                ->whereDate('pag.fecha', '<=', $data['fecha_t']);
        } else {
            $registros_parciales_aux->where('pag.created_at', '>=', $data['fecha_f'])
                ->whereDate('pag.created_at', '<=', $data['fecha_t']);
        }
        $registros_parciales = $registros_parciales_aux->get();

        $ingresosMenosEgresos = array();
        $formasPago = FormaPago::where('id', '>', 0)->get();
        foreach ($formasPago as $formaPago) {
            $ingresosMenosEgresos['egreso' . $formaPago->name] = 0;
            $ingresosMenosEgresos['ingreso' . $formaPago->name] = 0;
        }

        foreach ($registros_pagados as $registro_pagado) {

            foreach ($formasPago as $formaPago) {
                if ($formaPago->id == $registro_pagado->forma_pago_id) {
                    $ingresosMenosEgresos['ingreso' . $formaPago->name] = $ingresosMenosEgresos['ingreso' . $formaPago->name] + $registro_pagado->monto_pago;
                }
            }
        }
        //dd($ingresosMenosEgresos);
        foreach ($registros_parciales as $registro_pagado) {

            foreach ($formasPago as $formaPago) {
                if ($formaPago->id == $registro_pagado->forma_pago_id) {
                    $ingresosMenosEgresos['ingreso' . $formaPago->name] = $ingresosMenosEgresos['ingreso' . $formaPago->name] + $registro_pagado->monto_pago;
                }
            }
        }


        $egresos = Egreso::select(
            'egresos.id',
            'fecha',
            'ec.name as concepto',
            'fp.name as forma_pago',
            'ce.name as cuenta_efectivo',
            'monto',
            'fp.id as forma_pago_id'
        )
            ->join('egresos_conceptos as ec', 'ec.id', '=', 'egresos.egresos_concepto_id')
            ->join('cuentas_efectivos as ce', 'ce.id', '=', 'egresos.cuentas_efectivo_id')
            ->join('forma_pagos as fp', 'fp.id', 'egresos.forma_pago_id')
            ->where('egresos.fecha', '>=', $data['fecha_f'])
            ->where('egresos.fecha', '<=', $data['fecha_t'])
            ->where('egresos.plantel_id', '=', $data['plantel_f'])
            ->whereNull('egresos.deleted_at')
            ->orderBy('ce.id')
            ->get();

        foreach ($egresos as $registro_pagado) {

            foreach ($formasPago as $formaPago) {
                if ($formaPago->id == $registro_pagado->forma_pago_id) {
                    $ingresosMenosEgresos['egreso' . $formaPago->name] = $ingresosMenosEgresos['egreso' . $formaPago->name] + $registro_pagado->monto;
                }
            }
        }
        //dd($ingresosMenosEgresos);
        //dd($registros_parciales->toArray());


        /*
                PDF::setOptions(['defaultFont' => 'arial']);

                $pdf = PDF::loadView('inscripcions.reportes.lista_calificacionesr', array('registros'=>$registros,'carga_ponderacions_enc'=>$carga_ponderacion))
                        ->setPaper('legal', 'landscape');
                return $pdf->download('reporte.pdf');
                */
        return view('pagos.reportes.inscritosPagosR', array(
            'registros_pagados' => $registros_pagados,
            'registros_parciales' => $registros_parciales,
            'transferencias' => $transferencias,
            'plantel' => $plantel,
            'data' => $data,
            'egresos' => $egresos,
            'ingresosMenosEgresos' => $ingresosMenosEgresos,
            'formasPago' => $formasPago
        ));
    }

    public function getAlumnoBeca()
    {
        return view('pagos.reportes.getAlumnosBeca')
            ->with('list', Inscripcion::getListFromAllRelationApps());
    }

    public function postAlumnoBeca(Request $request)
    {
        $data = $request->all();
        if (!$request->has('plantel_f')) {
            $data['plantel_f'] = DB::table('empleados as e')
                ->where('e.user_id', Auth::user()->id)->value('plantel_id');
            //$data['plantel_t'] = $datos['plantel_f'];
        }

        $plantel = Plantel::find($data['plantel_f']);
        $registros = Cliente::select(DB::raw('clientes.id as cliente, '
            . 'concat(clientes.nombre," ",clientes.nombre2," ",clientes.ape_paterno," ",clientes.ape_materno) as cliente_nombre,'
            . 'clientes.beca_porcentaje as monto_inscripcion, clientes.monto_mensualidad, ab.solicitud as justificaion,'
            . 'sts.name as estatus_seguimiento, stc.name as estatus_cliente, beca_bnd, e.name as especialidad,'
            . 'n.name as nivel, g.name as grado'))
            ->join('combinacion_clientes as cc', 'cc.cliente_id', '=', 'clientes.id')
            ->join('especialidads as e', 'e.id', '=', 'cc.especialidad_id')
            ->join('grados as g', 'g.id', '=', 'cc.grado_id')
            ->join('nivels as n', 'n.id', '=', 'cc.nivel_id')
            ->join('seguimientos as s', 's.cliente_id', '=', 'clientes.id')
            ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
            ->join('st_clientes as stc', 'stc.id', '=', 'clientes.st_cliente_id')
            ->join('autorizacion_becas as ab', 'ab.cliente_id', '=', 'clientes.id')
            ->whereNull('cc.deleted_at')
            ->where('clientes.beca_bnd', 1)
            ->where('cc.bnd_beca', 1)
            ->where('st_beca_id', 4)
            ->where('clientes.st_cliente_id', 4)
            ->where('s.st_seguimiento_id', 2)
            ->where('clientes.plantel_id', $data['plantel_f'])
            //->where('cajas.usu_alta_id','<=',Auth::user()->id)
            ->orderBy('e.id')
            ->get();

        $resumen = array();
        $indicador = 0;
        $vespecialidad = "";
        $linea = array();
        $linea['cantidad'] = 0;
        $linea['suma_descuentos'] = 0;
        foreach ($registros as $registro) {
            $indicador++;
            if ($vespecialidad <> $registro->especialidad and $indicador <> 1) {
                array_push($resumen, $linea);
                $linea['suma_descuentos'] = 0;
                $linea['cantidad'] = 0;
            }
            $linea['especialidad'] = $registro->especialidad;
            $linea['cantidad'] = $linea['cantidad'] + 1;
            $cajas = Caja::select('cajas.consecutivo', 'cc.name as concepto', 'ln.subtotal', 'ln.descuento', 'ln.recargo', 'ln.total', 'a.fecha_pago')
                ->where('cajas.cliente_id', $registro->cliente)
                ->join('caja_lns as ln', 'ln.caja_id', '=', 'cajas.id')
                ->join('caja_conceptos as cc', 'cc.id', '=', 'ln.caja_concepto_id')
                ->join('adeudos as a', 'a.id', '=', 'ln.adeudo_id')
                ->where('a.fecha_pago', '>=', $data['fecha_f'])
                ->where('a.fecha_pago', '<=', $data['fecha_t'])
                ->where('ln.promo_plan_ln_id', 0)
                ->where('ln.descuento', '>', 0)
                ->get();
            if (count($cajas) > 0) {
                foreach ($cajas as $caja) {
                    $linea['suma_descuentos'] = $linea['suma_descuentos'] + $caja->descuento;
                }
            }
            $vespecialidad = $registro->especialidad;
        }
        array_push($resumen, $linea);

        if ($data['excel'] == 1) {
            return Excel::download(new PagosExport($registros->toArray(), $plantel->toArray(), $data, $resumen), 'pagos.xlsx');
        }

        return view('pagos.reportes.postAlumnosBeca', array(
            'registros' => $registros,
            'plantel' => $plantel,
            'data' => $data,
            'resumen' => $resumen
        ));
    }

    public function getResumenBeca()
    {
        return view('pagos.reportes.getResumenBeca')
            ->with('list', Inscripcion::getListFromAllRelationApps());
    }

    public function postResumenBeca(Request $request)
    {
        $data = $request->all();
        if (!$request->has('plantel_f')) {
            $data['plantel_f'] = DB::table('empleados as e')
                ->where('e.user_id', Auth::user()->id)->value('plantel_id');
            //$data['plantel_t'] = $datos['plantel_f'];
        }

        $plantel = Plantel::find($data['plantel_f']);
        $registros = Cliente::select(DB::raw('clientes.id as cliente, '
            . 'concat(clientes.nombre," ",clientes.nombre2," ",clientes.ape_paterno," ",clientes.ape_materno) as cliente_nombre,'
            . 'clientes.beca_porcentaje as monto_inscripcion, clientes.monto_mensualidad, ab.solicitud as justificaion,'
            . 'sts.name as estatus_seguimiento, stc.name as estatus_cliente, beca_bnd, e.name as especialidad,'
            . 'n.name as nivel, g.name as grado'))
            ->join('combinacion_clientes as cc', 'cc.cliente_id', '=', 'clientes.id')
            ->join('especialidads as e', 'e.id', '=', 'cc.especialidad_id')
            ->join('grados as g', 'g.id', '=', 'cc.grado_id')
            ->join('nivels as n', 'n.id', '=', 'cc.nivel_id')
            ->join('seguimientos as s', 's.cliente_id', '=', 'clientes.id')
            ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
            ->join('st_clientes as stc', 'stc.id', '=', 'clientes.st_cliente_id')
            ->join('autorizacion_becas as ab', 'ab.cliente_id', '=', 'clientes.id')
            ->whereNull('cc.deleted_at')
            ->where('clientes.beca_bnd', 1)
            ->where('cc.bnd_beca', 1)
            ->where('st_beca_id', 4)
            ->where('clientes.st_cliente_id', 4)
            ->where('s.st_seguimiento_id', 2)
            ->where('clientes.plantel_id', $data['plantel_f'])
            //->where('cajas.usu_alta_id','<=',Auth::user()->id)
            ->orderBy('e.id')
            ->get();
        $resumen = array();
        $indicador = 0;
        $vespecialidad = "";
        $linea = array();
        foreach ($registros as $registro) {
            $indicador++;
            if ($vespecialidad <> $registro->especialidad and $indicador <> 1) {
                array_push($resumen, $linea);
                $linea['suma_descuentos'] = 0;
                $linea['cantidad'] = 0;
            }
            $linea['especialidad'] = $registro->especialidad;
            $linea['cantidad'] = $linea['cantidad'] + 1;
            $cajas = Caja::select('cajas.consecutivo', 'cc.name as concepto', 'ln.subtotal', 'ln.descuento', 'ln.recargo', 'ln.total', 'a.fecha_pago')
                ->where('cajas.cliente_id', $registro->cliente)
                ->join('caja_lns as ln', 'ln.caja_id', '=', 'cajas.id')
                ->join('caja_conceptos as cc', 'cc.id', '=', 'ln.caja_concepto_id')
                ->join('adeudos as a', 'a.id', '=', 'ln.adeudo_id')
                ->where('a.fecha_pago', '>=', $data['fecha_f'])
                ->where('a.fecha_pago', '<=', $data['fecha_t'])
                ->where('ln.promo_plan_ln_id', 0)
                ->where('ln.descuento', '>', 0)
                ->get();
            if (count($cajas) > 0) {
                foreach ($cajas as $caja) {
                    $linea['suma_descuentos'] = $linea['suma_descuentos'] + $caja->descuento;
                }
            }
            $vespecialidad = $registro->especialidad;
        }
        array_push($resumen, $linea);
        //dd($resumen);
        return view('pagos.reportes.postResumenBeca', array(
            'registros' => $registros,
            'plantel' => $plantel,
            'data' => $data
        ));
    }

    public function pagosFacturas()
    {
        $plantels = Plantel::pluck('razon', 'id');
        return view('pagos.reportes.pagosFacturas', compact('plantels'));
    }

    public function pagosFacturasR(Request $request)
    {
        $datos = $request->all();
        $registros = Pago::select(
            'p.razon',
            'fp.name as forma_pago',
            'c.cliente_id',
            'c.consecutivo',
            'pagos.fecha as fecha_pago',
            'pagos.monto',
            'pagos.uuid'
        )
            ->join('cajas as c', 'c.id', '=', 'pagos.caja_id')
            ->join('plantels as p', 'p.id', '=', 'c.plantel_id')
            ->join('forma_pagos as fp', 'fp.id', '=', 'pagos.forma_pago_id')
            ->where('c.plantel_id', $datos['plantel_f'])
            ->where('pagos.fecha', '>=', $datos['fecha_f'])
            ->where('pagos.fecha', '<=', $datos['fecha_t'])
            ->where('pagos.bnd_pagado', 1)
            ->whereNull('pagos.deleted_at')
            ->whereNull('c.deleted_at')
            ->orderBy('p.razon')
            ->orderBy('fp.name')
            ->orderBy('pagos.uuid')
            ->get();
        //dd($registros->toArray());
        return view('pagos.reportes.pagosFacturasR', compact('registros'));
    }

    public function pagosCancelados()
    {
        $plantels = Plantel::pluck('razon', 'id');
        return view('pagos.reportes.pagosCancelados', compact('plantels'));
    }

    public function pagosCanceladosR(Request $request)
    {
        $datos = $request->all();
        //dd($datos);
        $registros = Pago::select(
            'p.razon',
            'fp.name as forma_pago',
            'c.cliente_id',
            'cli.matricula',
            'cli.nombre',
            'cli.nombre2',
            'cli.ape_paterno',
            'cli.ape_materno',
            'c.consecutivo',
            'pagos.csc_simplificado',
            'pagos.fecha as fecha_pago',
            'pagos.monto',
            'pagos.uuid',
            'pagos.bnd_pagado',
            'stcaj.name as stcaj',
            'pagos.deleted_at'
        )
            ->join('cajas as c', 'c.id', '=', 'pagos.caja_id')
            ->join('clientes as cli', 'cli.id', '=', 'c.cliente_id')
            ->join('st_cajas as stcaj','stcaj.id','=','c.st_caja_id')
            ->join('plantels as p', 'p.id', '=', 'c.plantel_id')
            ->join('forma_pagos as fp', 'fp.id', '=', 'pagos.forma_pago_id')
            ->where('c.plantel_id', $datos['plantel_f'])
            ->where('pagos.fecha', '>=', $datos['fecha_f'])
            ->where('pagos.fecha', '<=', $datos['fecha_t'])
            ->where('pagos.bnd_pagado', 1)
            //->whereNotNull('pagos.deleted_at')
            ->onlyTrashed()
            ->whereNull('c.deleted_at')
            ->orderBy('p.razon')
            ->orderBy('fp.name')
            ->orderBy('pagos.uuid')
            ->get();
        //dd($registros->toArray());
        return view('pagos.reportes.pagosCanceladosR', compact('registros'));
    }

    public function pagosEnLinea()
    {
        $plantels = Plantel::pluck('razon', 'id');
        return view('pagos.reportes.pagosEnLinea', compact('plantels'));
    }

    public function pagosEnLineaR(Request $request)
    {
        $datos = $request->all();
        //dd($datos);
        $registros = Pago::select(
            'p.razon',
            'fp.name as forma_pago',
            'c.cliente_id',
            'cli.matricula',
            'cli.nombre',
            'cli.nombre2',
            'cli.ape_paterno',
            'cli.ape_materno',
            'c.consecutivo',
            'pagos.csc_simplificado',
            'pagos.fecha as fecha_pago',
            'pagos.monto',
            'pagos.uuid',
            'pagos.bnd_pagado',
            'stcaj.name as stcaj',
            'pagos.deleted_at'
        )
            ->join('peticion_multipagos as pm','pm.pago_id','=','pagos.id')
            ->join('success_multipagos as sm','sm.mp_order','=','pm.mp_order')
            ->whereColumn('sm.mp_reference','pm.mp_reference')
            ->whereColumn('sm.mp_amount','pm.mp_amount')
            ->where('mp_response','00')
            ->join('cajas as c', 'c.id', '=', 'pagos.caja_id')
            ->join('clientes as cli', 'cli.id', '=', 'c.cliente_id')
            ->join('st_cajas as stcaj','stcaj.id','=','c.st_caja_id')
            ->join('plantels as p', 'p.id', '=', 'c.plantel_id')
            ->join('forma_pagos as fp', 'fp.id', '=', 'pagos.forma_pago_id')
            ->where('c.plantel_id', $datos['plantel_f'])
            ->where('pagos.fecha', '>=', $datos['fecha_f'])
            ->where('pagos.fecha', '<=', $datos['fecha_t'])
            ->where('pagos.bnd_pagado', 1)
            ->whereNull('pagos.deleted_at')
            ->whereNull('c.deleted_at')
            ->orderBy('p.razon')
            ->orderBy('fp.name')
            ->orderBy('pagos.uuid')
            ->get();
        //dd($registros->toArray());
        return view('pagos.reportes.pagosEnLineaR', compact('registros'));
    }

    public function pagosDosMeses(){
        $plantels = Plantel::pluck('razon', 'id');
        return view('pagos.reportes.pagosDosMeses', compact('plantels'));
    }

    public function pagosDosMesesR(Request $request){
        $datos=$request->all();
        //dd($datos);
        $anioActual=Carbon::createFromFormat('Y-m-d', $datos['fecha_f'])->year;
        $mesActual=Carbon::createFromFormat('Y-m-d', $datos['fecha_f'])->month;
        //dd('fi');
        $mesAnterior=0;
        $anioAnterior=0;
        $registros=array();
        if($mesActual==1){
            $mesAnterior=12;
            $anioAnterior=$anioActual-1;
        }else{
            $mesAnterior=$mesActual-1;
            $anioAnterior=$anioActual;
        }
        $mesAnteriorDesc=Mese::find($mesAnterior);
        $mesActualDesc=Mese::find($mesActual);
        array_push($registros, array('Planteles', $mesAnteriorDesc->name, $mesActualDesc->name, 'Porcentaje de Recuperacion', 'Diferencia'));
        foreach($datos['plantel_f'] as $plantel){
            $registro=array();
            $rPlantel=Plantel::find($plantel);
            $registro['plantel']=$rPlantel->razon;
            $r1=Caja::join('caja_lns as ln','ln.caja_id','=','cajas.id')
            ->join('caja_conceptos as cc','cc.id','=','ln.caja_concepto_id')
            ->join('pagos as p','p.caja_id','=','cajas.id')
            ->whereMonth('p.fecha', $mesAnterior)
            ->whereYear('p.fecha', $anioAnterior)
            ->where('cajas.plantel_id', $plantel)
            ->where('cajas.st_caja_id',1)
            ->where('cc.bnd_mensualidad',1)
            ->whereNull('cajas.deleted_at')
            ->whereNull('ln.deleted_at')
            ->whereNull('p.deleted_at')
            ->count();
            
            //$registro['mesAnterior']=$mes->name;
            $registro['mesAnteriorTotal']=number_format($r1);

            $r2=Caja::join('caja_lns as ln','ln.caja_id','=','cajas.id')
            ->join('caja_conceptos as cc','cc.id','=','ln.caja_concepto_id')
            ->join('pagos as p','p.caja_id','=','cajas.id')
            ->whereMonth('p.fecha', $mesActual)
            ->whereYear('p.fecha', $anioActual)
            ->where('cajas.plantel_id', $plantel)
            ->where('cajas.st_caja_id',1)
            ->where('cc.bnd_mensualidad',1)
            ->whereNull('cajas.deleted_at')
            ->whereNull('ln.deleted_at')
            ->whereNull('p.deleted_at')
            ->count();
            

            //$registro['mesActual']=$mes->name;
            $registro['mesActualTotal']=number_format($r2);
            if($r1==0 and $r2>0){
                $registro['recuperacion']=100;    
            }elseif(($r1>0 and $r2==0) or ($r1==0 and $r2==0)){
                $registro['recuperacion']=0;    
            }else{
                $registro['recuperacion']=number_format(($r2*100)/$r1,2);
            }
            $registro['diferencia']=number_format($r1-$r2);
            array_push($registros, $registro);
        }
        //dd($registros);
        
        return view('pagos.reportes.pagosDosMesesR', compact('registros'));
    }
}
