<?php

namespace App\Http\Controllers;

use DB;
use Log;
use PDF;
use Auth;
use Hash;
use Session;
use App\Caja;
use App\Mese;
use App\Pago;
use App\Grado;
use App\Param;
use Exception;
use App\Adeudo;
use App\CajaLn;
use App\StCaja;
use App\Cliente;
use App\Plantel;
use App\Empleado;
use App\PlanPago;
use App\Descuento;
use App\FormaPago;
use App\StCliente;
use Carbon\Carbon;
use App\PlanPagoLn;
use App\PromoPlanLn;
use App\Seguimiento;
use App\CajaConcepto;
use App\ReglaRecargo;
use App\UsuarioCliente;
use App\HistoriaCliente;
use App\AutorizacionBeca;
use App\CombinacionCliente;
use Illuminate\Support\Arr;
use App\PlantelAgrupamiento;
use Illuminate\Http\Request;
use App\ConsecutivoMatricula;
use App\Http\Requests\createAdeudo;
use App\Http\Requests\updateAdeudo;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;


class AdeudosController extends Controller
{
    public $plantel = 0;
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $adeudos = Adeudo::getAllData($request);

        return view('adeudos.index', compact('adeudos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('adeudos.create')
            ->with('list', Adeudo::getListFromAllRelationApps());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(createAdeudo $request)
    {

        $input = $request->all();
        $input['usu_alta_id'] = Auth::user()->id;
        $input['usu_mod_id'] = Auth::user()->id;

        //create data
        Adeudo::create($input);

        return redirect()->route('adeudos.index')->with('message', 'Registro Creado.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id, Adeudo $adeudo)
    {
        $adeudo = $adeudo->find($id);
        return view('adeudos.show', compact('adeudo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id, Adeudo $adeudo)
    {
        $adeudo = $adeudo->find($id);
        return view('adeudos.edit', compact('adeudo'))
            ->with('list', Adeudo::getListFromAllRelationApps());
    }

    /**
     * Show the form for duplicatting the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function duplicate($id, Adeudo $adeudo)
    {
        $adeudo = $adeudo->find($id);
        return view('adeudos.duplicate', compact('adeudo'))
            ->with('list', Adeudo::getListFromAllRelationApps());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param Request $request
     * @return Response
     */
    public function update($id, Adeudo $adeudo, updateAdeudo $request)
    {
        $input = $request->except(['porcentaje', 'autorizado_por', 'justificacion', 'autorizado_el', 'adeudo_id']);
        $inputDescuento = $request->only(['porcentaje', 'autorizado_por', 'justificacion', 'autorizado_el', 'adeudo_id']);
        $adeudo = $adeudo->find($id);
        if (isset($input['monto']) and $input['monto'] == "0") {
            $input['pagado_bnd'] = 1;

            //Genera la matricula para un cliente si no la tiene.
            //Datos para matricula

            $param = Param::where('llave', 'prefijo_matricula_instalacion')->first();
            $combinacion = CombinacionCliente::find($adeudo->combinacion_cliente_id);
            //dd($combinacion);
            $planPagoLn = PlanPagoLn::where('plan_pago_id', $combinacion->plan_pago_id)->orderBy('fecha_pago', 'asc')->first();

            $fecha = Carbon::createFromFormat('Y-m-d', $planPagoLn->fecha_pago);
            $grado = Grado::find($combinacion->grado_id);
            //dd($grado);
            $relleno = "000000";
            $rellenoPlantel = "00";
            $rellenoConsecutivo = "000";


            //dd($consecutivo);
            $cliente = Cliente::where('id', $combinacion->cliente_id)->first();
            /*if (
                $adeudo->caja_concepto_id == 1 or
                $adeudo->caja_concepto_id == 22 or
                $adeudo->caja_concepto_id == 23 or
                $adeudo->caja_concepto_id == 24 or
                $adeudo->caja_concepto_id == 25
            ) {*/
            if ($adeudo->cajaConcepto->bnd_genera_matricula == 1) {
                if (($grado->seccion != "" or !is_null($grado->seccion)) and ($cliente->matricula == "" or $cliente->matricula == " ")) {
                    $consecutivo = ConsecutivoMatricula::where('plantel_id', $combinacion->plantel_id)
                        ->where('anio', $fecha->year)
                        ->where('mes', $fecha->month)
                        ->where('seccion', $grado->seccion)
                        ->first();

                    if (is_null($consecutivo)) {
                        $consecutivo = ConsecutivoMatricula::create(array(
                            'plantel_id' => $combinacion->plantel_id,
                            'mes' => $fecha->month,
                            'anio' => $fecha->year,
                            'seccion' => $grado->seccion,
                            'consecutivo' => 1,
                            'usu_alta_id' => 1,
                            'usu_mod_id' => 1
                        ));
                    } else {
                        $consecutivo->consecutivo = $consecutivo->consecutivo + 1;
                        $consecutivo->save();
                    }
                    $mes = substr($rellenoPlantel, 0, 2 - strlen($fecha->month)) . $fecha->month;
                    $anio = $fecha->year - 2000;
                    $seccion = $grado->seccion;
                    $plantel = substr($rellenoPlantel, 0, 2 - strlen($combinacion->plantel_id)) . $combinacion->plantel_id;
                    $consecutivoCadena = substr($rellenoConsecutivo, 0, 3 - strlen($consecutivo->consecutivo)) . $consecutivo->consecutivo;

                    if ($param->valor <> "0") {
                        $entrada['matricula'] = $param->valor . $mes . $anio . $seccion . $plantel . $consecutivoCadena;
                    } else {
                        $entrada['matricula'] = $mes . $anio . $seccion . $plantel . $consecutivoCadena;
                    }

                    //$i->update($entrada);

                    //dd($entrada['matricula']);
                    $cliente->matricula = $entrada['matricula'];
                    $cliente->save();
                    Log::info('matricula cliente:' . $cliente->id . "-" . $cliente->matricula);

                    if (!is_null($cliente->matricula)) {
                        $buscarMatricula = UsuarioCliente::where('name', $cliente->matricula)->first();
                        $buscarMail = UsuarioCliente::where('email', $cliente->mail)->first();

                        if (is_null($buscarMatricula) and is_null($buscarMail)) {
                            $usuario_cliente['name'] = $cliente->matricula;
                            $usuario_cliente['email'] = $cliente->mail;
                            $usuario_cliente['password'] = Hash::make('123456');
                            UsuarioCliente::create($usuario_cliente);
                        }
                    }
                }
            }
        } else {
            $input['pagado_bnd'] = 0;
        }


        $input['usu_mod_id'] = Auth::user()->id;
        //update data

        //dd($input);
        $adeudo->update($input);

        //dd(!isset($adeudo->descuento->id));

        if (!isset($adeudo->descuento->id)) {
            if (
                isset($inputDescuento['adeudo_id']) and isset($inputDescuento['porcentaje']) and
                isset($inputDescuento['justificacion']) and isset($inputDescuento['autorizado_por']) and
                isset($inputDescuento['autorizado_el'])
            ) {
                $valores = array();
                $valores['adeudo_id'] = $inputDescuento['adeudo_id'];
                $valores['porcentaje'] = $inputDescuento['porcentaje'];
                $valores['justificacion'] = $inputDescuento['justificacion'];
                $valores['autorizado_por'] = $inputDescuento['autorizado_por'];
                $valores['autorizado_el'] = $inputDescuento['autorizado_el'];
                $valores['usu_alta_id'] = Auth::user()->id;
                $valores['usu_mod_id'] = Auth::user()->id;
                //dd($valores);
                try {
                    Descuento::create($valores);
                } catch (Exception $e) {
                    dd($e->getMessage());
                }
            }
        } else {
            if (
                isset($inputDescuento['porcentaje']) and
                isset($inputDescuento['justificacion']) and
                isset($inputDescuento['autorizado_por']) and
                isset($inputDescuento['autorizado_el'])
            ) {
                $valores = array(
                    'porcentaje' => $inputDescuento['porcentaje'],
                    'justificacion' => $inputDescuento['justificacion'],
                    'autorizado_por' => $inputDescuento['autorizado_por'],
                    'autorizado_el' => $inputDescuento['autorizado_el'],
                    'usu_mod_id' => Auth::user()->id
                );
                $adeudo->descuento->update($valores);
            }
        }

        return response()->json(['adeudo' => $adeudo]);
        //return redirect()->route('adeudos.index')->with('message', 'Registro Actualizado.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id, Adeudo $adeudo)
    {
        $adeudo = $adeudo->find($id);
        $caja = Caja::find($adeudo->caja_id);
        $cliente = Cliente::find($adeudo->cliente_id);
        $cajas = Caja::select('cajas.consecutivo as caja', 'ln.caja_concepto_id as concepto_id', 'cc.name as concepto', 'ln.total', 'st.name as estatus')
            ->join('caja_lns as ln', 'ln.caja_id', '=', 'cajas.id')
            ->join('caja_conceptos as cc', 'cc.id', '=', 'ln.caja_concepto_id')
            ->join('st_cajas as st', 'st.id', '=', 'cajas.st_caja_id')
            ->where('cliente_id', $adeudo->cliente->id)
            ->whereNull('cajas.deleted_at')
            ->whereNull('ln.deleted_at')
            ->get();
        $adeudo->delete();


        $combinaciones = CombinacionCliente::where('cliente_id', '=', $cliente->id)->get();

        $empleados = Empleado::select(DB::raw('concat(nombre," ",ape_paterno," ",ape_materno) as name, id'))->pluck('name', 'id');

        return view('cajas.caja', compact('cliente', 'combinaciones', 'caja', 'cajas', 'empleados'))
            ->with('list', Caja::getListFromAllRelationApps())
            ->with('list1', CajaLn::getListFromAllRelationApps());
    }

    public function imprimirInicial(Request $request)
    {
        $data = $request->all();
        //dd($data);

        $cliente = Cliente::find($data['cliente']);
        $plantel = Plantel::find($cliente->plantel_id);
        $combinacion = CombinacionCliente::find($data['combinacion']);

        if ($combinacion->cuenta_ticket_pago == 0) {
            foreach ($combinacion->planPago->Lineas as $adeudo) {
                $registro['cliente_id'] = $cliente->id;
                $registro['caja_id'] = 0;
                $registro['combinacion_cliente_id'] = $combinacion->id;
                $registro['caja_concepto_id'] = $adeudo->caja_concepto_id;
                $registro['cuenta_contable_id'] = $adeudo->cuenta_contable_id;
                $registro['cuenta_recargo_id'] = $adeudo->cuenta_recargo_id;
                $registro['fecha_pago'] = $adeudo->fecha_pago;
                $registro['monto'] = $adeudo->monto;
                $registro['inicial_bnd'] = $adeudo->inicial_bnd;
                $registro['pagado_bnd'] = 0;
                $registro['plan_pago_ln_id'] = $adeudo->id;
                $registro['usu_alta_id'] = Auth::user()->id;
                $registro['usu_mod_id'] = Auth::user()->id;
                //dd($registro);
                Adeudo::create($registro);
            }
        }
        $combinacion->cuenta_ticket_pago = $combinacion->cuenta_ticket_pago + 1;
        $combinacion->save();

        if ($combinacion->cuenta_ticket_pago == 1) {
            $seguimiento = Seguimiento::where('cliente_id', $cliente->id)->first();
            $seguimiento->st_seguimiento_id = 5;
            $seguimiento->save();

            $cliente->st_cliente_id = 1;
            $cliente->save();
        }

        $adeudos = Adeudo::where('cliente_id', '=', $cliente->id)
            ->where('combinacion_cliente_id', '=', $combinacion->id)
            ->where('inicial_bnd', 1)
            ->get();

        $empleado = Empleado::where('user_id', '=', Auth::user()->id)->first();
        $carbon = new \Carbon\Carbon();
        $date = $carbon->now();
        $date = $date->format('d-m-Y h:i:s');

        //dd($adeudo->toArray());
        return view('adeudos.ticket_adeudo_inicial', array(
            'cliente' => $cliente,
            'adeudos' => $adeudos,
            'empleado' => $empleado,
            'fecha' => $date,
            'combinacion' => $combinacion,
            'plantel' => $plantel,
        ));

        /*PDF::setOptions(['defaultFont' => 'arial']);
    $paper58mm100 = array(0,0,164.4,283.46);

    $pdf = PDF::loadView('adeudos.ticket_adeudo_inicial', array('cliente'=>$cliente, 'adeudos'=>$adeudos))
    //->setPaper('A8', 'portrait');
    ->setPaper($paper58mm100, 'portrait');
    return $pdf->download('reporte.pdf');
     */
    }

    public function reporteAdeudosPendientes()
    {

        $planteles = Plantel::pluck('razon', 'id');
        $conceptos = CajaConcepto::pluck('name', 'id');
        return view('adeudos.reportes.adeudosXplantel', compact('planteles', 'conceptos'));
    }

    public function reporteAdeudosPendientesr(Request $request)
    {
        $datos = $request->all();

        $fecha = date('Y/m/d');
        //dd($fecha);
        //$empleado=Empleado::where('user_id', '=', Auth::user()->id)->first();

        $plantel = Plantel::find($datos['plantel_f']);
        //dd($plantel);


        $adeudosPendientes = Adeudo::select(
            'esp.name as especialidad',
            'n.name as nivel',
            'g.name as grado',
            'cc.id as combinacion',
            'c.id as cliente',
            'c.nombre',
            'c.nombre2',
            'c.ape_paterno',
            'c.ape_materno',
            DB::raw('sum(adeudos.monto) as deuda')
        )
            ->join('combinacion_clientes as cc', 'cc.id', "=", 'adeudos.combinacion_cliente_id')
            ->join('especialidads as esp', 'esp.id', '=', 'cc.especialidad_id')
            ->join('nivels as n', 'n.id', '=', 'cc.nivel_id')
            ->join('grados as g', 'g.id', '=', 'cc.grado_id')
            ->join('clientes as c', 'c.id', '=', 'adeudos.cliente_id')
            ->join('st_clientes as stc', 'stc.id', '=', 'c.st_cliente_id')
            ->join('seguimientos as s', 's.cliente_id', '=', 'c.id')
            ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
            //->where('pagado_bnd', '=', 0)
            ->whereDate('adeudos.fecha_pago', '<=', $fecha)
            ->where('c.plantel_id', '=', $datos['plantel_f'])
            ->whereIn('stc.id', array(4, 25))
            ->where('sts.id', 2)
            ->groupBy('esp.name')->groupBy('n.name')->groupBy('g.name')->groupBy('c.id')->groupBy('cc.id')
            ->groupBy('c.nombre')->groupBy('c.nombre2')->groupBy('c.ape_paterno')->groupBy('c.ape_materno')
            ->orderBy('c.id', 'asc')
            ->get();

        //dd($adeudosPendientes);
        return view('adeudos.reportes.adeudos_pendientes', array('adeudos' => $adeudosPendientes, 'plantel' => $plantel));

        /*$pdf = PDF::loadView('adeudos.adeudos_pendientes', array('adeudos'=>$adeudosPendientes, 'plantel'=>$plantel))
    ->setPaper('Letter', 'portrait');
    return $pdf->download('AdeudosPendientes.pdf');
     */
    }

    public function reporteAdeudosPlan()
    {
        $empleado = Empleado::where('user_id', '=', Auth::user()->id)->where('st_empleado_id', '<>', 3)->first();

        $plantels = array();
        foreach ($empleado->plantels as $p) {
            //dd($p->id);
            array_push($plantels, $p->id);
        }

        $planteles = Plantel::whereIn('id', $plantels)->pluck('razon', 'id');
        $planes = PlanPago::pluck('name', 'id');
        $conceptos = CajaConcepto::pluck('name', 'id');
        //dd($conceptos);
        $estatus = StCaja::pluck('name', 'id');
        return view('adeudos.reportes.adeudosXPlan', compact('planteles', 'planes', 'estatus', 'conceptos'));
    }

    public function reporteAdeudosPlanr(Request $request)
    {
        $datos = $request->all();
        //dd($datos);

        $fecha = date('Y/m/d');
        //dd($fecha);
        //$empleado=Empleado::where('user_id', '=', Auth::user()->id)->first();
        if (!$request->has('plantel_f')) {
            $datos['plantel_f'] = DB::table('empleados as e')
                ->where('e.user_id', Auth::user()->id)->value('plantel_id');
            //$datos['plantel_t'] = $datos['plantel_f'];
        }

        $plantel = Plantel::find($datos['plantel_f']);

        $cajas = PlanPago::select(
            'plan_pagos.name as plan',
            'plan_pagos.id as plan_id',
            'caj.id as caja',
            'caj.consecutivo',
            'c.id as cliente',
            'c.nombre',
            'c.nombre2',
            'c.ape_paterno',
            'c.ape_materno',
            'st.name as estatus',
            'st.id as estatus_caja',
            'p.razon',
            'stc.name as estatus_cliente',
            't.name as turno'
        )
            ->join('combinacion_clientes as cc', 'cc.plan_pago_id', '=', 'plan_pagos.id')
            ->join('turnos as t', 't.id', '=', 'cc.turno_id')
            ->join('clientes as c', 'c.id', '=', 'cc.cliente_id')
            ->join('st_clientes as stc', 'stc.id', '=', 'c.st_cliente_id')
            ->join('cajas as caj', 'caj.cliente_id', '=', 'c.id')
            ->join('plantels as p', 'p.id', '=', 'c.plantel_id')
            ->join('st_cajas as st', 'st.id', '=', 'caj.st_caja_id')
            ->whereIn('plan_pagos.id', $datos['plan_f'])
            //->where('plan_pagos.id','<=',$datos['plan_t'])
            ->where('c.plantel_id', '=', $datos['plantel_f'])
            ->whereIn('caj.st_caja_id', $datos['estatus_f'])
            //->where('st.id','<>',2)
            ->whereNull('cc.deleted_at')
            ->whereNull('plan_pagos.deleted_at')
            ->whereNull('caj.deleted_at')
            ->where('st_caja_id', '<>', 2)
            ->orderBy('c.plantel_id', 'asc')
            ->orderBy('plan_pagos.id', 'asc')
            ->orderBy('c.id', 'asc')
            ->get();
        //dd($cajas->toArray());
        return view(
            'adeudos.reportes.adeudosPlanr',
            array('cajas' => $cajas, 'plantel' => $plantel, 'plan' => $datos['plan_f'], 'datos' => $datos)
        );

        /*$pdf = PDF::loadView('adeudos.adeudos_pendientes', array('adeudos'=>$adeudosPendientes, 'plantel'=>$plantel))
    ->setPaper('Letter', 'portrait');
    return $pdf->download('AdeudosPendientes.pdf');
     */
    }

    public function destroyAll(Request $request)
    {
        $datos = $request->all();
        $combinacion = CombinacionCliente::find($datos['combinacion']);
        $combinacion->cuenta_ticket_pago = 0;
        $combinacion->save();
        $adeudos = Adeudo::where('cliente_id', $datos['cliente'])
            ->where('combinacion_cliente_id', $datos['combinacion'])
            ->get();
        if (count($adeudos) > 0) {
            foreach ($adeudos as $adeudo) {
                $adeudo->delete();
            }
        }
        return redirect()->route('clientes.edit', array('id' => $datos['cliente']))->with('message', 'Registro Borrado.');
    }

    public function editMonto(Request $request)
    {
        $datos = $request->all();
        //dd($datos);
        $adeudo = Adeudo::find($datos['id']);
        $adeudo->monto = $datos['monto'];
        $adeudo->save();
        echo json_encode(array('monto' => $datos['monto']));
    }

    public function cambiarPlanPagos(Request $request)
    {
        $data = $request->all();
        $cliente = Cliente::find($data['cliente']);
        if ($cliente->st_cliente_id <> 3) {
            $adeudos_sin_pagar = Adeudo::where('cliente_id', $data['cliente'])
                ->where('combinacion_cliente_id', $data['combinacion'])
                ->where('pagado_bnd', 0)
                ->where('caja_id', 0)
                ->delete();
            /*$mensualidades_pagadas=Adeudo::where('cliente_id',$data['cliente'])
        ->where('pagado_bnd',1)
        ->orWhere('caja_id','>',0)
        ->join('caja_conceptos as cc','cc.id','=','adeudos.caja_concepto_id')
        ->where('cc.bnd_mensualidad',1)
        ->get();
         */

            //dd($cliente);
            //$cliente->st_cliente_id=22;
            //$cliente->save();
            $plantel = Plantel::find($cliente->plantel_id);
            $combinacion = CombinacionCliente::find($data['combinacion']);
            $combinacion->cuenta_ticket_pago = 1;
            $combinacion->save();
            $lineas = PlanPagoLn::where('plan_pago_id', $combinacion->plan_pago_id)->get();
            //$combinacion->planPago->Lineas;
            $i = 0;
            $descarte_inicial = 0;
            foreach ($lineas as $adeudo) {
                //conceptos diferentes de mensualidad, se ignoran los Ãƒâ€šÃ‚Â´primeros 3
                //if($adeudo->cajaConcepto->bnd_mensualidad<>1 and $descarte_inicial>3){
                $mensualidad_pagada = Adeudo::where('cliente_id', $data['cliente'])
                    ->where('caja_concepto_id', $adeudo->caja_concepto_id)
                    ->where('fecha_pago', $adeudo->fecha_pago)
                    ->where('pagado_bnd', 1)
                    ->where('caja_id', '>', 0)
                    ->whereNull('deleted_at')
                    ->first();
                //dd($mensualidad_pagada);
                if (is_null($mensualidad_pagada)) {
                    $registro['cliente_id'] = $cliente->id;
                    $registro['caja_id'] = 0;
                    $registro['combinacion_cliente_id'] = $combinacion->id;
                    $registro['caja_concepto_id'] = $adeudo->caja_concepto_id;
                    $registro['cuenta_contable_id'] = $adeudo->cuenta_contable_id;
                    $registro['cuenta_recargo_id'] = $adeudo->cuenta_recargo_id;
                    $registro['fecha_pago'] = $adeudo->fecha_pago;
                    $registro['monto'] = $adeudo->monto;
                    $registro['inicial_bnd'] = $adeudo->inicial_bnd;
                    $registro['pagado_bnd'] = 0;
                    $registro['plan_pago_ln_id'] = $adeudo->id;
                    $registro['usu_alta_id'] = Auth::user()->id;
                    $registro['usu_mod_id'] = Auth::user()->id;
                    //dd($registro);
                    Adeudo::create($registro);
                }

                //$descarte_inicial++;
                //Mensualidadaes se descarta la misma cantidad que ya se haya pagado en el plan anterior
                /*}elseif($adeudo->cajaConcepto->bnd_mensualidad==1 and $i>count($mensualidades_pagadas)){
        $registro['cliente_id']=$cliente->id;
        $registro['caja_id']=0;
        $registro['combinacion_cliente_id']=$combinacion->id;
        $registro['caja_concepto_id']=$adeudo->caja_concepto_id;
        $registro['cuenta_contable_id']=$adeudo->cuenta_contable_id;
        $registro['cuenta_recargo_id']=$adeudo->cuenta_recargo_id;
        $registro['fecha_pago']=$adeudo->fecha_pago;
        $registro['monto']=$adeudo->monto;
        $registro['inicial_bnd']=$adeudo->inicial_bnd;
        $registro['pagado_bnd']=0;
        $registro['plan_pago_ln_id']=$adeudo->id;
        $registro['usu_alta_id']=Auth::user()->id;
        $registro['usu_mod_id']=Auth::user()->id;
        //dd($registro);
        Adeudo::create( $registro );
        $i++;
        } */
            }

            //$combinacion->cuenta_ticket_pago=$combinacion->cuenta_ticket_pago+1;
            $combinacion->save();
        }

        //$adeudos=Adeudo::where('cliente_id', '=', $cliente->id)->where('combinacion_cliente_id', '=', $combinacion->id)->get();
        //$empleado=Empleado::where('user_id', '=', Auth::user()->id)->first();
        //$carbon = new \Carbon\Carbon();
        //$date = $carbon->now();
        //$date = $date->format('d-m-Y h:i:s');

        //dd($adeudo->toArray());
        /*return view('adeudos.ticket_adeudo_inicial', array('cliente'=>$cliente,
        'adeudos'=>$adeudos,
        'empleado'=>$empleado,
        'fecha'=>$date,
        'combinacion'=>$combinacion,
        'plantel'=>$plantel ));
         */
        return redirect()->route('clientes.edit', $cliente->id)->with('message', 'Registro Creado.')->with('list', Cliente::getListFromAllRelationApps());
    }

    public function ajustarAdeudosSegunPlan()
    {
        $planes = PlanPagoLn::whereIn('plan_pago_id', array(2, 3, 5, 8, 23, 24, 29))
            ->where('caja_concepto_id', 46)
            ->orderBy('plan_pago_id')
            ->get();

        $csvDatos = array('id, cliente_id, caja_concepto_id, cuenta_contable_id, cuenta_recargo_id, fecha_pago, monto, inicial_bnd, pagado_bnd, '
            . 'plan_pago_ln_id, usu_alta_id, usu_mod_id, created_at, update_at, deleted_at, combinacion_cliente_id, caja_id');
        foreach ($planes as $plan) {
            $combinaciones = CombinacionCliente::where('plan_pago_id', $plan->plan_pago_id)
                ->where('combinacion_clientes.especialidad_id', '<>', 0)
                ->where('combinacion_clientes.nivel_id', '<>', 0)
                ->where('combinacion_clientes.grado_id', '<>', 0)
                ->where('combinacion_clientes.turno_id', '<>', 0)
                ->whereNull('combinacion_clientes.deleted_at')
                ->get();
            foreach ($combinaciones as $combinacion) {
                $adeudos = Adeudo::where('cliente_id', $combinacion->cliente_id)
                    ->where('caja_concepto_id', 46)
                    ->where('combinacion_cliente_id', $combinacion->id)
                    ->first();
                //dd($adeudos);
                if (!is_object($adeudos)) {

                    $adeudo_nuevo['cliente_id'] = $combinacion->cliente_id;
                    $adeudo_nuevo['caja_concepto_id'] = $plan->caja_concepto_id;
                    $adeudo_nuevo['cuenta_contable_id'] = $plan->cuenta_contable_id;
                    $adeudo_nuevo['cuenta_recargo_id'] = $plan->cuenta_recargo_id;
                    $adeudo_nuevo['fecha_pago'] = $plan->fecha_pago;
                    $adeudo_nuevo['monto'] = $plan->monto;
                    $adeudo_nuevo['inicial_bnd'] = $plan->inicial_bnd;
                    $adeudo_nuevo['pagado_bnd'] = 0;
                    $adeudo_nuevo['plan_pago_ln_id'] = $plan->id;
                    $adeudo_nuevo['usu_alta_id'] = 1;
                    $adeudo_nuevo['usu_mod_id'] = 1;
                    $adeudo_nuevo['created_t'] = '2019-06-07 00:00:00';
                    $adeudo_nuevo['update_at'] = '2019-06-07 00:00:00';
                    $adeudo_nuevo['combinacion_cliente_id'] = $combinacion->id;
                    $adeudo_nuevo['caja_id'] = 0;
                    $a = Adeudo::create($adeudo_nuevo);

                    $csvDatos[] = $a->id . ',' . $combinacion->cliente_id . ',' . $plan->caja_concepto_id . ',' . $plan->cuenta_contable_id . ',' . $plan->cuenta_recargo_id . ',' .
                        $plan->fecha_pago . ',' . $plan->monto . ',' . $plan->inicial_bnd . ',' . '0' . ',' . $plan->id . ',' . '1' . ',' . '1' . ',' . 'NULL' . ',' . 'NULL' . ',' .
                        'NULL' . ',' . $combinacion->id . ',' . '0';
                }
            }
        }
        //dd($csvDatos);
        $filename = date('Y-m-d') . ".csv";
        $file_path = public_path() . '/' . $filename;
        $file = fopen($file_path, "w+");
        foreach ($csvDatos as $exp_data) {
            fputcsv($file, explode(',', $exp_data));
        }
        fclose($file);

        $headers = ['Content-Type' => 'application/csv'];
        return response()->download($file_path, $filename, $headers);
    }

    public function adeudosPagos()
    {

        $planteles = Plantel::pluck('razon', 'id');
        $conceptos = CajaConcepto::pluck('name', 'id');
        $stCajas = StCaja::pluck('name', 'id');
        //dd($stCajas);
        return view('adeudos.reportes.adeudosPagos', compact('planteles', 'conceptos', 'stCajas'));
    }

    public function adeudosPagosR(Request $request)
    {

        $datos = $request->all();
        //dd($datos);
        $fecha_reporte = date('Y-m-d');
        $reglas = ReglaRecargo::where('porcentaje', '>', 0)->get();

        $adeudos = Adeudo::select(DB::raw('adeudos.id, p.razon, concat(c.nombre," ",c.nombre2," ",c.ape_paterno," ",c.ape_materno) as nombre_cliente, '
            . 'c.id as cliente, pp.name as plan_pago, adeudos.monto as monto_planeado, adeudos.fecha_pago as fecha_pago_planeada,'
            . 'con.name as concepto, caj.fecha as fecha_caja, adeudos.pagado_bnd, adeudos.caja_id, adeudos.caja_concepto_id, caj.consecutivo,'
            . 'adeudos.plan_pago_ln_id'))
            ->join('clientes as c', 'c.id', '=', 'adeudos.cliente_id')
            ->join('seguimientos as s', 's.cliente_id', '=', 'c.id')
            ->join('plantels as p', 'p.id', '=', 'c.plantel_id')
            ->join('plan_pago_lns as ppln', 'ppln.id', '=', 'adeudos.plan_pago_ln_id')
            ->join('plan_pagos as pp', 'pp.id', '=', 'ppln.plan_pago_id')
            ->leftJoin('cajas as caj', 'caj.id', '=', 'adeudos.caja_id')
            //->leftJoin('pagos as pag','pag.caja_id','=','caj.id')
            //->leftJoin('forma_pagos as fp','fp.id','=','pag.forma_pago_id')
            ->join('caja_conceptos as con', 'con.id', '=', 'adeudos.caja_concepto_id')
            ->join('combinacion_clientes as cc', 'cc.id', '=', 'adeudos.combinacion_cliente_id')
            ->where('c.st_cliente_id', 4)
            ->where('cc.especialidad_id', '<>', 0)
            ->where('cc.nivel_id', '<>', 0)
            ->where('cc.grado_id', '<>', 0)
            ->where('cc.turno_id', '<>', 0)
            ->where('adeudos.fecha_pago', '>=', $datos['fecha_f'])
            ->where('adeudos.fecha_pago', '<=', $datos['fecha_t'])
            ->where('c.plantel_id', '>=', $datos['plantel_f'])
            ->where('c.plantel_id', '<=', $datos['plantel_t'])
            ->whereIn('adeudos.caja_concepto_id', $datos['concepto_f'])
            //->whereColumn('adeudos.caja_concepto_id','ln.caja_concepto_id')
            ->where('s.st_seguimiento_id', '<>', 3)
            //->where('caj.st_caja_id', $datos['st_caja_f'])
            ->whereNull('adeudos.deleted_at')
            ->whereNull('cc.deleted_at')
            ->whereNull('c.deleted_at')
            ->whereNull('caj.deleted_at')
            ->whereNull('ppln.deleted_at')
            //->whereNull('pag.deleted_at')
            ->orderBy('p.razon')
            ->orderBy('adeudos.caja_id')
            ->orderBy('c.id')
            ->orderBy('caj.st_caja_id')
            ->orderBy('adeudos.id')
            ->get();

        //dd($adeudos);

        $registros = array();
        $vcaja = 0;
        $vconcepto = 0;
        foreach ($adeudos as $adeudo) {
            $adeudo_monto = 0;
            $pago_monto = 0;
            if ($adeudo->caja_id > 0) {
                $linea_caja = CajaLn::select('caja_lns.*', 'st.name as estatus')
                    ->join('cajas as c', 'c.id', '=', 'caja_lns.caja_id')
                    ->join('st_cajas as st', 'st.id', '=', 'c.st_caja_id')
                    ->where('caja_id', $adeudo->caja_id)
                    ->where('caja_concepto_id', $adeudo->caja_concepto_id)
                    ->whereNull('caja_lns.deleted_at')
                    ->first();
                $pagos = Pago::where('caja_id', $linea_caja->caja_id)->get();
                $monto_pago_suma = 0;
                foreach ($pagos as $pago) {
                    $monto_pago_suma = $monto_pago_suma + $pago->monto;
                }

                $vadeudo = 0;
                $vpago = 0;
                $pago_monto = $linea_caja->total;
                if ($linea_caja->estatus == 'Pago Parcial' and $vcaja != $adeudo->caja_id) {
                    $vadeudo = $linea_caja->total - $monto_pago_suma;
                    $vpago = $monto_pago_suma;
                } else {
                    $vadeudo = $adeudo_monto;
                    $vpago = $pago_monto;
                }

                $vcaja = $adeudo->caja_id;
                $vconcepto = $adeudo->caja_concepto_id;

                $row = array(
                    'id' => $adeudo->id,
                    'razon' => $adeudo->razon,
                    'cliente' => $adeudo->cliente,
                    'nombre_cliente' => $adeudo->nombre_cliente,
                    'plan_pago' => $adeudo->plan_pago,
                    'monto_planeado' => $adeudo->monto_planeado,
                    'concepto' => $adeudo->concepto,
                    'fecha_pago_planeada' => $adeudo->fecha_pago_planeada,
                    'fecha_caja' => $adeudo->fecha_caja,
                    'monto_descuento' => $linea_caja->descuento,
                    'monto_recargo' => $linea_caja->recargo,
                    'pago' => $vpago,
                    'adeudo' => $vadeudo,
                    'caja_id' => $adeudo->caja_id,
                    'st_caja' => $linea_caja->estatus,
                    'consecutivo' => $adeudo->consecutivo,
                    'plan_pago_ln' => $adeudo->plan_pago_ln_id,
                    'monto_pago_suma' => $monto_pago_suma,
                );
                array_push($registros, $row);
            } else {
                $caja_ln_calculada = $this->calculaAdeudo($adeudo->id, $adeudo->cliente);
                $row = array(
                    'id' => $adeudo->id,
                    'razon' => $adeudo->razon,
                    'cliente' => $adeudo->cliente,
                    'nombre_cliente' => $adeudo->nombre_cliente,
                    'plan_pago' => $adeudo->plan_pago,
                    'monto_planeado' => $adeudo->monto_planeado,
                    'concepto' => $adeudo->concepto,
                    'fecha_pago_planeada' => $adeudo->fecha_pago_planeada,
                    'fecha_caja' => $adeudo->fecha_caja,
                    'monto_descuento' => $caja_ln_calculada['descuento'],
                    'monto_recargo' => $caja_ln_calculada['recargo'],
                    'pago' => 0,
                    'adeudo' => $caja_ln_calculada['total'],
                    'caja_id' => $adeudo->caja_id,
                    'st_caja' => '',
                    'consecutivo' => '',
                    'plan_pago_ln' => $adeudo->plan_pago_ln_id,
                    'monto_pago_suma' => 0,
                );
                array_push($registros, $row);
            }
        }
        //$c=Collection::make($registros);

        //dd(Collection::make($registros));
        return view('adeudos.reportes.adeudosPagosR', array(
            'fecha_reporte' => $fecha_reporte,
            'registros' => $registros,
            'adeudos' => $adeudos,
            'reglas' => $reglas,
        ));
    }

    public function calculaAdeudo($adeudo_tomado, $vcliente)
    {
        //foreach($data['adeudos_tomados'] as $adeudo_tomado){
        $adeudos = Adeudo::where('id', '=', $adeudo_tomado)->get();
        //$caja=Caja::find();
        $cliente = Cliente::find($vcliente);

        //dd($adeudos->toArray());
        $subtotal = 0;
        $recargo = 0;
        $descuento = 0;
        //dd($adeudos->toArray());

        foreach ($adeudos as $adeudo) {
            $existe_linea = CajaLn::where('adeudo_id', '=', $adeudo->id)->first();
            if (!is_object($existe_linea)) {

                //$caja_ln['caja_id']=$caja->id;
                $caja_ln['caja_concepto_id'] = $adeudo->caja_concepto_id;
                $caja_ln['subtotal'] = $adeudo->monto;
                //                    dd($adeudo->planPagoLn->reglaRecargos);
                $caja_ln['total'] = 0;
                $caja_ln['recargo'] = 0;
                $caja_ln['descuento'] = 0;
                foreach ($adeudo->planPagoLn->reglaRecargos as $regla) {
                    $fecha_caja = Carbon::createFromFormat('Y-m-d', date('Y-m-d'));
                    $fecha_adeudo = Carbon::createFromFormat('Y-m-d', date('Y-m-d'));
                    $dias = $fecha_caja->diffInDays($fecha_adeudo);
                    if ($fecha_caja < $fecha_adeudo) {
                        $dias = $dias * -1;
                    }
                    //dd($dias);
                    //$dia=$dias->format('%R%a')*-1;

                    //calcula recargo o descuento segun regla y aplica
                    if ($dias >= $regla->dia_inicio and $dias <= $regla->dia_fin) {
                        if ($regla->tipo_regla_id == 1) {
                            //dd($regla->porcentaje);
                            if ($regla->porcentaje > 0) {
                                //dd($regla->porcentaje);
                                $caja_ln['recargo'] = $adeudo->monto * $regla->porcentaje;
                                //echo $caja_ln['recargo'];
                            } else {
                                $caja_ln['descuento'] = $adeudo->monto * $regla->porcentaje * -1;
                                //echo $caja_ln['descuento'];
                            }
                        } elseif ($regla->tipo_regla_id == 2) {
                            if ($regla->monto > 0) {
                                $caja_ln['recargo'] = $regla->monto;
                            } else {
                                $caja_ln['descuento'] = $regla->monto * -1;
                            }
                        }
                    }
                }
                $caja_ln['total'] = 0;
                $caja_ln['total'] = $caja_ln['subtotal'] + $caja_ln['recargo'] - $caja_ln['descuento'];

                //calcula descuento segun promocion ligada a la linea del plan considerando la fecha de pago de la
                //inscripcion del cliente
                //dd($adeudo);
                try {
                    $promociones = PromoPlanLn::where('plan_pago_ln_id', $adeudo->plan_pago_ln_id)->get();
                    $caja_ln['promo_plan_ln_id'] = 0;
                    //Log::info($cliente->id . "FLC:" . $cliente->beca_bnd . "-" . $adeudo->combinacionCliente->bnd_beca);
                    if ($cliente->beca_bnd != 1 and $adeudo->combinacionCliente->bnd_beca != 1) {
                        foreach ($promociones as $promocion) {
                            $inscripcion = Adeudo::where('cliente_id', $adeudo->cliente_id)
                                //->where('plan_pago_ln_id',$adeudo->plan_pago_ln_id)
                                ->where('caja_concepto_id', 1)
                                ->where('combinacion_cliente_id', $adeudo->combinacion_cliente_id)
                                ->where('pagado_bnd', 1)
                                ->first();

                            //dd($inscripcion);
                            if (is_object($inscripcion)) {
                                $inicio = Carbon::createFromFormat('Y-m-d', $promocion->fec_inicio);
                                $fin = Carbon::createFromFormat('Y-m-d', $promocion->fec_fin);

                                //$hoy=date('Y-m-d');
                                //$hoy=Carbon::now();
                                //La caja tiene la fecha de pago de un solo concepto que debe ser la inscripcion
                                $caja_inscripcion = Caja::find($inscripcion->caja_id);
                                //dd($caja);
                                $hoy = Carbon::createFromFormat('Y-m-d', $caja_inscripcion->fecha);
                                //$hoy=Carbon::createFromFormat('Y-m-d', $adeudo->caja->fecha);
                                //dd($hoy);
                                $monto_promocion = 0;
                                //dd($hoy);
                                if ($inicio->lessThanOrEqualTo($hoy) and $fin->greaterThanOrEqualTo($hoy) and $caja_ln['promo_plan_ln_id'] == 0) {

                                    $monto_promocion = $promocion->descuento * $caja_ln['total'];
                                    $caja_ln['descuento'] = $caja_ln['descuento'] + $monto_promocion;
                                    $caja_ln['promo_plan_ln_id'] = $promocion->id;
                                }
                            } else {
                                $inicio = Carbon::createFromFormat('Y-m-d', $promocion->fec_inicio);
                                $fin = Carbon::createFromFormat('Y-m-d', $promocion->fec_fin);

                                //$hoy=date('Y-m-d');
                                //$hoy=Carbon::now();
                                //La caja tiene la fecha de pago de un solo concepto que debe ser la inscripcion
                                //dd($inscripcion);
                                //$caja_inscripcion=Caja::find($caja->id);
                                $hoy = Carbon::createFromFormat('Y-m-d', date('Y-m-d'));
                                $monto_promocion = 0;
                                //dd($hoy);
                                if ($inicio->lessThanOrEqualTo($hoy) and $fin->greaterThanOrEqualTo($hoy) and $caja_ln['promo_plan_ln_id'] == 0) {

                                    $monto_promocion = $promocion->descuento * $caja_ln['total'];
                                    $caja_ln['descuento'] = $caja_ln['descuento'] + $monto_promocion;
                                    $caja_ln['promo_plan_ln_id'] = $promocion->id;
                                }
                            }
                        }
                    } elseif ($cliente->beca_bnd == 1 and $adeudo->combinacionCliente->bnd_beca == 1) {
                        if ($cliente->monto_mensualidad > 0 and is_int(strpos($adeudo->cajaConcepto->name, 'MENSUALIDAD'))) {
                            $caja_ln['descuento'] = $caja_ln['descuento'] + $cliente->monto_mensualidad;
                        }
                        if ($cliente->beca_porcentaje > 0 and is_int(strpos($adeudo->cajaConcepto->name, 'INSCRIP'))) {
                            $caja_ln['descuento'] = $caja_ln['descuento'] + $cliente->beca_porcentaje;
                        }
                    }
                    //dd($promocion);
                    //if(is_object($promocion)){

                    //dd($monto_promocion);
                    //dd($caja_ln);
                } catch (Exception $e) {
                    dd($e);
                }
                $caja_ln['total'] = $caja_ln['subtotal'] + $caja_ln['recargo'] - $caja_ln['descuento'];

                $caja_ln['adeudo_id'] = $adeudo->id;
                $caja_ln['usu_alta_id'] = Auth::user()->id;
                $caja_ln['usu_mod_id'] = Auth::user()->id;
                /*if($cliente->beca_bnd==1 and $caja_ln['caja_concepto_id']==1){
                $caja_ln['descuento']=$caja_ln['descuento']+($caja_ln['subtotal']*$cliente->beca_porcentaje);
                $caja_ln['total']=$caja_ln['total']-($caja_ln['subtotal']-$caja_ln['descuento']);
                }*/
                //dd($caja_ln);
                return $caja_ln;
            }
        }

        //}

    }

    public function maestro()
    {
        if (Auth::user()->can('adeudos.maestroXPlantel')) {
            $empleado = Empleado::where('user_id', Auth::user()->id)->first();
            $planteles = array();
            foreach ($empleado->plantels as $p) {
                //dd($p->id);
                array_push($planteles, $p->id);
            }

            $planteles = Plantel::whereIn('id', $planteles)->pluck('razon', 'id');
        } else {
            $planteles = Plantel::pluck('razon', 'id');
        }

        $conceptos = CajaConcepto::pluck('name', 'id');

        //dd($stCajas);
        return view('adeudos.reportes.maestro', compact('planteles', 'conceptos'));
    }

    public function maestroR(Request $request)
    {
        $datos = $request->all();
        //dd($datos);
        $hoy = Carbon::createFromFormat('Y-m-d', Date('Y-m-d'));
        $lineas_procesadas = array();
        $lineas_detalle = array();
        foreach ($datos['plantel_f'] as $plantel) {

            $registros_totales_aux = Adeudo::join('clientes as c', 'c.id', '=', 'adeudos.cliente_id')
                ->join('st_clientes as stc', 'stc.id', '=', 'c.st_cliente_id')
                ->join('seguimientos as s', 's.cliente_id', '=', 'c.id')
                ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
                ->join('caja_conceptos as adeudo_concepto', 'adeudo_concepto.id', '=', 'adeudos.caja_concepto_id')
                ->join('combinacion_clientes as ccli', 'ccli.id', '=', 'adeudos.combinacion_cliente_id')
                ->join('especialidads as esp', 'esp.id', '=', 'ccli.especialidad_id')
                ->join('turnos as t', 't.id', '=', 'ccli.turno_id');
            if ($datos['detalle_f'] == 1) {
                $registros_totales_aux->leftJoin('caja_lns as cln', 'cln.adeudo_id', '=', 'adeudos.id')
                    ->leftJoin('cajas as caj', 'caj.id', '=', 'adeudos.caja_id')
                    ->join('plantels as p', 'p.id', '=', 'c.plantel_id')
                    ->join('caja_conceptos as cc', 'cc.id', '=', 'adeudos.caja_concepto_id');
            } elseif ($datos['detalle_f'] == 2) {
                $cajas_sin_adeudos = Caja::select(
                    DB::raw('0 as adeudo'),
                    'p.razon',
                    'c.id',
                    'c.nombre',
                    'c.nombre2',
                    'c.ape_paterno',
                    'c.ape_materno',
                    'c.matricula',
                    'cc.name as concepto',
                    'cc.id as concepto_id',
                    'cln.total as pago_calculado_adeudo',
                    'cajas.id as caja',
                    'cajas.consecutivo',
                    'cln.deleted_at as borrado_cln',
                    'cajas.deleted_at as borrado_c',
                    'cajas.usu_alta_id',
                    'c.st_cliente_id',
                    'stc.name as st_cliente',
                    's.st_seguimiento_id',
                    'sts.name as st_seguimiento',
                    DB::raw('date(0000-00-00) as fecha_pago'),
                    'cajas.id',
                    'cc.name as mensualidad',
                    DB::raw('1 as pagado_bnd'),
                    't.name as turno',
                    'pag.monto as monto_pago',
                    'esp.name as especialidad'
                )
                    ->join('clientes as c', 'c.id', '=', 'cajas.cliente_id')
                    ->join('st_clientes as stc', 'stc.id', '=', 'c.st_cliente_id')
                    ->join('seguimientos as s', 's.cliente_id', '=', 'c.id')
                    ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
                    ->join('plantels as p', 'p.id', '=', 'cajas.plantel_id')
                    ->join('caja_lns as cln', 'cln.caja_id', '=', 'cajas.id')
                    ->join('caja_conceptos as cc', 'cc.id', 'cln.caja_concepto_id')
                    ->join('pagos as pag', 'pag.caja_id', '=', 'cajas.id')
                    ->join('combinacion_clientes as ccli', 'ccli.cliente_id', '=', 'c.id')
                    ->join('especialidads as esp', 'esp.id', '=', 'ccli.especialidad_id')
                    ->join('turnos as t', 't.id', '=', 'ccli.turno_id')
                    ->where('cajas.plantel_id', $plantel)
                    ->where('cajas.st_caja_id', 1)
                    ->where('cln.adeudo_id', 0)
                    ->whereNull('cln.deleted_at')
                    ->whereNull('pag.deleted_at')
                    ->whereIn('cc.id', $datos['concepto_f'])
                    ->whereNull('p.deleted_at')
                    ->whereNull('cajas.deleted_at')
                    ->whereNull('ccli.deleted_at');
                //->get();
                //dd($cajas_sin_adeudos->toArray());
                $registros_totales_aux->join('caja_lns as cln', 'cln.adeudo_id', '=', 'adeudos.id')
                    ->join('cajas as caj', 'caj.id', '=', 'adeudos.caja_id')
                    ->join('pagos as pag', 'pag.caja_id', '=', 'caj.id')
                    ->join('plantels as p', 'p.id', '=', 'caj.plantel_id')
                    ->whereDate('pag.fecha', '>=', $datos['fecha_f'])
                    ->whereDate('pag.fecha', '<=', $datos['fecha_t'])
                    ->join('caja_conceptos as cc', 'cc.id', '=', 'adeudos.caja_concepto_id')
                    ->where('caj.st_caja_id', 1)
                    ->whereNull('cln.deleted_at')
                    ->whereNull('pag.deleted_at')
                    ->select(
                        'adeudos.id as adeudo',
                        'p.razon',
                        'c.id',
                        'c.nombre',
                        'c.nombre2',
                        'c.ape_paterno',
                        'c.ape_materno',
                        'c.matricula',
                        'cc.name as concepto',
                        'cc.id as concepto_id',
                        'cln.total as pago_calculado_adeudo',
                        'caj.id as caja',
                        'caj.consecutivo',
                        'cln.deleted_at as borrado_cln',
                        'caj.deleted_at as borrado_c',
                        'caj.usu_alta_id',
                        'c.st_cliente_id',
                        'stc.name as st_cliente',
                        's.st_seguimiento_id',
                        'sts.name as st_seguimiento',
                        'adeudos.fecha_pago',
                        'adeudos.caja_id',
                        'adeudo_concepto.bnd_mensualidad as mensualidad',
                        'adeudos.pagado_bnd',
                        't.name as turno',
                        'pag.monto as monto_pago',
                        'esp.name as especialidad'
                    )
                    ->whereNull('caj.deleted_at')
                    ->whereNull('ccli.deleted_at')
                    ->where('adeudos.pagado_bnd', 1)
                    ->union($cajas_sin_adeudos);
            } elseif ($datos['detalle_f'] == 3) {
                $registros_totales_aux->leftJoin('caja_lns as cln', 'cln.adeudo_id', '=', 'adeudos.id')
                    ->leftJoin('cajas as caj', 'caj.id', '=', 'adeudos.caja_id')
                    ->join('plantels as p', 'p.id', '=', 'c.plantel_id')
                    ->join('caja_conceptos as cc', 'cc.id', '=', 'adeudos.caja_concepto_id')
                    ->select(
                        'adeudos.id as adeudo',
                        'p.razon',
                        'c.id',
                        'c.nombre',
                        'c.nombre2',
                        'c.ape_paterno',
                        'c.ape_materno',
                        'c.matricula',
                        'adeudos.pagado_bnd',
                        'adeudos.monto as adeudo_planeado',
                        'cc.name as concepto',
                        'cc.id as concepto_id',
                        'cln.total as pago_calculado_adeudo',
                        'caj.id as caja',
                        'caj.consecutivo',
                        'cln.deleted_at as borrado_cln',
                        'caj.deleted_at as borrado_c',
                        'caj.usu_alta_id',
                        'c.st_cliente_id',
                        'stc.name as st_cliente',
                        's.st_seguimiento_id',
                        'sts.name as st_seguimiento',
                        'adeudos.fecha_pago',
                        'adeudos.caja_id',
                        'adeudo_concepto.bnd_mensualidad as mensualidad',
                        't.name as turno',
                        'esp.name as especialidad'
                    )
                    ->whereDate('adeudos.fecha_pago', '>=', $datos['fecha_f'])
                    ->whereDate('adeudos.fecha_pago', '<=', $datos['fecha_t'])
                    ->where('adeudos.pagado_bnd', 0)
                    ->whereNull('ccli.deleted_at');
                //->where('adeudos.caja_id', 0);
            } else {
                $registros_totales_aux->leftJoin('caja_lns as cln', 'cln.adeudo_id', '=', 'adeudos.id')
                    ->leftJoin('cajas as caj', 'caj.id', '=', 'adeudos.caja_id')
                    ->join('plantels as p', 'p.id', '=', 'c.plantel_id')
                    ->join('caja_conceptos as cc', 'cc.id', '=', 'adeudos.caja_concepto_id');
            }
            $registros_totales = $registros_totales_aux->where('p.id', $plantel)
                //->whereIn('stc.id', array(3, 4, 20, 22, 23, 24, 25))
                ->whereIn('adeudos.caja_concepto_id', $datos['concepto_f'])
                ->whereNull('adeudos.deleted_at')
                ->whereNull('s.deleted_at')
                //->orderBy('p.id')
                //->orderBy('adeudos.caja_concepto_id')
                //->orderBy('esp.name','asc')
                ->get();
            //dd($registros_totales->toArray());
            //FLC $registros_totales = DB::select('CALL maestroR(?,?,?)', array($plantel, $datos['fecha_f'], $datos['fecha_t']));
            //dd($registros_totales[0]->razon);
            //return view('adeudos.reportes.maestroR', compact('registros_totales'));
            //dd($registros_totales->toArray());

            //dd($conceptos);

            //$calculo = array();
            $calculo = [
                'plantel' => "",
                'concepto' => "",
                'clientes_activos' => 0,
                'clientes_pagados' => 0,
                'total_monto_pagado' => 0,
                'suma_deudores' => 0,
                'monto_deuda' => 0,
                'porcentaje_pagado' => 0,
                'deudores' => 0,
                'bajas_pagadas' => 0,
                'porcentaje_deudores' => 0,
            ];

            //recorrido linea de totales
            foreach ($registros_totales as $registro) {
                //array_push($lineas_detalle, (array) $registro);
                $fecha_aux = Carbon::createFromFormat('Y-m-d', $registro->fecha_pago)->addDay(9);
                $hoy = Carbon::createFromFormat('Y-m-d', date('Y-m-d'));
                //dd($hoy);
                //dd($fecha_aux->lessThan($hoy));

                if ($registro->consecutivo == 1154) {
                    //dd($registro->toArray());
                }

                $calculo['plantel'] = $registro->razon;

                if (
                    is_null($registro->borrado_c) and is_null($registro->borrado_cln) and
                    $registro->st_cliente_id <> 3
                    /*($registro->st_cliente_id == 2 or
                        $registro->st_cliente_id == 4 or
                        $registro->st_cliente_id == 20 or
                        $registro->st_cliente_id == 22 or
                        $registro->st_cliente_id == 24 or
                        $registro->st_cliente_id == 25)*/
                ) {
                    //Armado de detalle
                    if ($registro->caja_id == 0 and $fecha_aux->lessThan($hoy) and $registro->mensualidad == 1) {
                        $registro->adeudo_planeado = $registro->adeudo_planeado + ($registro->adeudo_planeado * .10);
                    }
                    array_push($lineas_detalle, $registro->toArray());
                    //dd($lineas_detalle);


                    //Fin Armado de detalle
                    $calculo['clientes_activos']++;
                    $calculo['concepto'] = "Total";
                    if ($registro->pagado_bnd == 1) {
                        $calculo['clientes_pagados'] = $calculo['clientes_pagados'] + $registro->pagado_bnd;
                        $calculo['total_monto_pagado'] = $calculo['total_monto_pagado'] + $registro->monto_pago;
                        /*$query_pagos = Pago::where('caja_id', $registro->caja)->where('caja_id', '>', 0)->whereNull('pagos.deleted_at')->get();
                    foreach ($query_pagos as $pago) {
                    if ($pago->forma_pago_id == 1 and $pago->monto >= $registro->monto_pago) {
                    $calculo['pagos_efectivo'] = $calculo['pagos_efectivo'] + $registro->monto_pago;
                    } elseif ($pago->forma_pago_id <> 1 and $pago->monto >= $registro->monto_pago) {
                    $calculo['pagos_banco'] = $calculo['pagos_banco'] + $registro->monto_pago;
                    }
                    }*/
                    } elseif ($registro->pagado_bnd == 0) {
                        $calculo['suma_deudores'] = $calculo['suma_deudores'] + 1;
                        $calculo['monto_deuda'] = $calculo['monto_deuda'] + $registro->adeudo_planeado;
                    }
                    $calculo['porcentaje_pagado'] = ($calculo['clientes_pagados'] * 100) / $calculo['clientes_activos'];
                    $calculo['deudores'] = $calculo['clientes_activos'] - $calculo['clientes_pagados'];
                    $calculo['porcentaje_deudores'] = ($calculo['deudores'] * 100) / $calculo['clientes_activos'];
                } elseif (is_null($registro->borrado_c) and is_null($registro->borrado_cln) and $registro->st_cliente_id == 3) {
                    $baja = HistoriaCliente::where('cliente_id', $registro->id)
                        ->where('evento_cliente_id', 2)
                        ->where('fecha', '>=', $datos['fecha_f'])
                        ->where('fecha', '<=', $datos['fecha_t'])
                        ->first();
                    //FLC$baja = DB::select('CALL maestroRHistoriaCliente(?,?,?)', array($registro->id, $datos['fecha_f'], $datos['fecha_t']));
                    //dd($baja);
                    if (is_array($baja) and $registro->caja > 0) {
                        $calculo['bajas_pagadas'] = $calculo['bajas_pagadas'] + 1;
                    }
                }
            }
            array_push($lineas_procesadas, $calculo);

            $conceptos = array();
            foreach ($registros_totales as $registro) {
                if (!array_has($conceptos, $registro->concepto_id)) {
                    //array_push($conceptos, array($registro->concepto_id=>$registro->concepto));
                    $conceptos[$registro->concepto_id] = $registro->concepto;
                }
            }

            //recorrido linea de totales por concepto
            foreach ($conceptos as $id => $concepto) {
                //dd($id);
                //$calculo = array();
                $calculo = [
                    'plantel' => "",
                    'concepto' => $concepto,
                    'clientes_activos' => 0,
                    'clientes_pagados' => 0,
                    'total_monto_pagado' => 0,
                    'suma_deudores' => 0,
                    'monto_deuda' => 0,
                    'porcentaje_pagado' => 0,
                    'deudores' => 0,
                    'bajas_pagadas' => 0,
                    'porcentaje_deudores' => 0,
                ];
                foreach ($registros_totales as $registro) {
                    // dd($conceptos);
                    if ($registro->concepto_id == $id) {
                        $calculo['plantel'] = $registro->razon;
                        if (
                            is_null($registro->borrado_c) and is_null($registro->borrado_cln) and
                            $registro->st_cliente_id <> 3
                            /*($registro->st_cliente_id == 2 or 
                        $registro->st_cliente_id == 4 or 
                        $registro->st_cliente_id == 20 or 
                        $registro->st_cliente_id == 22 or
                        $registro->st_cliente_id == 24 or
                        $registro->st_cliente_id == 25)*/
                        ) {
                            $calculo['concepto'] = $concepto;
                            $calculo['clientes_activos']++;
                            if ($registro->pagado_bnd == 1) {
                                $calculo['clientes_pagados'] = $calculo['clientes_pagados'] + $registro->pagado_bnd;
                                $calculo['total_monto_pagado'] = $calculo['total_monto_pagado'] + $registro->monto_pago;
                                /*$query_pagos = Pago::where('caja_id', $registro->caja)->where('caja_id', '>', 0)->whereNull('pagos.deleted_at')->get();
                            foreach ($query_pagos as $pago) {
                            if ($pago->forma_pago_id == 1 and $pago->monto >= $registro->monto_pago) {
                            $calculo['pagos_efectivo'] = $calculo['pagos_efectivo'] + $registro->monto_pago;
                            } elseif ($pago->forma_pago_id <> 1 and $pago->monto >= $registro->monto_pago) {
                            $calculo['pagos_banco'] = $calculo['pagos_banco'] + $registro->monto_pago;
                            }
                            }*/
                            } elseif ($registro->pagado_bnd == 0) {
                                $calculo['suma_deudores'] = $calculo['suma_deudores'] + 1;
                                $calculo['monto_deuda'] = $calculo['monto_deuda'] + $registro->adeudo_planeado;
                            }
                            $calculo['porcentaje_pagado'] = ($calculo['clientes_pagados'] * 100) / $calculo['clientes_activos'];
                            $calculo['deudores'] = $calculo['clientes_activos'] - $calculo['clientes_pagados'];
                            $calculo['porcentaje_deudores'] = ($calculo['deudores'] * 100) / $calculo['clientes_activos'];
                        } elseif (is_null($registro->borrado_c) and is_null($registro->borrado_cln) and $registro->st_cliente_id == 3) {
                            $baja = HistoriaCliente::where('cliente_id', $registro->id)
                                ->where('evento_cliente_id', 2)
                                ->where('fecha', '>=', $datos['fecha_f'])
                                ->where('fecha', '<=', $datos['fecha_t'])
                                ->first();

                            //FLC$baja = DB::select('CALL maestroRHistoriaCliente(?,?,?)', array($registro->id, $datos['fecha_f'], $datos['fecha_t']));
                            if (is_array($baja) and $registro->caja > 0) {
                                $calculo['bajas_pagadas'] = $calculo['bajas_pagadas'] + 1;
                            }
                        }
                    }
                }
                array_push($lineas_procesadas, $calculo);
            }
        }
        //dd($lineas_detalle);
        /*
        $cajas=array();
        $i=0;
        foreach($registros_totales as $registro){
        if($registro->caja>0){
        $cajas[$i]=$registro->caja;
        $i++;
        }
        }

        $pagos=Pago::whereIn('caja_id',$cajas)->whereNull('deleted_at')->get();

        $pagos_resultados=array();
        foreach($pagos as $pago){
        if($pago->forma_pago_id==1){
        $pagos_resultados['Efectivo']= $pagos_resultados['Efectivo']+$pago->monto;
        }else{
        $pagos_resultados['Banco'] = $pagos_resultados['Banco'] + $pago->monto;
        }
        }
        //dd($pagos_resultados);

        $fecha_f=Carbon::createFromFormat('Y-m-d', $datos['fecha_f']);
        $fecha_t = Carbon::createFromFormat('Y-m-d', $datos['fecha_t']);
        $adeudos_invalidos=CajaLn::join('adeudos as a','a.id','=','caja_lns.adeudo_id')
        ->whereRaw('month(a.fecha_pago) <> '.$fecha_f->month)
        ->whereRaw('month(a.fecha_pago) <>'.$fecha_t->month)
        ->whereIn('caja_lns.caja_id',$cajas)
        //->get();
        ->sum('caja_lns.total');
        dd($adeudos_invalidos);
        //dd($lineas_procesadas);
         */
        //dd($lineas_detalle);

        return view('adeudos.reportes.maestroR', compact('lineas_procesadas', 'lineas_detalle', 'datos'));
    }

    public function maestroIndicador(Request $request)
    {
        $datos = $request->all();


        $lineas_procesadas = array();

        $mesActual = Carbon::createFromFormat('Y-m-d', Date('Y-m-d'))->month;
        $yearActual = Carbon::createFromFormat('Y-m-d', Date('Y-m-d'))->year;
        //$conceptos = CajaConcepto::whereNull('deleted_at')->pluck('id');

        $registros = Adeudo::select('pagado_bnd', DB::raw('count(pagado_bnd) as totales'))
            ->join('clientes as c', 'c.id', '=', 'adeudos.cliente_id')
            ->join('caja_conceptos as cc', 'cc.id', '=', 'adeudos.caja_concepto_id')
            ->whereYear('fecha_pago', $yearActual)
            ->whereMonth('fecha_pago', $mesActual)
            ->where('cc.bnd_mensualidad', 1)
            ->where('c.plantel_id', $datos['plantel'])
            ->groupBy('adeudos.pagado_bnd')
            ->get();
        //dd($registros->toArray());
        $total = 0;
        $pagados = 0;
        $adeudos = 0;
        foreach ($registros as $r) {
            $total = $total + $r->totales;
            if ($r->pagado_bnd == 0) {
                $adeudos = $r->totales;
            } else {
                $pagados = $r->totales;
            }
        }
        if (!is_null($total) and $total > 0) {
            return json_encode(round(($pagados * 100) / $total, 2));
        } else {
            return json_encode(0);
        }



        /*
        $lineas_detalle = array();
    
        $registros_totales_aux = Adeudo::join('clientes as c', 'c.id', '=', 'adeudos.cliente_id')
            ->join('st_clientes as stc', 'stc.id', '=', 'c.st_cliente_id')
            ->join('seguimientos as s', 's.cliente_id', '=', 'c.id')
            ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
            ->join('caja_conceptos as adeudo_concepto', 'adeudo_concepto.id', '=', 'adeudos.caja_concepto_id')
            ->join('combinacion_clientes as ccli', 'ccli.id', '=', 'adeudos.combinacion_cliente_id')
            ->join('turnos as t', 't.id', '=', 'ccli.turno_id');

        $cajas_sin_adeudos = Caja::select(
            'p.razon',
            'c.id',
            'c.nombre',
            'c.nombre2',
            'c.ape_paterno',
            'c.ape_materno',
            'c.matricula',
            'cc.name as concepto',
            'cc.id as concepto_id',
            'cln.total as pago_calculado_adeudo',
            'cajas.id as caja',
            'cajas.consecutivo',
            'cln.deleted_at as borrado_cln',
            'cajas.deleted_at as borrado_c',
            'cajas.usu_alta_id',
            'c.st_cliente_id',
            'stc.name as st_cliente',
            's.st_seguimiento_id',
            'sts.name as st_seguimiento',
            DB::raw('date(0000-00-00) as fecha_pago'),
            'cajas.id',
            'cc.name as mensualidad',
            DB::raw('1 as pagado_bnd'),
            't.name as turno',
            'pag.monto as monto_pago'
        )
            ->join('clientes as c', 'c.id', '=', 'cajas.cliente_id')
            ->join('st_clientes as stc', 'stc.id', '=', 'c.st_cliente_id')
            ->join('seguimientos as s', 's.cliente_id', '=', 'c.id')
            ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
            ->join('plantels as p', 'p.id', '=', 'cajas.plantel_id')
            ->join('caja_lns as cln', 'cln.caja_id', '=', 'cajas.id')
            ->join('caja_conceptos as cc', 'cc.id', 'cln.caja_concepto_id')
            ->join('pagos as pag', 'pag.caja_id', '=', 'cajas.id')
            ->join('combinacion_clientes as ccli', 'ccli.cliente_id', '=', 'c.id')
            ->join('turnos as t', 't.id', '=', 'ccli.turno_id')
            ->where('cajas.plantel_id', $datos['plantel'])
            ->where('cajas.st_caja_id', 1)
            ->where('cln.adeudo_id', 0)
            ->whereNull('cln.deleted_at')
            ->whereNull('pag.deleted_at')
            ->whereIn('cc.id', $conceptos)
            ->whereNull('p.deleted_at')
            ->whereNull('cajas.deleted_at')
            ->whereNull('ccli.deleted_at');
        
        $registros_totales_aux->join('caja_lns as cln', 'cln.adeudo_id', '=', 'adeudos.id')
            ->join('cajas as caj', 'caj.id', '=', 'adeudos.caja_id')
            ->join('pagos as pag', 'pag.caja_id', '=', 'caj.id')
            ->join('plantels as p', 'p.id', '=', 'caj.plantel_id')
            ->whereMonth('pag.fecha',  $mesActual)
            ->whereYear('pag.fecha',  $yearActual)
            ->join('caja_conceptos as cc', 'cc.id', '=', 'adeudos.caja_concepto_id')
            ->where('caj.st_caja_id', 1)
            ->whereNull('cln.deleted_at')
            ->whereNull('pag.deleted_at')
            ->select(
                'p.razon',
                'c.id',
                'c.nombre',
                'c.nombre2',
                'c.ape_paterno',
                'c.ape_materno',
                'c.matricula',
                'cc.name as concepto',
                'cc.id as concepto_id',
                'cln.total as pago_calculado_adeudo',
                'caj.id as caja',
                'caj.consecutivo',
                'cln.deleted_at as borrado_cln',
                'caj.deleted_at as borrado_c',
                'caj.usu_alta_id',
                'c.st_cliente_id',
                'stc.name as st_cliente',
                's.st_seguimiento_id',
                'sts.name as st_seguimiento',
                'adeudos.fecha_pago',
                'adeudos.caja_id',
                'adeudo_concepto.bnd_mensualidad as mensualidad',
                'adeudos.pagado_bnd',
                't.name as turno',
                'pag.monto as monto_pago'
            )
            ->whereNull('caj.deleted_at')
            ->union($cajas_sin_adeudos);

        $registros_totales = $registros_totales_aux->where('p.id', $datos['plantel'])
            ->whereIn('adeudos.caja_concepto_id', $conceptos)
            ->whereNull('adeudos.deleted_at')
            ->whereNull('s.deleted_at')
            ->get();
        //dd($registros_totales);

        $calculo = [
            'plantel' => "", 'concepto' => "", 'clientes_activos' => 0, 'clientes_pagados' => 0, 'total_monto_pagado' => 0, 'suma_deudores' => 0,
            'monto_deuda' => 0, 'porcentaje_pagado' => 0, 'deudores' => 0, 'bajas_pagadas' => 0, 'porcentaje_deudores' => 0,
        ];

        foreach ($registros_totales as $registro) {
            array_push($lineas_detalle, $registro->toArray());
            $calculo['plantel'] = $registro->razon;

            if (is_null($registro->borrado_c) and is_null($registro->borrado_cln) and ($registro->st_cliente_id == 4 or $registro->st_cliente_id == 20)) {
                $calculo['clientes_activos']++;
                $calculo['concepto'] = "Total";
                if ($registro->pagado_bnd == 1) {
                    $calculo['clientes_pagados'] = $calculo['clientes_pagados'] + $registro->pagado_bnd;
                    $calculo['total_monto_pagado'] = $calculo['total_monto_pagado'] + $registro->pago_calculado_adeudo;
                } elseif ($registro->pagado_bnd == 0) {
                    $calculo['suma_deudores'] = $calculo['suma_deudores'] + 1;
                    $calculo['monto_deuda'] = $calculo['monto_deuda'] + $registro->adeudo_planeado;
                }
                $calculo['porcentaje_pagado'] = ($calculo['clientes_pagados'] * 100) / $calculo['clientes_activos'];
                $calculo['deudores'] = $calculo['clientes_activos'] - $calculo['clientes_pagados'];
                $calculo['porcentaje_deudores'] = ($calculo['deudores'] * 100) / $calculo['clientes_activos'];
            }
        }
        array_push($lineas_procesadas, $calculo);*/

        //return json_encode(round($calculo['porcentaje_pagado'], 2));
    }

    public function maestroIndicadorDetalle(Request $request)
    {
        $datos = $request->all();
        //dd($datos);
        $mesActual = Carbon::createFromFormat('Y-m-d', Date('Y-m-d'))->month;
        $yearActual = Carbon::createFromFormat('Y-m-d', Date('Y-m-d'))->year;

        $lineas_procesadas = array();
        $lineas_detalle = array();
        $conceptos = CajaConcepto::whereNull('deleted_at')->pluck('id');
        //dd($conceptos);
        //foreach ($datos['plantel_f'] as $plantel) {
        $registros_totales_aux = Adeudo::join('clientes as c', 'c.id', '=', 'adeudos.cliente_id')
            ->join('st_clientes as stc', 'stc.id', '=', 'c.st_cliente_id')
            ->join('seguimientos as s', 's.cliente_id', '=', 'c.id')
            ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
            ->join('caja_conceptos as adeudo_concepto', 'adeudo_concepto.id', '=', 'adeudos.caja_concepto_id')
            ->join('combinacion_clientes as ccli', 'ccli.id', '=', 'adeudos.combinacion_cliente_id')
            ->join('turnos as t', 't.id', '=', 'ccli.turno_id');

        $cajas_sin_adeudos = Caja::select(
            'p.razon',
            'c.id',
            'c.nombre',
            'c.nombre2',
            'c.ape_paterno',
            'c.ape_materno',
            'c.matricula',
            'cc.name as concepto',
            'cc.id as concepto_id',
            'cln.total as pago_calculado_adeudo',
            'cajas.id as caja',
            'cajas.consecutivo',
            'cln.deleted_at as borrado_cln',
            'cajas.deleted_at as borrado_c',
            'cajas.usu_alta_id',
            'c.st_cliente_id',
            'stc.name as st_cliente',
            's.st_seguimiento_id',
            'sts.name as st_seguimiento',
            DB::raw('date(0000-00-00) as fecha_pago'),
            'cajas.id',
            'cc.name as mensualidad',
            DB::raw('1 as pagado_bnd'),
            't.name as turno',
            'pag.monto as monto_pago'
        )
            ->join('clientes as c', 'c.id', '=', 'cajas.cliente_id')
            ->join('st_clientes as stc', 'stc.id', '=', 'c.st_cliente_id')
            ->join('seguimientos as s', 's.cliente_id', '=', 'c.id')
            ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
            ->join('plantels as p', 'p.id', '=', 'cajas.plantel_id')
            ->join('caja_lns as cln', 'cln.caja_id', '=', 'cajas.id')
            ->join('caja_conceptos as cc', 'cc.id', 'cln.caja_concepto_id')
            ->join('pagos as pag', 'pag.caja_id', '=', 'cajas.id')
            ->join('combinacion_clientes as ccli', 'ccli.cliente_id', '=', 'c.id')
            ->join('turnos as t', 't.id', '=', 'ccli.turno_id')
            ->whereIn('cajas.plantel_id', $datos['plantel_f'])
            ->where('cajas.st_caja_id', 1)
            ->where('cln.adeudo_id', 0)
            ->whereNull('cln.deleted_at')
            ->whereNull('pag.deleted_at')
            ->whereIn('cc.id', $conceptos)
            ->whereNull('p.deleted_at')
            ->whereNull('cajas.deleted_at')
            ->whereNull('ccli.deleted_at');

        $registros_totales_aux->join('caja_lns as cln', 'cln.adeudo_id', '=', 'adeudos.id')
            ->join('cajas as caj', 'caj.id', '=', 'adeudos.caja_id')
            ->join('pagos as pag', 'pag.caja_id', '=', 'caj.id')
            ->join('plantels as p', 'p.id', '=', 'caj.plantel_id')
            ->whereMonth('pag.fecha',  $mesActual)
            ->whereYear('pag.fecha',  $yearActual)
            ->join('caja_conceptos as cc', 'cc.id', '=', 'adeudos.caja_concepto_id')
            ->where('caj.st_caja_id', 1)
            ->whereNull('cln.deleted_at')
            ->whereNull('pag.deleted_at')
            ->select(
                'p.razon',
                'c.id',
                'c.nombre',
                'c.nombre2',
                'c.ape_paterno',
                'c.ape_materno',
                'c.matricula',
                'cc.name as concepto',
                'cc.id as concepto_id',
                'cln.total as pago_calculado_adeudo',
                'caj.id as caja',
                'caj.consecutivo',
                'cln.deleted_at as borrado_cln',
                'caj.deleted_at as borrado_c',
                'caj.usu_alta_id',
                'c.st_cliente_id',
                'stc.name as st_cliente',
                's.st_seguimiento_id',
                'sts.name as st_seguimiento',
                'adeudos.fecha_pago',
                'adeudos.caja_id',
                'adeudo_concepto.bnd_mensualidad as mensualidad',
                'adeudos.pagado_bnd',
                't.name as turno',
                'pag.monto as monto_pago'
            )
            ->whereNull('caj.deleted_at')
            ->union($cajas_sin_adeudos);

        $registros_totales = $registros_totales_aux->whereIn('p.id', $datos['plantel_f'])
            ->whereIn('adeudos.caja_concepto_id', $conceptos)
            ->whereNull('adeudos.deleted_at')
            ->whereNull('s.deleted_at')
            ->get();

        //dd($registros_totales);

        //$calculo = array();
        $calculo = [
            'plantel' => "",
            'concepto' => "",
            'clientes_activos' => 0,
            'clientes_pagados' => 0,
            'total_monto_pagado' => 0,
            'suma_deudores' => 0,
            'monto_deuda' => 0,
            'porcentaje_pagado' => 0,
            'deudores' => 0,
            'bajas_pagadas' => 0,
            'porcentaje_deudores' => 0,
        ];

        foreach ($registros_totales as $registro) {
            array_push($lineas_detalle, $registro->toArray());
            $calculo['plantel'] = $registro->razon;

            if (is_null($registro->borrado_c) and is_null($registro->borrado_cln) and ($registro->st_cliente_id == 4 or $registro->st_cliente_id == 20)) {
                $calculo['clientes_activos']++;
                $calculo['concepto'] = "Total";
                if ($registro->pagado_bnd == 1) {
                    $calculo['clientes_pagados'] = $calculo['clientes_pagados'] + $registro->pagado_bnd;
                    $calculo['total_monto_pagado'] = $calculo['total_monto_pagado'] + $registro->pago_calculado_adeudo;
                } elseif ($registro->pagado_bnd == 0) {
                    $calculo['suma_deudores'] = $calculo['suma_deudores'] + 1;
                    $calculo['monto_deuda'] = $calculo['monto_deuda'] + $registro->adeudo_planeado;
                }
                $calculo['porcentaje_pagado'] = ($calculo['clientes_pagados'] * 100) / $calculo['clientes_activos'];
                $calculo['deudores'] = $calculo['clientes_activos'] - $calculo['clientes_pagados'];
                $calculo['porcentaje_deudores'] = ($calculo['deudores'] * 100) / $calculo['clientes_activos'];
            } elseif (is_null($registro->borrado_c) and is_null($registro->borrado_cln) and $registro->st_cliente_id == 3) {
                $baja = HistoriaCliente::where('cliente_id', $registro->id)
                    ->where('evento_cliente_id', 2)
                    ->where('fecha', '>=', $datos['fecha_f'])
                    ->where('fecha', '<=', $datos['fecha_t'])
                    ->first();
                if (is_object($baja) and $registro->caja > 0) {
                    $calculo['bajas_pagadas'] = $calculo['bajas_pagadas'] + 1;
                }
            }
        }
        array_push($lineas_procesadas, $calculo);

        $conceptos = array();
        foreach ($registros_totales as $registro) {
            if (!array_has($conceptos, $registro->concepto_id)) {
                //array_push($conceptos, array($registro->concepto_id=>$registro->concepto));
                $conceptos[$registro->concepto_id] = $registro->concepto;
            }
        }

        foreach ($conceptos as $id => $concepto) {
            //dd($id);
            //$calculo = array();
            $calculo = [
                'plantel' => "",
                'concepto' => $concepto,
                'clientes_activos' => 0,
                'clientes_pagados' => 0,
                'total_monto_pagado' => 0,
                'suma_deudores' => 0,
                'monto_deuda' => 0,
                'porcentaje_pagado' => 0,
                'deudores' => 0,
                'bajas_pagadas' => 0,
                'porcentaje_deudores' => 0,
            ];
            foreach ($registros_totales as $registro) {
                // dd($conceptos);
                if ($registro->concepto_id == $id) {
                    $calculo['plantel'] = $registro->razon;
                    if (is_null($registro->borrado_c) and is_null($registro->borrado_cln) and ($registro->st_cliente_id == 4 or $registro->st_cliente_id == 20)) {
                        $calculo['concepto'] = $concepto;
                        $calculo['clientes_activos']++;
                        if ($registro->pagado_bnd == 1) {
                            $calculo['clientes_pagados'] = $calculo['clientes_pagados'] + $registro->pagado_bnd;
                            $calculo['total_monto_pagado'] = $calculo['total_monto_pagado'] + $registro->pago_calculado_adeudo;
                        } elseif ($registro->pagado_bnd == 0) {
                            $calculo['suma_deudores'] = $calculo['suma_deudores'] + 1;
                            $calculo['monto_deuda'] = $calculo['monto_deuda'] + $registro->adeudo_planeado;
                        }
                        $calculo['porcentaje_pagado'] = ($calculo['clientes_pagados'] * 100) / $calculo['clientes_activos'];
                        $calculo['deudores'] = $calculo['clientes_activos'] - $calculo['clientes_pagados'];
                        $calculo['porcentaje_deudores'] = ($calculo['deudores'] * 100) / $calculo['clientes_activos'];
                    } elseif (is_null($registro->borrado_c) and is_null($registro->borrado_cln) and $registro->st_cliente_id == 3) {
                        $baja = HistoriaCliente::where('cliente_id', $registro->id)
                            ->where('evento_cliente_id', 2)
                            ->where('fecha', '>=', $datos['fecha_f'])
                            ->where('fecha', '<=', $datos['fecha_t'])
                            ->first();
                        if (is_object($baja) and $registro->caja > 0) {
                            $calculo['bajas_pagadas'] = $calculo['bajas_pagadas'] + 1;
                        }
                    }
                }
            }
            array_push($lineas_procesadas, $calculo);
        }

        //dd($lineas_detalle);
        //dd($lineas_detalle);

        $cajas = array();
        $i = 0;
        foreach ($registros_totales as $registro) {
            if ($registro->caja > 0) {
                $cajas[$i] = $registro->caja;
                $i++;
            }
        }

        $pagos = Pago::whereIn('caja_id', $cajas)->whereNull('deleted_at')->get();

        $pagos_resultados = array();
        $pagos_resultados['Efectivo'] = 0;
        $pagos_resultados['Banco'] = 0;
        foreach ($pagos as $pago) {
            if ($pago->forma_pago_id == 1) {
                $pagos_resultados['Efectivo'] = $pagos_resultados['Efectivo'] + $pago->monto;
            } else {
                $pagos_resultados['Banco'] = $pagos_resultados['Banco'] + $pago->monto;
            }
        }
        //dd($pagos_resultados);

        return view('adeudos.reportes.maestroR', compact('lineas_procesadas', 'lineas_detalle', 'datos'));
    }

    public function adeudosXCliente(Request $request)
    {
        $resultado = array();

        $datos = $request->all();
        $cliente = Cliente::find($datos['cliente']);
        if (is_null($cliente)) {
            return response()->json([
                'message' => 'Cliente No Existe',
            ], 404);
        }

        $combinaciones = CombinacionCliente::select(
            'combinacion_clientes.id',
            'p.razon',
            'e.name as especialidad',
            'n.name as nivel',
            'g.name as grado'
        )
            ->where('cliente_id', $datos['cliente'])
            ->join('plantels as p', 'p.id', 'combinacion_clientes.plantel_id')
            ->join('especialidads as e', 'e.id', 'combinacion_clientes.especialidad_id')
            ->join('nivels as n', 'n.id', 'combinacion_clientes.nivel_id')
            ->join('grados as g', 'g.id', 'combinacion_clientes.grado_id')
            ->where('plan_pago_id', '<>', 0)
            ->where('cuenta_ticket_pago', '>', 0)
            ->get();

        foreach ($combinaciones as $combinacion) {
            $array_combinacion = array();

            $array_adeudos = array();

            $monto = 0;
            $adeudos = Adeudo::select(
                'cc.name as concepto',
                'adeudos.fecha_pago as fecha_planeada_pago',
                'adeudos.monto',
                'adeudos.pagado_bnd',
                'adeudos.caja_id',
                'adeudos.id'
            )
                ->join('caja_conceptos as cc', 'cc.id', '=', 'adeudos.caja_concepto_id')
                ->where('cliente_id', $datos['cliente'])
                ->where('combinacion_cliente_id', $combinacion->id)
                ->get();
            foreach ($adeudos as $adeudo) {
                if ($adeudo->caja_id != 0) {
                    $caja = Caja::join('caja_lns as ln', 'ln.caja_id', '=', 'cajas.id')
                        ->where('cajas.id', $adeudo->caja_id)
                        ->where('ln.adeudo_id', $adeudo->id)
                        ->whereNull('ln.deleted_at')
                        //->get();
                        ->value('consecutivo');
                    //dd($caja);

                    $vmonto = Caja::select('ln.total')->join('caja_lns as ln', 'ln.caja_id', '=', 'cajas.id')
                        ->where('cajas.id', $adeudo->caja_id)
                        ->where('ln.adeudo_id', $adeudo->id)
                        ->whereNull('ln.deleted_at')
                        ->first();
                    $monto = $vmonto->total;
                } else {
                    $caja = 0;
                    $monto = $adeudo->monto;
                }
                //dd($monto);
                array_push($array_adeudos, array(
                    'concepto' => $adeudo->concepto,
                    'fecha_pago_planeada' => $adeudo->fecha_planeada_pago,
                    'monto_planeado' => $monto,
                    'pagado_bnd' => $adeudo->pagado_bnd,
                    'caja_consecutivo' => $caja,
                ));
            }
            //dd($array_adeudos);
            array_push($array_combinacion, array(
                'combinacion_id' => $combinacion->id,
                'plantel' => $combinacion->razon,
                'especialidad' => $combinacion->especialidad,
                'nivel' => $combinacion->nivel,
                'grado' => $combinacion->grado,
                'adeudos' => $array_adeudos,
            ));
        }
        //dd(count($combinaciones));
        if (count($combinaciones) == 0) {
            array_push($resultado, array(
                'ciente_id' => $cliente->id,
                'cliente_nombre_completo' => $cliente->nombre . " " . $cliente->nombre2 . " " . $cliente->ape_paterno . " " . $cliente->ape_materno,
                'combinacion' => 'Sin combinaciones',
            ));
        } else {
            array_push($resultado, array(
                'ciente_id' => $cliente->id,
                'cliente_nombre_completo' => $cliente->nombre . " " . $cliente->nombre2 . " " . $cliente->ape_paterno . " " . $cliente->ape_materno,
                'combinacion' => $array_combinacion,
            ));
        }

        //dd($resultado);

        return response()->json(['resultado' => $resultado]);
    }

    public function adeudosXClienteF(Request $request)
    {
        return view('adeudos.reportes.adeudosXClienteF');
    }

    public function adeudosXClienteR(Request $request)
    {
        $empleado = Empleado::where('user_id', Auth::user()->id)->first();
        $cliente = Cliente::find($request->cliente);
        $planteles = array();
        foreach ($empleado->plantels as $plantel) {
            array_push($planteles, $plantel->id);
        }

        //dd($cliente);
        $combinaciones = CombinacionCliente::where('cliente_id', '=', $cliente->id)->get();
        $cajas = Caja::select('cajas.consecutivo as caja', 'cajas.fecha', 'ln.caja_concepto_id as concepto_id', 'cc.name as concepto', 'ln.total', 'st.name as estatus')
            ->join('caja_lns as ln', 'ln.caja_id', '=', 'cajas.id')
            ->join('caja_conceptos as cc', 'cc.id', '=', 'ln.caja_concepto_id')
            ->join('st_cajas as st', 'st.id', '=', 'cajas.st_caja_id')
            ->where('cliente_id', $cliente->id)
            ->whereNull('cajas.deleted_at')
            ->whereNull('ln.deleted_at')
            ->get();

        $permiso_caja_buscarCliente = Auth::user()->can('permiso_caja_buscarCliente');
        if (is_object($cliente) and count($combinaciones) > 0 and array_search($cliente->plantel_id, $planteles) <> false) { //$cliente->plantel_id == $empleado->plantel_id) {

            return view('adeudos.reportes.adeudosXClienteR', compact('cliente', 'combinaciones', 'cajas'))
                ->with('list', Caja::getListFromAllRelationApps())
                ->with('list1', CajaLn::getListFromAllRelationApps());

            /*$pdf = PDF::loadView('adeudos.reportes.adeudosXClienteR',
        array('cliente' => $cliente, 'combinaciones' => $combinaciones, 'cajas' => $cajas))
        ->setPaper('Letter', 'portrait');
         */
        } elseif (is_object($cliente) and count($combinaciones) > 0 and $permiso_caja_buscarCliente and array_search($cliente->plantel_id, $planteles) == false) {

            /*return view('adeudos.reportes.adeudosXClienteR', compact('cliente', 'combinaciones', 'cajas'))
            ->with('list', Caja::getListFromAllRelationApps())
            ->with('list1', CajaLn::getListFromAllRelationApps());
             */
            $pdf = PDF::loadView(
                'adeudos.reportes.adeudosXClienteR',
                array('cliente' => $cliente, 'combinaciones' => $combinaciones, 'cajas' => $cajas)
            )
                ->setPaper('Letter', 'portrait');
            return $pdf->download('EstatusPlanPagos.pdf');
        }

        Session::flash('msj', 'Cliente buscado pertenece a otro plantel');
        return view('adeudos.reportes.adeudosXClienteR', compact('cliente'));
        /*$pdf = PDF::loadView('adeudos.reportes.adeudosXClienteR', array('cliente' => $cliente))
    ->setPaper('Letter', 'portrait');
    return $pdf->download('EstatusPlanPagos.pdf');
     */
    }

    public function adeudosXplantel()
    {
        $plantels = Plantel::pluck('razon', 'id');
        return view('adeudos.adeudosXPlantel', compact('plantels'));
    }

    public function maestroPagos()
    {
        if (Auth::user()->can('adeudos.maestroXPlantel')) {
            $empleado = Empleado::where('user_id', Auth::user()->id)->first();
            $planteles = array();
            foreach ($empleado->plantels as $p) {
                //dd($p->id);
                array_push($planteles, $p->id);
            }

            $planteles = Plantel::whereIn('id', $planteles)->pluck('razon', 'id');
        } else {
            $planteles = Plantel::pluck('razon', 'id');
        }

        $conceptos = CajaConcepto::pluck('name', 'id');

        //dd($stCajas);
        return view('adeudos.reportes.maestroPagos', compact('planteles', 'conceptos'));
    }

    public function maestroPagosR(Request $request)
    {
        $datos = $request->all();
        //dd($datos);
        $hoy = Carbon::createFromFormat('Y-m-d', Date('Y-m-d'));
        $lineas_procesadas = array();
        $lineas_detalle = array();
        foreach ($datos['plantel_f'] as $plantel) {
            $cajas_sin_adeudos = Caja::select(
                'p.id as plantel_id',
                'p.razon',
                'c.id as cliente_id',
                'c.nombre',
                'c.nombre2',
                'c.ape_paterno',
                'c.ape_materno',
                DB::raw('"vacio" as especialidad'),
                'g.seccion',
                'c.matricula',
                'cc.name as concepto',
                'cc.id as concepto_id',
                'cln.total as pago_calculado_adeudo',
                'cajas.id as caja',
                'cajas.consecutivo',
                'cln.deleted_at as borrado_cln',
                'cajas.deleted_at as borrado_c',
                'cajas.usu_alta_id',
                'c.st_cliente_id',
                'stc.name as st_cliente',
                's.st_seguimiento_id',
                'sts.name as st_seguimiento',
                DB::raw('date(0000-00-00) as fecha_pago'),
                'cajas.id',
                'cc.name as mensualidad',
                DB::raw('1 as pagado_bnd'),
                't.name as turno',
                'pag.monto as monto_pago'
            )
                ->join('clientes as c', 'c.id', '=', 'cajas.cliente_id')
                ->join('st_clientes as stc', 'stc.id', '=', 'c.st_cliente_id')
                ->join('seguimientos as s', 's.cliente_id', '=', 'c.id')
                ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
                ->join('plantels as p', 'p.id', '=', 'cajas.plantel_id')
                ->join('caja_lns as cln', 'cln.caja_id', '=', 'cajas.id')
                ->join('caja_conceptos as cc', 'cc.id', 'cln.caja_concepto_id')
                ->join('pagos as pag', 'pag.caja_id', '=', 'cajas.id')
                ->join('combinacion_clientes as ccli', 'ccli.cliente_id', '=', 'c.id')
                ->join('especialidads as esp', 'esp.id', 'ccli.especialidad_id')
                ->join('grados as g', 'g.id', '=', 'ccli.grado_id')
                ->join('turnos as t', 't.id', '=', 'ccli.turno_id')
                ->where('cajas.plantel_id', $plantel)
                ->where('cajas.st_caja_id', 1)
                ->where('cln.adeudo_id', 0)
                ->whereNull('cln.deleted_at')
                ->whereNull('pag.deleted_at')
                ->whereIn('cc.id', $datos['concepto_f'])
                ->whereNull('p.deleted_at')
                ->whereNull('cajas.deleted_at')
                ->whereNull('ccli.deleted_at')
                ->orderBy('c.id');

            $registros_totales_aux = Adeudo::join('clientes as c', 'c.id', '=', 'adeudos.cliente_id')
                ->join('st_clientes as stc', 'stc.id', '=', 'c.st_cliente_id')
                ->join('seguimientos as s', 's.cliente_id', '=', 'c.id')
                ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
                ->join('caja_conceptos as adeudo_concepto', 'adeudo_concepto.id', '=', 'adeudos.caja_concepto_id')
                ->join('combinacion_clientes as ccli', 'ccli.id', '=', 'adeudos.combinacion_cliente_id')
                ->join('especialidads as esp', 'esp.id', 'ccli.especialidad_id')
                ->join('grados as g', 'g.id', '=', 'ccli.grado_id')
                ->join('turnos as t', 't.id', '=', 'ccli.turno_id')
                ->join('caja_lns as cln', 'cln.adeudo_id', '=', 'adeudos.id')
                ->join('cajas as caj', 'caj.id', '=', 'adeudos.caja_id')
                ->join('pagos as pag', 'pag.caja_id', '=', 'caj.id')
                ->join('plantels as p', 'p.id', '=', 'caj.plantel_id')
                ->whereDate('pag.fecha', '>=', $datos['fecha_f'])
                ->whereDate('pag.fecha', '<=', $datos['fecha_t'])
                ->join('caja_conceptos as cc', 'cc.id', '=', 'adeudos.caja_concepto_id')
                ->where('caj.st_caja_id', 1)
                ->whereNull('cln.deleted_at')
                ->whereNull('pag.deleted_at')
                ->select(
                    'p.id as plantel_id',
                    'p.razon',
                    'c.id as cliente_id',
                    'c.nombre',
                    'c.nombre2',
                    'c.ape_paterno',
                    'c.ape_materno',
                    'esp.name as especialidad',
                    'g.seccion',
                    'c.matricula',
                    'cc.name as concepto',
                    'cc.id as concepto_id',
                    'cln.total as pago_calculado_adeudo',
                    'caj.id as caja',
                    'caj.consecutivo',
                    'cln.deleted_at as borrado_cln',
                    'caj.deleted_at as borrado_c',
                    'caj.usu_alta_id',
                    'c.st_cliente_id',
                    'stc.name as st_cliente',
                    's.st_seguimiento_id',
                    'sts.name as st_seguimiento',
                    'adeudos.fecha_pago',
                    'adeudos.caja_id',
                    'adeudo_concepto.bnd_mensualidad as mensualidad',
                    'adeudos.pagado_bnd',
                    't.name as turno',
                    'pag.monto as monto_pago'
                    //DB::raw('(select sum(pp.monto) as monto_pago from pagos as pp where pp.caja_id=caj.id and pp.deleted_at is null and pp.bnd_pagado=1)')
                )
                ->whereNull('caj.deleted_at')
                ->whereNull('ccli.deleted_at')
                ->where('adeudos.pagado_bnd', 1)
                ->orderBy('c.id')
                ->union($cajas_sin_adeudos);

            $registros_totales1 = $registros_totales_aux->where('p.id', $plantel)

                ->whereIn('adeudos.caja_concepto_id', $datos['concepto_f'])
                ->whereNull('adeudos.deleted_at')
                ->whereNull('s.deleted_at')
                //->orderBy('p.id')
                //->orderBy('adeudos.caja_concepto_id')
                //->orderBy('c.id')
                //->orderBy('p.id')
                ->orderBy('seccion')
                ->orderBy('concepto_id')
                ->orderBy('cliente_id')
                //->where('c.id',6072)
                ->get();
            //dd($registros_totales1->toArray());
            $registros_totales = $registros_totales1;
            $registros_totales2 = $registros_totales1;

            $calculo = [
                'plantel' => "",
                'seccion' => "",
                'concepto' => "",
                'clientes_activos' => 0,
                'clientes_pagados' => 0,
                'total_monto_pagado' => 0,
                'suma_deudores' => 0,
                'monto_deuda' => 0,
                'porcentaje_pagado' => 0,
                'deudores' => 0,
                'bajas_pagadas' => 0,
                'porcentaje_deudores' => 0,
            ];

            foreach ($registros_totales as $registro) {

                if (
                    is_null($registro->borrado_c) and is_null($registro->borrado_cln) and
                    $registro->st_cliente_id <> 3
                ) {
                    array_push($lineas_detalle, $registro->toArray());
                }
            }
            //dd($lineas_detalle);

            //recorrido linea de totales
            $caja_aux1 = "";
            $caja_aux2 = "";
            foreach ($registros_totales as $registro) {
                //array_push($lineas_detalle, (array) $registro);
                $fecha_aux = Carbon::createFromFormat('Y-m-d', $registro->fecha_pago)->addDay(9);
                $hoy = Carbon::createFromFormat('Y-m-d', date('Y-m-d'));
                //dd($hoy);

                $calculo['plantel'] = $registro->razon;

                if (
                    is_null($registro->borrado_c) and is_null($registro->borrado_cln) and
                    $registro->st_cliente_id <> 3

                ) {

                    //Fin Armado de detalle
                    if ($caja_aux1 <> $registro->caja) {
                        $calculo['clientes_activos']++;
                    }
                    $caja_aux1 = $registro->caja;

                    //$calculo['clientes_activos']++;
                    $calculo['concepto'] = "Total";
                    if ($registro->pagado_bnd == 1) {
                        if ($caja_aux2 <> $registro->caja) {
                            $calculo['clientes_pagados'] = $calculo['clientes_pagados'] + $registro->pagado_bnd;
                        }
                        $caja_aux2 = $registro->caja;

                        $calculo['total_monto_pagado'] = $calculo['total_monto_pagado'] + $registro->monto_pago;
                    } elseif ($registro->pagado_bnd == 0) {
                        $calculo['suma_deudores'] = $calculo['suma_deudores'] + 1;
                        $calculo['monto_deuda'] = $calculo['monto_deuda'] + $registro->adeudo_planeado;
                    }
                    $calculo['porcentaje_pagado'] = ($calculo['clientes_pagados'] * 100) / $calculo['clientes_activos'];
                    $calculo['deudores'] = $calculo['clientes_activos'] - $calculo['clientes_pagados'];
                    $calculo['porcentaje_deudores'] = ($calculo['deudores'] * 100) / $calculo['clientes_activos'];
                } elseif (is_null($registro->borrado_c) and is_null($registro->borrado_cln) and $registro->st_cliente_id == 3) {
                    $baja = HistoriaCliente::where('cliente_id', $registro->id)
                        ->where('evento_cliente_id', 2)
                        ->where('fecha', '>=', $datos['fecha_f'])
                        ->where('fecha', '<=', $datos['fecha_t'])
                        ->first();
                    //dd($baja);
                    if (is_array($baja) and $registro->caja > 0) {
                        $calculo['bajas_pagadas'] = $calculo['bajas_pagadas'] + 1;
                    }
                }
            }
            array_push($lineas_procesadas, $calculo);
            //dd($lineas_procesadas);

            $calculo = [
                'plantel' => "",
                'seccion' => "",
                'concepto' => "",
                'clientes_activos' => 0,
                'clientes_pagados' => 0,
                'total_monto_pagado' => 0,
                'suma_deudores' => 0,
                'monto_deuda' => 0,
                'porcentaje_pagado' => 0,
                'deudores' => 0,
                'bajas_pagadas' => 0,
                'porcentaje_deudores' => 0,
            ];

            $concepto_aux = "";
            $seccion_aux = "";
            $caja_aux1 = "";
            $caja_aux2 = "";
            foreach ($registros_totales as $registro) {
                if (
                    is_null($registro->borrado_c) and is_null($registro->borrado_cln) and
                    $registro->st_cliente_id <> 3

                ) {
                    if ($seccion_aux <> "" and $concepto_aux <> "" and $calculo['clientes_activos'] > 0) {

                        if ($seccion_aux <> $registro->seccion or $concepto_aux <> $registro->concepto) {
                            array_push($lineas_procesadas, $calculo);
                            //$calculo['seccion']=$registro->seccion;
                            $calculo['clientes_activos'] = 0;
                            $calculo['monto_deuda'] = 0;
                            $calculo['total_monto_pagado'] = 0;
                            $calculo['clientes_pagados'] = 0;
                        }
                    }
                    $calculo['plantel'] = $registro->razon;
                    $calculo['seccion'] = $registro->seccion;
                    $calculo['concepto'] = $registro->concepto;
                    if ($caja_aux1 <> $registro->caja) {
                        $calculo['clientes_activos']++;
                    }
                    $caja_aux1 = $registro->caja;
                    if ($registro->pagado_bnd == 1) {
                        if ($caja_aux2 <> $registro->caja) {
                            $calculo['clientes_pagados'] = $calculo['clientes_pagados'] + $registro->pagado_bnd;
                        }
                        $caja_aux2 = $registro->caja;

                        $calculo['total_monto_pagado'] = $calculo['total_monto_pagado'] + $registro->monto_pago;
                    } elseif ($registro->pagado_bnd == 0) {
                        $calculo['suma_deudores'] = $calculo['suma_deudores'] + 1;
                        $calculo['monto_deuda'] = $calculo['monto_deuda'] + $registro->adeudo_planeado;
                    }
                    if ($calculo['seccion'] == "LANI") {
                        //dd($calculo['clientes_pagados'] ."-". $calculo['clientes_activos']);
                    }

                    $calculo['porcentaje_pagado'] = ($calculo['clientes_pagados'] * 100) / $calculo['clientes_activos'];
                    $calculo['deudores'] = $calculo['clientes_activos'] - $calculo['clientes_pagados'];
                    $calculo['porcentaje_deudores'] = ($calculo['deudores'] * 100) / $calculo['clientes_activos'];
                    $concepto_aux = $registro->concepto;
                    $seccion_aux = $registro->seccion;
                } elseif (is_null($registro->borrado_c) and is_null($registro->borrado_cln) and $registro->st_cliente_id == 3) {
                    $baja = HistoriaCliente::where('cliente_id', $registro->id)
                        ->where('evento_cliente_id', 2)
                        ->where('fecha', '>=', $datos['fecha_f'])
                        ->where('fecha', '<=', $datos['fecha_t'])
                        ->first();

                    if (is_array($baja) and $registro->caja > 0) {
                        $calculo['bajas_pagadas'] = $calculo['bajas_pagadas'] + 1;
                    }
                }
            }
            array_push($lineas_procesadas, $calculo);
            //dd($lineas_detalle);

        }

        return view('adeudos.reportes.maestroPagosR', compact('lineas_procesadas', 'lineas_detalle', 'datos'));
    }

    public function maestroAdeudos()
    {
        if (Auth::user()->can('adeudos.maestroXPlantel')) {
            $empleado = Empleado::where('user_id', Auth::user()->id)->first();
            $planteles = array();
            foreach ($empleado->plantels as $p) {
                //dd($p->id);
                array_push($planteles, $p->id);
            }

            $planteles = Plantel::whereIn('id', $planteles)->pluck('razon', 'id');
        } else {
            $planteles = Plantel::pluck('razon', 'id');
        }

        $conceptos = CajaConcepto::pluck('name', 'id');

        //dd($stCajas);
        return view('adeudos.reportes.maestroAdeudos', compact('planteles', 'conceptos'));
    }


    //Para reporte de ejecutivo Adeudos
    public function getMontoPlaneadoCalculadoAdeudos($adeudo, $cliente)
    {
        $adeudos = Adeudo::where('id', '=', $adeudo)->get();

        $cliente = Cliente::find($cliente);

        $subtotal = 0;
        $recargo = 0;
        $descuento = 0;
        //dd($adeudos->toArray());

        foreach ($adeudos as $adeudo) {

            //$existe_linea = CajaLn::where('adeudo_id', '=', $adeudo->id)->first();
            //dd($existe_linea->toArray());
            //if (!is_object($existe_linea)) {
            //$adeudo->caja_id = $caja->id;
            //$adeudo->save();
            //$caja_ln['caja_id'] = $caja->id;
            $caja_ln['cliente'] = $cliente->id;
            $caja_ln['caja_concepto_id'] = $adeudo->caja_concepto_id;
            $caja_ln['subtotal'] = $adeudo->monto;
            $caja_ln['total'] = 0;
            $caja_ln['recargo'] = 0;
            $caja_ln['descuento'] = 0;

            //Realiza descuento para inscripciones
            $param = Param::where('llave', 'prefijo_matricula_instalacion')->first();
            if (($param->valor == 0 or $param->valor == "AZ") and
                isset(optional($adeudo->descuento)->id) and
                ($adeudo->caja_concepto_id == 1 or $adeudo->caja_concepto_id == 23 or $adeudo->caja_concepto_id == 25)
            ) {
                $caja_ln['descuento'] = $caja_ln['subtotal'] * $adeudo->descuento->porcentaje;
            } else {
                //********************************* */
                //Calcula descuento por beca
                //********************************* */
                $beca_a = 0;
                foreach ($cliente->autorizacionBecas as $beca) {
                    //dd(is_null($beca->deleted_at));
                    $mesAdeudo = Carbon::createFromFormat('Y-m-d', $adeudo->fecha_pago)->month;
                    $anioAdeudo = Carbon::createFromFormat('Y-m-d', $adeudo->fecha_pago)->year;
                    $mesInicio = Carbon::createFromFormat('Y-m-d', $beca->lectivo->inicio)->month;
                    $anioInicio = Carbon::createFromFormat('Y-m-d', $beca->lectivo->inicio)->year;
                    $mesFin = Carbon::createFromFormat('Y-m-d', $beca->lectivo->fin)->month;
                    $anioFin = Carbon::createFromFormat('Y-m-d', $beca->lectivo->fin)->year;

                    //dd($anioInicio."-".$anioAdeudo."-".$mesInicio."-".$mesAdeudo."-".);
                    //dd(($anioInicio == $anioAdeudo or $mesInicio <= $mesAdeudo) and ($anioFin == $anioAdeudo and $mesFin >= $mesAdeudo));
                    //dd(($anioInicio < $anioAdeudo or $mesInicio >= $mesAdeudo) and ($anioFin >= $anioAdeudo and $mesFin <= $mesAdeudo));

                    if (
                        (($beca->lectivo->inicio <= $adeudo->fecha_pago and $beca->lectivo->fin >= $adeudo->fecha_pago) or
                            (($anioInicio == $anioAdeudo or $mesInicio <= $mesAdeudo) and ($anioFin == $anioAdeudo and $mesFin >= $mesAdeudo)) or
                            (($anioInicio == $anioAdeudo or $mesInicio <= $mesAdeudo) and ($anioFin > $anioAdeudo)) or
                            (($anioInicio < $anioAdeudo) and ($anioFin == $anioAdeudo and $mesFin >= $mesAdeudo))) and
                        $beca->st_beca_id == 4 and is_null($beca->deleted_at)
                    ) {
                        $beca_a = $beca->id;
                        //dd($beca);
                    }
                }

                $beca_autorizada = AutorizacionBeca::find($beca_a);
                //dd($beca_autorizada);
                if (
                    !is_null($beca_autorizada) and
                    $beca_autorizada->monto_mensualidad > 0 and
                    $adeudo->cajaConcepto->bnd_mensualidad == 1 and
                    ($adeudo->bnd_eximir_descuento_beca == 0 or is_null($adeudo->bnd_eximir_descuento_beca))
                ) {
                    $calculo_monto_mensualidad = $caja_ln['subtotal'] * $beca->monto_mensualidad;
                    $caja_ln['descuento'] = $caja_ln['descuento'] + $calculo_monto_mensualidad;
                    $caja_ln['total'] = $caja_ln['subtotal'] - $caja_ln['descuento'];
                } else {
                    $caja_ln['total'] = $caja_ln['subtotal'] - $caja_ln['descuento'];
                }
                //dd($caja_ln);
                //********************************* */
                //Fin Calculo descuento por beca
                //********************************* */

                //********************************* */
                //calcula descuento segun promocion ligada a 
                //la linea del plan considerando la fecha de pago de la
                //inscripcion del cliente
                //********************************* */
                try {
                    $promociones = PromoPlanLn::where('plan_pago_ln_id', $adeudo->plan_pago_ln_id)->get();
                    $caja_ln['promo_plan_ln_id'] = 0;
                    //if ($beca_a == 0 and $adeudo->bnd_eximir_descuentos == 0) {
                    if ($adeudo->bnd_eximir_descuentos == 0 or is_null($adeudo->bnd_eximir_descuentos)) {
                        foreach ($promociones as $promocion) {
                            /*
                                    $inscripcion = Adeudo::where('cliente_id', $adeudo->cliente_id)
                                        //->where('plan_pago_ln_id',$adeudo->plan_pago_ln_id)
                                        ->where('caja_concepto_id', 1)
                                        ->where('combinacion_cliente_id', $adeudo->combinacion_cliente_id)
                                        ->where('pagado_bnd', 1)
                                        ->first();

                                    //dd($inscripcion);
                                    if (is_object($inscripcion)) {
                                        $inicio = Carbon::createFromFormat('Y-m-d', $promocion->fec_inicio);
                                        $fin = Carbon::createFromFormat('Y-m-d', $promocion->fec_fin);

                                        $caja_inscripcion = Caja::find($inscripcion->caja_id);
                                        //dd($caja);
                                        $hoy = Carbon::createFromFormat('Y-m-d', $caja_inscripcion->fecha);
                                        //dd($hoy);
                                        $monto_promocion = 0;
                                        //dd($hoy);
                                        if ($inicio->lessThanOrEqualTo($hoy) and $fin->greaterThanOrEqualTo($hoy) and $caja_ln['promo_plan_ln_id'] == 0) {

                                            $monto_promocion = $promocion->descuento * $caja_ln['total'];
                                            $caja_ln['descuento'] = $caja_ln['descuento'] + $monto_promocion;
                                            $caja_ln['total'] = $caja_ln['subtotal'] - $caja_ln['descuento'];

                                            $caja_ln['promo_plan_ln_id'] = $promocion->id;
                                        }
                                    } else {
                                        */
                            $inicio = Carbon::createFromFormat('Y-m-d', $promocion->fec_inicio);
                            $fin = Carbon::createFromFormat('Y-m-d', $promocion->fec_fin);
                            //$hoy = Carbon::createFromFormat('Y-m-d', $caja->fecha);
                            $hoy = Carbon::createFromFormat('Y-m-d', date('Y-m-d'));
                            $monto_promocion = 0;
                            //dd($hoy);
                            if ($inicio->lessThanOrEqualTo($hoy) and $fin->greaterThanOrEqualTo($hoy) and $caja_ln['promo_plan_ln_id'] == 0) {

                                $monto_promocion = $promocion->descuento * $caja_ln['total'];
                                $caja_ln['descuento'] = $caja_ln['descuento'] + $monto_promocion;
                                $caja_ln['total'] = $caja_ln['subtotal'] - $caja_ln['descuento'];

                                $caja_ln['promo_plan_ln_id'] = $promocion->id;
                            }
                            //}
                        }
                    } else {
                        //$caja_ln['total'] = $caja_ln['subtotal'] - $caja_ln['descuento'];
                    }
                } catch (Exception $e) {
                    dd($e);
                }
                //********************************* */
                //Fin calculo descuento por promocion
                //********************************* */    


                //********************************* */
                //Calcula regla descuento recargo
                //********************************* */
                $regla_recargo = 0;
                $regla_descuento = 0;
                //dd($caja_ln);
                //dd($adeudo->planPagoLn->reglaRecargos->toArray());
                //Log::info("Adeudo-".$adeudo->id);
                //Log::info("linea plan pago-".$adeudo->planPagoLn->id);
                //$planPagoLn=PlanPagoLn::whereNull('deleted_at')->where('id',$adeudo->plan_pago_ln_id)->first();
                //$reglas=ReglaRecargo::whereNull('deleted_at')->where('')
                //$adeudo->planPagoLn->whereNull('plan_pago_lns.deleted_at')->get();
                $reglas = optional($adeudo->planPagoLn)->reglaRecargos;
                if (is_null($reglas)) {
                    //dd($reglas);
                }
                if (!is_null($reglas)) {
                    foreach ($reglas as $regla) {
                        if (($adeudo->bnd_eximir_descuento_regla == 0 or is_null($adeudo->bnd_eximir_descuento_regla)) and $adeudo->cajaConcepto->bnd_mensualidad == 1) {
                            //dd($adeudo->planPagoLn->reglaRecargos->toArray());
                            //$fecha_caja = Carbon::createFromFormat('Y-m-d', $caja->fecha);
                            $fecha_caja = Carbon::createFromFormat('Y-m-d', date('Y-m-d'));
                            $fecha_adeudo = Carbon::createFromFormat('Y-m-d', $adeudo->fecha_pago);
                            //dd($fecha_caja->greaterThanOrEqualTo($fecha_adeudo));
                            if ($fecha_caja->greaterThanOrEqualTo($fecha_adeudo)) {

                                $dias = $fecha_caja->diffInDays($fecha_adeudo);
                                if ($fecha_caja < $fecha_adeudo) {
                                    $dias = $dias * -1;
                                }
                                //dd($dias);

                                //calcula recargo o descuento segun regla y aplica
                                if ($dias >= $regla->dia_inicio and $dias <= $regla->dia_fin) {
                                    if ($regla->tipo_regla_id == 1) {
                                        //dd($regla->porcentaje);

                                        if ($regla->porcentaje > 0) {
                                            //dd($regla->porcentaje);
                                            $regla_recargo = $caja_ln['subtotal'] * $regla->porcentaje;
                                            $caja_ln['recargo'] = $caja_ln['recargo'] + $regla_recargo;
                                            //$caja_ln['recargo'] = $adeudo->monto * $regla->porcentaje;
                                            //echo $caja_ln['recargo'];
                                        } else {
                                            if ($adeudo->bnd_eximir_descuento_regla == 0) {
                                                $regla_descuento = $caja_ln['total'] * $regla->porcentaje * -1;
                                                $caja_ln['descuento'] = $caja_ln['descuento'] + $regla_descuento;
                                                $caja_ln['total'] = $caja_ln['total'] - $caja_ln['descuento'];

                                                //$caja_ln['descuento'] = $adeudo->monto * $regla->porcentaje * -1;
                                                //echo $caja_ln['descuento'];
                                            }
                                        }
                                    } elseif ($regla->tipo_regla_id == 2) {
                                        //dd($regla->porcentaje);
                                        if ($regla->monto > 0) {
                                            $regla_recargo = $regla->monto;
                                            $caja_ln['recargo'] = $caja_ln['recargo'] + $regla_recargo;
                                            //$caja_ln['recargo'] = $regla->monto;
                                        } else {
                                            if ($adeudo->bnd_eximir_descuento_regla == 0) {
                                                $regla_descuento = $regla->monto * -1;
                                                $caja_ln['descuento'] = $caja_ln['descuento'] + $regla_descuento;
                                                $caja_ln['total'] = $caja_ln['subtotal'] - $caja_ln['descuento'];

                                                //$caja_ln['descuento'] = $regla->monto * -1;
                                            }
                                        }
                                    }
                                }
                            } else {
                                $dias = $fecha_caja->diffInDays($fecha_adeudo);
                                if ($fecha_caja < $fecha_adeudo) {
                                    $dias = $dias * -1;
                                }
                                //dd($dias);

                                //calcula recargo o descuento segun regla y aplica
                                if ($dias >= $regla->dia_inicio and $dias <= $regla->dia_fin) {
                                    if ($regla->tipo_regla_id == 1) {
                                        //dd($regla->porcentaje);

                                        if ($regla->porcentaje > 0) {
                                            //dd($regla->porcentaje);
                                            $regla_recargo = $adeudo->monto * $regla->porcentaje;
                                            $caja_ln['recargo'] = $caja_ln['recargo'] + $regla_recargo;
                                            //$caja_ln['recargo'] = $adeudo->monto * $regla->porcentaje;
                                            //echo $caja_ln['recargo'];
                                        } else {
                                            if ($adeudo->bnd_eximir_descuento_regla == 0) {
                                                $regla_descuento = $caja_ln['subtotal'] * $regla->porcentaje * -1;
                                                $caja_ln['descuento'] = $caja_ln['descuento'] + $regla_descuento;
                                                $caja_ln['total'] = $caja_ln['subtotal'] - $caja_ln['descuento'];

                                                //$caja_ln['descuento'] = $adeudo->monto * $regla->porcentaje * -1;
                                                //echo $caja_ln['descuento'];
                                            }
                                        }
                                    } elseif ($regla->tipo_regla_id == 2) {
                                        //dd($regla->porcentaje);
                                        if ($regla->monto > 0) {
                                            $regla_recargo = $regla->monto;
                                            $caja_ln['recargo'] = $caja_ln['recargo'] + $regla_recargo;
                                            //$caja_ln['recargo'] = $regla->monto;
                                        } else {
                                            if ($adeudo->bnd_eximir_descuento_regla == 0) {
                                                $regla_descuento = $regla->monto * -1;
                                                $caja_ln['descuento'] = $caja_ln['descuento'] + $regla_descuento;
                                                $caja_ln['total'] = $caja_ln['subtotal'] - $caja_ln['descuento'];

                                                //$caja_ln['descuento'] = $regla->monto * -1;
                                            }
                                        }
                                    }
                                }
                            }
                        } else {
                            //$caja_ln['total'] = $caja_ln['subtotal'] - $caja_ln['descuento'];
                        }
                    }
                } //end regla recargo descuento
                //dd($caja_ln);
                //$caja_ln['total'] = 0;
                //$monto_regla = $promocion->descuento * $caja_ln['total'];
                //$caja_ln['recargo']=$caja_ln['recargo']+$regla_recargo;
                //$caja_ln['descuento']=$caja_ln['descuento']+$regla_descuento;
                //$caja_ln['total'] = $caja_ln['subtotal'] + $caja_ln['recargo'] - $caja_ln['descuento'];

                //********************************* */
                //Fin calculo descuento por regla 
                //********************************* */


                //}

                //$caja_ln['total'] = $caja_ln['subtotal'] + $caja_ln['recargo'] - $caja_ln['descuento'];
                $caja_ln['total'] = $caja_ln['subtotal'] - $caja_ln['descuento'];

                $caja_ln['adeudo_id'] = $adeudo->id;

                $caja_ln['subtotal'] = round($caja_ln['subtotal'], 0);
                $caja_ln['total'] = round($caja_ln['total'], 0);
                $caja_ln['recargo'] = round($caja_ln['recargo'], 0);
                $caja_ln['descuento'] = round($caja_ln['descuento'], 0);

                //dd($caja_ln);
                return $caja_ln['total'];
            }
        }
    }

    //functioncalcula pra ejecutivo Pagos
    public function getMontoPlaneadoCalculadoPagos($adeudo, $cliente)
    {
        $adeudos = Adeudo::where('id', '=', $adeudo)->get();

        $cliente = Cliente::find($cliente);

        $subtotal = 0;
        $recargo = 0;
        $descuento = 0;
        //dd($adeudos->toArray());

        foreach ($adeudos as $adeudo) {

            //$existe_linea = CajaLn::where('adeudo_id', '=', $adeudo->id)->first();
            //dd($existe_linea->toArray());
            //if (!is_object($existe_linea)) {
            //$adeudo->caja_id = $caja->id;
            //$adeudo->save();
            //$caja_ln['caja_id'] = $caja->id;
            $caja_ln['cliente'] = $cliente->id;
            $caja_ln['caja_concepto_id'] = $adeudo->caja_concepto_id;
            $caja_ln['subtotal'] = $adeudo->monto;
            $caja_ln['total'] = 0;
            $caja_ln['recargo'] = 0;
            $caja_ln['descuento'] = 0;

            //Realiza descuento para inscripciones
            $param = Param::where('llave', 'prefijo_matricula_instalacion')->first();
            if (($param->valor == 0 or $param->valor == "AZ") and
                isset(optional($adeudo->descuento)->id) and
                ($adeudo->caja_concepto_id == 1 or $adeudo->caja_concepto_id == 23 or $adeudo->caja_concepto_id == 25)
            ) {
                $caja_ln['descuento'] = $caja_ln['subtotal'] * $adeudo->descuento->porcentaje;
            } else {
                //********************************* */
                //Calcula descuento por beca
                //********************************* */
                $beca_a = 0;
                foreach ($cliente->autorizacionBecas as $beca) {
                    //dd(is_null($beca->deleted_at));
                    $mesAdeudo = Carbon::createFromFormat('Y-m-d', $adeudo->fecha_pago)->month;
                    $anioAdeudo = Carbon::createFromFormat('Y-m-d', $adeudo->fecha_pago)->year;
                    if (isset($beca->lectivo) and !is_null($beca->lectivo)) {
                        $mesInicio = Carbon::createFromFormat('Y-m-d', optional($beca->lectivo)->inicio)->month;
                        $anioInicio = Carbon::createFromFormat('Y-m-d', optional($beca->lectivo)->inicio)->year;
                        $mesFin = Carbon::createFromFormat('Y-m-d', $beca->lectivo->fin)->month;
                        $anioFin = Carbon::createFromFormat('Y-m-d', $beca->lectivo->fin)->year;

                        //dd($anioInicio."-".$anioAdeudo."-".$mesInicio."-".$mesAdeudo."-".);
                        //dd(($anioInicio == $anioAdeudo or $mesInicio <= $mesAdeudo) and ($anioFin == $anioAdeudo and $mesFin >= $mesAdeudo));
                        //dd(($anioInicio < $anioAdeudo or $mesInicio >= $mesAdeudo) and ($anioFin >= $anioAdeudo and $mesFin <= $mesAdeudo));

                        if (
                            (($beca->lectivo->inicio <= $adeudo->fecha_pago and $beca->lectivo->fin >= $adeudo->fecha_pago) or
                                (($anioInicio == $anioAdeudo or $mesInicio <= $mesAdeudo) and ($anioFin == $anioAdeudo and $mesFin >= $mesAdeudo)) or
                                (($anioInicio == $anioAdeudo or $mesInicio <= $mesAdeudo) and ($anioFin > $anioAdeudo)) or
                                (($anioInicio < $anioAdeudo) and ($anioFin == $anioAdeudo and $mesFin >= $mesAdeudo))) and
                            $beca->st_beca_id == 4 and is_null($beca->deleted_at)
                        ) {
                            $beca_a = $beca->id;
                            //dd($beca);
                        }
                    } elseif ($beca->bnd_tiene_vigencia == 1 and !is_null($beca->vigencia)) {
                        $fechaAdeudo = Carbon::createFromFormat('Y-m-d', $adeudo->fecha_pago);
                        $fechaVigenciaBeca = Carbon::createFromFormat('Y-m-d', $beca->vigencia);
                        if ($fechaAdeudo->lessThanOrEqualTo($fechaVigenciaBeca)) {
                            $beca_a = $beca->id;
                        }
                    }
                }

                $beca_autorizada = AutorizacionBeca::find($beca_a);
                //dd($beca_autorizada);
                if (
                    !is_null($beca_autorizada) and
                    $beca_autorizada->monto_mensualidad > 0 and
                    $adeudo->cajaConcepto->bnd_mensualidad == 1 and
                    ($adeudo->bnd_eximir_descuento_beca == 0 or is_null($adeudo->bnd_eximir_descuento_beca))
                ) {
                    $calculo_monto_mensualidad = $caja_ln['subtotal'] * $beca->monto_mensualidad;
                    $caja_ln['descuento'] = $caja_ln['descuento'] + $calculo_monto_mensualidad;
                    $caja_ln['total'] = $caja_ln['subtotal'] - $caja_ln['descuento'];
                } else {
                    $caja_ln['total'] = $caja_ln['subtotal'] - $caja_ln['descuento'];
                }
                //dd($caja_ln);
                //********************************* */
                //Fin Calculo descuento por beca
                //********************************* */

                //********************************* */
                //calcula descuento segun promocion ligada a 
                //la linea del plan considerando la fecha de pago de la
                //inscripcion del cliente
                //********************************* */
                try {
                    $promociones = PromoPlanLn::where('plan_pago_ln_id', $adeudo->plan_pago_ln_id)->get();
                    $caja_ln['promo_plan_ln_id'] = 0;
                    //if ($beca_a == 0 and $adeudo->bnd_eximir_descuentos == 0) {
                    if ($adeudo->bnd_eximir_descuentos == 0 or is_null($adeudo->bnd_eximir_descuentos)) {
                        foreach ($promociones as $promocion) {
                            /*
                                    $inscripcion = Adeudo::where('cliente_id', $adeudo->cliente_id)
                                        //->where('plan_pago_ln_id',$adeudo->plan_pago_ln_id)
                                        ->where('caja_concepto_id', 1)
                                        ->where('combinacion_cliente_id', $adeudo->combinacion_cliente_id)
                                        ->where('pagado_bnd', 1)
                                        ->first();

                                    //dd($inscripcion);
                                    if (is_object($inscripcion)) {
                                        $inicio = Carbon::createFromFormat('Y-m-d', $promocion->fec_inicio);
                                        $fin = Carbon::createFromFormat('Y-m-d', $promocion->fec_fin);

                                        $caja_inscripcion = Caja::find($inscripcion->caja_id);
                                        //dd($caja);
                                        $hoy = Carbon::createFromFormat('Y-m-d', $caja_inscripcion->fecha);
                                        //dd($hoy);
                                        $monto_promocion = 0;
                                        //dd($hoy);
                                        if ($inicio->lessThanOrEqualTo($hoy) and $fin->greaterThanOrEqualTo($hoy) and $caja_ln['promo_plan_ln_id'] == 0) {

                                            $monto_promocion = $promocion->descuento * $caja_ln['total'];
                                            $caja_ln['descuento'] = $caja_ln['descuento'] + $monto_promocion;
                                            $caja_ln['total'] = $caja_ln['subtotal'] - $caja_ln['descuento'];

                                            $caja_ln['promo_plan_ln_id'] = $promocion->id;
                                        }
                                    } else {
                                        */
                            $inicio = Carbon::createFromFormat('Y-m-d', $promocion->fec_inicio);
                            $fin = Carbon::createFromFormat('Y-m-d', $promocion->fec_fin);
                            //$hoy = Carbon::createFromFormat('Y-m-d', $caja->fecha);
                            $hoy = Carbon::createFromFormat('Y-m-d', date('Y-m-d'));
                            $monto_promocion = 0;
                            //dd($hoy);
                            if ($inicio->lessThanOrEqualTo($hoy) and $fin->greaterThanOrEqualTo($hoy) and $caja_ln['promo_plan_ln_id'] == 0) {

                                $monto_promocion = $promocion->descuento * $caja_ln['total'];
                                $caja_ln['descuento'] = $caja_ln['descuento'] + $monto_promocion;
                                $caja_ln['total'] = $caja_ln['subtotal'] - $caja_ln['descuento'];

                                $caja_ln['promo_plan_ln_id'] = $promocion->id;
                            }
                            //}
                        }
                    } else {
                        //$caja_ln['total'] = $caja_ln['subtotal'] - $caja_ln['descuento'];
                    }
                } catch (Exception $e) {
                    dd($e);
                }
                //********************************* */
                //Fin calculo descuento por promocion
                //********************************* */    


                //********************************* */
                //Calcula regla descuento recargo
                //********************************* */
                $regla_recargo = 0;
                $regla_descuento = 0;
                //dd($caja_ln);
                //dd($adeudo->planPagoLn->reglaRecargos->toArray());
                //Log::info("Adeudo-".$adeudo->id);
                //Log::info("linea plan pago-".$adeudo->planPagoLn->id);
                //$planPagoLn=PlanPagoLn::whereNull('deleted_at')->where('id',$adeudo->plan_pago_ln_id)->first();
                //$reglas=ReglaRecargo::whereNull('deleted_at')->where('')
                //$adeudo->planPagoLn->whereNull('plan_pago_lns.deleted_at')->get();
                $reglas = optional($adeudo->planPagoLn)->reglaRecargos;
                if (is_null($reglas)) {
                    //dd($reglas);
                }
                if (!is_null($reglas)) {
                    foreach ($reglas as $regla) {
                        if (($adeudo->bnd_eximir_descuento_regla == 0 or is_null($adeudo->bnd_eximir_descuento_regla)) and $adeudo->cajaConcepto->bnd_mensualidad == 1) {
                            //dd($adeudo->planPagoLn->reglaRecargos->toArray());
                            //$fecha_caja = Carbon::createFromFormat('Y-m-d', $caja->fecha);
                            $fecha_caja = Carbon::createFromFormat('Y-m-d', date('Y-m-d'));
                            $fecha_adeudo = Carbon::createFromFormat('Y-m-d', $adeudo->fecha_pago);
                            //dd($fecha_caja->greaterThanOrEqualTo($fecha_adeudo));
                            if ($fecha_caja->greaterThanOrEqualTo($fecha_adeudo)) {

                                $dias = $fecha_caja->diffInDays($fecha_adeudo);
                                if ($fecha_caja < $fecha_adeudo) {
                                    $dias = $dias * -1;
                                }
                                //dd($dias);

                                //calcula recargo o descuento segun regla y aplica
                                if ($dias >= $regla->dia_inicio and $dias <= $regla->dia_fin) {
                                    if ($regla->tipo_regla_id == 1) {
                                        //dd($regla->porcentaje);

                                        if ($regla->porcentaje > 0) {
                                            //dd($regla->porcentaje);
                                            $regla_recargo = $caja_ln['subtotal'] * $regla->porcentaje;
                                            $caja_ln['recargo'] = $caja_ln['recargo'] + $regla_recargo;
                                            //$caja_ln['recargo'] = $adeudo->monto * $regla->porcentaje;
                                            //echo $caja_ln['recargo'];
                                        } else {
                                            if ($adeudo->bnd_eximir_descuento_regla == 0) {
                                                $regla_descuento = $caja_ln['total'] * $regla->porcentaje * -1;
                                                $caja_ln['descuento'] = $caja_ln['descuento'] + $regla_descuento;
                                                $caja_ln['total'] = $caja_ln['total'] - $caja_ln['descuento'];

                                                //$caja_ln['descuento'] = $adeudo->monto * $regla->porcentaje * -1;
                                                //echo $caja_ln['descuento'];
                                            }
                                        }
                                    } elseif ($regla->tipo_regla_id == 2) {
                                        //dd($regla->porcentaje);
                                        if ($regla->monto > 0) {
                                            $regla_recargo = $regla->monto;
                                            $caja_ln['recargo'] = $caja_ln['recargo'] + $regla_recargo;
                                            //$caja_ln['recargo'] = $regla->monto;
                                        } else {
                                            if ($adeudo->bnd_eximir_descuento_regla == 0) {
                                                $regla_descuento = $regla->monto * -1;
                                                $caja_ln['descuento'] = $caja_ln['descuento'] + $regla_descuento;
                                                $caja_ln['total'] = $caja_ln['subtotal'] - $caja_ln['descuento'];

                                                //$caja_ln['descuento'] = $regla->monto * -1;
                                            }
                                        }
                                    }
                                }
                            } else {
                                $dias = $fecha_caja->diffInDays($fecha_adeudo);
                                if ($fecha_caja < $fecha_adeudo) {
                                    $dias = $dias * -1;
                                }
                                //dd($dias);

                                //calcula recargo o descuento segun regla y aplica
                                if ($dias >= $regla->dia_inicio and $dias <= $regla->dia_fin) {
                                    if ($regla->tipo_regla_id == 1) {
                                        //dd($regla->porcentaje);

                                        if ($regla->porcentaje > 0) {
                                            //dd($regla->porcentaje);
                                            $regla_recargo = $adeudo->monto * $regla->porcentaje;
                                            $caja_ln['recargo'] = $caja_ln['recargo'] + $regla_recargo;
                                            //$caja_ln['recargo'] = $adeudo->monto * $regla->porcentaje;
                                            //echo $caja_ln['recargo'];
                                        } else {
                                            if ($adeudo->bnd_eximir_descuento_regla == 0) {
                                                $regla_descuento = $caja_ln['subtotal'] * $regla->porcentaje * -1;
                                                $caja_ln['descuento'] = $caja_ln['descuento'] + $regla_descuento;
                                                $caja_ln['total'] = $caja_ln['subtotal'] - $caja_ln['descuento'];

                                                //$caja_ln['descuento'] = $adeudo->monto * $regla->porcentaje * -1;
                                                //echo $caja_ln['descuento'];
                                            }
                                        }
                                    } elseif ($regla->tipo_regla_id == 2) {
                                        //dd($regla->porcentaje);
                                        if ($regla->monto > 0) {
                                            $regla_recargo = $regla->monto;
                                            $caja_ln['recargo'] = $caja_ln['recargo'] + $regla_recargo;
                                            //$caja_ln['recargo'] = $regla->monto;
                                        } else {
                                            if ($adeudo->bnd_eximir_descuento_regla == 0) {
                                                $regla_descuento = $regla->monto * -1;
                                                $caja_ln['descuento'] = $caja_ln['descuento'] + $regla_descuento;
                                                $caja_ln['total'] = $caja_ln['subtotal'] - $caja_ln['descuento'];

                                                //$caja_ln['descuento'] = $regla->monto * -1;
                                            }
                                        }
                                    }
                                }
                            }
                        } else {
                            //$caja_ln['total'] = $caja_ln['subtotal'] - $caja_ln['descuento'];
                        }
                    }
                } //end regla recargo descuento
                //dd($caja_ln);
                //$caja_ln['total'] = 0;
                //$monto_regla = $promocion->descuento * $caja_ln['total'];
                //$caja_ln['recargo']=$caja_ln['recargo']+$regla_recargo;
                //$caja_ln['descuento']=$caja_ln['descuento']+$regla_descuento;
                //$caja_ln['total'] = $caja_ln['subtotal'] + $caja_ln['recargo'] - $caja_ln['descuento'];

                //********************************* */
                //Fin calculo descuento por regla 
                //********************************* */


                //}

                $caja_ln['total'] = $caja_ln['subtotal'] + $caja_ln['recargo'] - $caja_ln['descuento'];


                $caja_ln['adeudo_id'] = $adeudo->id;

                $caja_ln['subtotal'] = round($caja_ln['subtotal'], 0);
                $caja_ln['total'] = round($caja_ln['total'], 0);
                $caja_ln['recargo'] = round($caja_ln['recargo'], 0);
                $caja_ln['descuento'] = round($caja_ln['descuento'], 0);

                //dd($caja_ln);
                return $caja_ln['total'];
            }
        }
    }

    public function maestroAdeudosR(Request $request)
    {
        $datos = $request->all();
        //dd($datos);
        $hoy = Carbon::createFromFormat('Y-m-d', Date('Y-m-d'));
        $lineas_procesadas = array();
        $lineas_detalle = array();
        foreach ($datos['plantel_f'] as $plantel) {

            $registros_totales_aux = Adeudo::join('clientes as c', 'c.id', '=', 'adeudos.cliente_id')
                ->join('st_clientes as stc', 'stc.id', '=', 'c.st_cliente_id')
                ->join('seguimientos as s', 's.cliente_id', '=', 'c.id')
                ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
                ->join('caja_conceptos as adeudo_concepto', 'adeudo_concepto.id', '=', 'adeudos.caja_concepto_id')
                ->join('combinacion_clientes as ccli', 'ccli.id', '=', 'adeudos.combinacion_cliente_id')
                ->join('grados as g', 'g.id', '=', 'ccli.grado_id')
                ->join('turnos as t', 't.id', '=', 'ccli.turno_id');

            $registros_totales_aux->leftJoin('caja_lns as cln', 'cln.adeudo_id', '=', 'adeudos.id')
                ->leftJoin('cajas as caj', 'caj.id', '=', 'adeudos.caja_id')
                ->join('plantels as p', 'p.id', '=', 'c.plantel_id')
                ->join('caja_conceptos as cc', 'cc.id', '=', 'adeudos.caja_concepto_id')
                ->select(
                    'p.id as plantel_id',
                    'p.razon',
                    'c.id',
                    'c.nombre',
                    'c.nombre2',
                    'c.ape_paterno',
                    'c.ape_materno',
                    'c.matricula',
                    'c.mail',
                    'c.tel_fijo',
                    'adeudos.pagado_bnd',
                    'adeudos.monto as adeudo_planeado',
                    DB::raw('0 as adeudo_planeado_calculado'),
                    'g.seccion',
                    'cc.name as concepto',
                    'cc.id as concepto_id',
                    'cln.total as pago_calculado_adeudo',
                    'caj.id as caja',
                    'caj.consecutivo',
                    'cln.deleted_at as borrado_cln',
                    'caj.deleted_at as borrado_c',
                    'caj.usu_alta_id',
                    'c.st_cliente_id',
                    'stc.name as st_cliente',
                    's.st_seguimiento_id',
                    'sts.name as st_seguimiento',
                    'adeudos.fecha_pago',
                    'adeudos.caja_id',
                    'adeudo_concepto.bnd_mensualidad as mensualidad',
                    't.name as turno',
                    'adeudos.id as adeudo'
                )
                ->whereDate('adeudos.fecha_pago', '>=', $datos['fecha_f'])
                ->whereDate('adeudos.fecha_pago', '<=', $datos['fecha_t'])
                ->where('adeudos.pagado_bnd', 0)
                ->whereNull('ccli.deleted_at');
            //->where('adeudos.caja_id', 0);

            $registros_totales = $registros_totales_aux->where('p.id', $plantel)
                //->whereIn('stc.id', array(3, 4, 20, 22, 23, 24, 25))
                ->whereIn('adeudos.caja_concepto_id', $datos['concepto_f'])
                ->whereNull('adeudos.deleted_at')
                ->whereNull('s.deleted_at')
                //->orderBy('p.id')
                //->orderBy('adeudos.caja_concepto_id')
                ->orderBy('p.id')
                ->orderBy('seccion')
                ->orderBy('concepto_id')
                ->get();
            //dd($registros_totales->toArray());


            //dd($conceptos);

            //$calculo = array();
            $calculo = [
                'plantel' => "",
                'seccion' => "",
                'concepto' => "",
                'clientes_activos' => 0,
                'clientes_pagados' => 0,
                'total_monto_pagado' => 0,
                'suma_deudores' => 0,
                'monto_deuda' => 0,
                'porcentaje_pagado' => 0,
                'deudores' => 0,
                'bajas_pagadas' => 0,
                'porcentaje_deudores' => 0,
            ];

            //recorrido linea de totales
            foreach ($registros_totales as $registro) {

                $fecha_aux = Carbon::createFromFormat('Y-m-d', $registro->fecha_pago)->addDay(9);
                $hoy = Carbon::createFromFormat('Y-m-d', date('Y-m-d'));

                $calculo['plantel'] = $registro->razon;

                if (
                    is_null($registro->borrado_c) and is_null($registro->borrado_cln) and
                    $registro->st_cliente_id <> 3

                ) {
                    //Armado de detalle
                    //Solo considera aplicacion de beca y no recargos
                    $registro->adeudo_planeado = $this->getMontoPlaneadoCalculadoPagos($registro->adeudo, $registro->id);
                    //dd($registro);
                    array_push($lineas_detalle, $registro->toArray());
                    //dd($lineas_detalle);

                    //Fin Armado de detalle
                    $calculo['clientes_activos']++;
                    $calculo['concepto'] = "Total";
                    if ($registro->pagado_bnd == 1) {
                        $calculo['clientes_pagados'] = $calculo['clientes_pagados'] + $registro->pagado_bnd;
                        $calculo['total_monto_pagado'] = $calculo['total_monto_pagado'] + $registro->monto_pago;
                    } elseif ($registro->pagado_bnd == 0) {
                        $calculo['suma_deudores'] = $calculo['suma_deudores'] + 1;
                        $calculo['monto_deuda'] = $calculo['monto_deuda'] + $registro->adeudo_planeado;
                    }
                    $calculo['porcentaje_pagado'] = ($calculo['clientes_pagados'] * 100) / $calculo['clientes_activos'];
                    $calculo['deudores'] = $calculo['clientes_activos'] - $calculo['clientes_pagados'];
                    $calculo['porcentaje_deudores'] = ($calculo['deudores'] * 100) / $calculo['clientes_activos'];
                } elseif (
                    is_null($registro->borrado_c) and
                    is_null($registro->borrado_cln) and
                    $registro->st_cliente_id == 3
                ) {

                    $baja = HistoriaCliente::where('cliente_id', $registro->id)
                        ->where('evento_cliente_id', 2)
                        ->where('fecha', '>=', $datos['fecha_f'])
                        ->where('fecha', '<=', $datos['fecha_t'])
                        ->first();

                    if (is_array($baja) and $registro->caja > 0) {
                        $calculo['bajas_pagadas'] = $calculo['bajas_pagadas'] + 1;
                    }
                }
                //array_push($lineas_detalle, $registro->toArray());
            }
            array_push($lineas_procesadas, $calculo);
            /*
            $conceptos = array();
            foreach ($registros_totales as $registro) {
                if (!in_array($registro->concepto_id, $conceptos)) {
                    $conceptos[$registro->concepto_id] = $registro->concepto;
                }
            }
            $secciones=array();
            foreach ($registros_totales as $registro) {
                if (!in_array($registro->seccion, $secciones)) {
                    $secciones[$registro->seccion] = $registro->seccion;
                }
            }*/
            $calculo = [
                'plantel' => "",
                'seccion' => "",
                'concepto' => "",
                'clientes_activos' => 0,
                'clientes_pagados' => 0,
                'total_monto_pagado' => 0,
                'suma_deudores' => 0,
                'monto_deuda' => 0,
                'porcentaje_pagado' => 0,
                'deudores' => 0,
                'bajas_pagadas' => 0,
                'porcentaje_deudores' => 0,
            ];
            $seccion_aux = "";
            $concepto_aux = "";
            foreach ($registros_totales as $registro) {

                if (
                    is_null($registro->borrado_c) and is_null($registro->borrado_cln) and
                    $registro->st_cliente_id <> 3
                ) {
                    if ($seccion_aux <> "" and $concepto_aux <> "") {

                        if ($seccion_aux <> $registro->seccion or $concepto_aux <> $registro->concepto) {
                            array_push($lineas_procesadas, $calculo);
                            //$calculo['seccion']=$registro->seccion;
                            $calculo['clientes_activos'] = 0;
                            $calculo['monto_deuda'] = 0;
                        }
                    }
                    $calculo['plantel'] = $registro->razon;
                    $calculo['seccion'] = $registro->seccion;

                    $calculo['concepto'] = $registro->concepto;
                    $calculo['clientes_activos']++;
                    if ($registro->pagado_bnd == 1) {
                        $calculo['clientes_pagados'] = $calculo['clientes_pagados'] + $registro->pagado_bnd;
                        $calculo['total_monto_pagado'] = $calculo['total_monto_pagado'] + $registro->monto_pago;
                    } elseif ($registro->pagado_bnd == 0) {
                        $calculo['suma_deudores'] = $calculo['suma_deudores'] + 1;
                        $calculo['monto_deuda'] = $calculo['monto_deuda'] + $registro->adeudo_planeado;
                    }
                    $calculo['porcentaje_pagado'] = ($calculo['clientes_pagados'] * 100) / $calculo['clientes_activos'];
                    $calculo['deudores'] = $calculo['clientes_activos'] - $calculo['clientes_pagados'];
                    $calculo['porcentaje_deudores'] = ($calculo['deudores'] * 100) / $calculo['clientes_activos'];
                    $concepto_aux = $registro->concepto;
                    $seccion_aux = $registro->seccion;
                } elseif (is_null($registro->borrado_c) and is_null($registro->borrado_cln) and $registro->st_cliente_id == 3) {
                    $baja = HistoriaCliente::where('cliente_id', $registro->id)
                        ->where('evento_cliente_id', 2)
                        ->where('fecha', '>=', $datos['fecha_f'])
                        ->where('fecha', '<=', $datos['fecha_t'])
                        ->first();
                    if (is_array($baja) and $registro->caja > 0) {
                        $calculo['bajas_pagadas'] = $calculo['bajas_pagadas'] + 1;
                    }
                }
            }
            array_push($lineas_procesadas, $calculo);


            //dd($secciones);
            //recorrido linea de totales por concepto
            /*foreach ($conceptos as $id => $concepto) {
                $calculo = [
                    'plantel' => "", 'seccion'=>"", 'concepto' => $concepto, 'clientes_activos' => 0, 'clientes_pagados' => 0, 'total_monto_pagado' => 0, 'suma_deudores' => 0,
                    'monto_deuda' => 0, 'porcentaje_pagado' => 0, 'deudores' => 0, 'bajas_pagadas' => 0, 'porcentaje_deudores' => 0,
                ];
                foreach ($registros_totales as $registro) {
                    
                    if ($registro->concepto_id == $id) {
                        $calculo['plantel'] = $registro->razon;
                        if (
                            is_null($registro->borrado_c) and is_null($registro->borrado_cln) and
                            $registro->st_cliente_id <> 3
                        ) {
                            $calculo['concepto'] = $concepto;
                            $calculo['clientes_activos']++;
                            if ($registro->pagado_bnd == 1) {
                                $calculo['clientes_pagados'] = $calculo['clientes_pagados'] + $registro->pagado_bnd;
                                $calculo['total_monto_pagado'] = $calculo['total_monto_pagado'] + $registro->monto_pago;
                            } elseif ($registro->pagado_bnd == 0) {
                                $calculo['suma_deudores'] = $calculo['suma_deudores'] + 1;
                                $calculo['monto_deuda'] = $calculo['monto_deuda'] + $registro->adeudo_planeado;
                            }
                            $calculo['porcentaje_pagado'] = ($calculo['clientes_pagados'] * 100) / $calculo['clientes_activos'];
                            $calculo['deudores'] = $calculo['clientes_activos'] - $calculo['clientes_pagados'];
                            $calculo['porcentaje_deudores'] = ($calculo['deudores'] * 100) / $calculo['clientes_activos'];
                        } elseif (is_null($registro->borrado_c) and is_null($registro->borrado_cln) and $registro->st_cliente_id == 3) {
                            $baja = HistoriaCliente::where('cliente_id', $registro->id)
                                ->where('evento_cliente_id', 2)
                                ->where('fecha', '>=', $datos['fecha_f'])
                                ->where('fecha', '<=', $datos['fecha_t'])
                                ->first();
                            if (is_array($baja) and $registro->caja > 0) {
                                $calculo['bajas_pagadas'] = $calculo['bajas_pagadas'] + 1;
                            }
                        }
                    }
                }
                array_push($lineas_procesadas, $calculo);
                
            }
            */
        }

        //dd($lineas_detalle);

        return view('adeudos.reportes.maestroAdeudosR', compact('lineas_procesadas', 'lineas_detalle', 'datos'));
    }

    public function consultaArchivosAtrazoPagos()
    {

        $ficheros  = scandir(storage_path('app/public/atrazoPagos/'));
        //dd($ficheros);        
        return view('adeudos..reportes.consultaArchivosAtrazoPagos', compact('ficheros'));
    }

    public function borrarArchivoAtrazoPago(Request $request)
    {
        $datos = $request->all();
        //dd($datos);
        //dd(storage_path('app/public/atrazoPagos/'.$datos['archivo']));
        Storage::disk('atrazoPagos')->delete($datos['archivo']);
        $ficheros = scandir(storage_path('app/public/atrazoPagos/'));
        //dd($ficheros);        
        return view('adeudos..reportes.consultaArchivosAtrazoPagos', compact('ficheros'));
    }

    public function maestroJ()
    {
        if (Auth::user()->can('adeudos.maestroXPlantel')) {
            $empleado = Empleado::where('user_id', Auth::user()->id)->first();
            $planteles = array();
            foreach ($empleado->plantels as $p) {
                //dd($p->id);
                array_push($planteles, $p->id);
            }

            $planteles = Plantel::whereIn('id', $planteles)->pluck('razon', 'id');
        } else {
            $planteles = Plantel::pluck('razon', 'id');
        }

        $conceptos = CajaConcepto::pluck('name', 'id');

        //dd($stCajas);
        return view('adeudos.reportes.maestroJ', compact('planteles', 'conceptos'));
    }

    public function maestroJR(Request $request)
    {
        $datos = $request->all();
        //dd($datos);
        $hoy = Carbon::createFromFormat('Y-m-d', Date('Y-m-d'));
        $lineas_procesadas = array();
        $lineas_detalle = array();
        foreach ($datos['plantel_f'] as $plantel) {
            $registros_totales = Adeudo::select(
                'p.razon',
                'c.id',
                'adeudos.pagado_bnd',
                'adeudos.monto as adeudo_planeado',
                'cc.name as concepto',
                'cc.id as concepto_id',
                'cln.total as pago_calculado_adeudo',
                'caj.id as caja',
                'caj.consecutivo',
                'cln.deleted_at as borrado_cln',
                'caj.deleted_at as borrado_c',
                'c.st_cliente_id',
                'stc.name as st_cliente',
                's.st_seguimiento_id',
                'sts.name as st_seguimiento'
            )
                ->join('clientes as c', 'c.id', '=', 'adeudos.cliente_id')
                ->join('st_clientes as stc', 'stc.id', '=', 'c.st_cliente_id')
                ->join('seguimientos as s', 's.cliente_id', '=', 'c.id')
                ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
                ->join('plantels as p', 'p.id', '=', 'c.plantel_id')
                ->leftJoin('caja_lns as cln', 'cln.adeudo_id', '=', 'adeudos.id')
                ->leftJoin('cajas as caj', 'caj.id', '=', 'adeudos.caja_id')
                ->join('caja_conceptos as cc', 'cc.id', '=', 'adeudos.caja_concepto_id')
                ->where('p.id', $plantel)
                ->whereIn('stc.id', array(3, 4, 20, 23, 24, 25))
                ->whereDate('adeudos.fecha_pago', '>=', $datos['fecha_f'])
                ->whereDate('adeudos.fecha_pago', '<=', $datos['fecha_t'])
                ->whereNull('adeudos.deleted_at')
                ->whereNull('s.deleted_at')
                ->orderBy('p.id')
                ->orderBy('adeudos.caja_concepto_id')
                ->orderBy('c.id')
                ->get();
            //$registros_totales = DB::select('CALL maestroR(?,?,?)', array($plantel, $datos['fecha_f'], $datos['fecha_t']));
            //dd($registros_totales[0]->razon);
            //return view('adeudos.reportes.maestroR', compact('registros_totales'));
            //dd($registros_totales->toArray());

            //dd($conceptos);

            //$calculo = array();
            $calculo = [
                'plantel' => "",
                'concepto' => "",
                'clientes_activos' => 0,
                'clientes_pagados' => 0,
                'total_monto_pagado' => 0,
                'suma_deudores' => 0,
                'monto_deuda' => 0,
                'porcentaje_pagado' => 0,
                'deudores' => 0,
                'bajas_pagadas' => 0,
                'porcentaje_deudores' => 0,
            ];
            //dd($registros_totales->toArray());
            foreach ($registros_totales as $registro) {
                array_push($lineas_detalle, $registro->toArray());
                $calculo['plantel'] = $registro->razon;

                if (is_null($registro->borrado_c) and is_null($registro->borrado_cln) and ($registro->st_cliente_id == 4 or $registro->st_cliente_id == 20)) {
                    $calculo['clientes_activos']++;
                    $calculo['concepto'] = "Total";
                    if ($registro->pagado_bnd == 1) {
                        $calculo['clientes_pagados'] = $calculo['clientes_pagados'] + $registro->pagado_bnd;
                        $calculo['total_monto_pagado'] = $calculo['total_monto_pagado'] + $registro->pago_calculado_adeudo;
                        /*$query_pagos = Pago::where('caja_id', $registro->caja)->where('caja_id', '>', 0)->whereNull('pagos.deleted_at')->get();
                    foreach ($query_pagos as $pago) {
                    if ($pago->forma_pago_id == 1 and $pago->monto >= $registro->pago_calculado_adeudo) {
                    $calculo['pagos_efectivo'] = $calculo['pagos_efectivo'] + $registro->pago_calculado_adeudo;
                    } elseif ($pago->forma_pago_id <> 1 and $pago->monto >= $registro->pago_calculado_adeudo) {
                    $calculo['pagos_banco'] = $calculo['pagos_banco'] + $registro->pago_calculado_adeudo;
                    }
                    }*/
                    } elseif ($registro->pagado_bnd == 0) {
                        $calculo['suma_deudores'] = $calculo['suma_deudores'] + 1;
                        $calculo['monto_deuda'] = $calculo['monto_deuda'] + $registro->adeudo_planeado;
                    }
                    $calculo['porcentaje_pagado'] = ($calculo['clientes_pagados'] * 100) / $calculo['clientes_activos'];
                    $calculo['deudores'] = $calculo['clientes_activos'] - $calculo['clientes_pagados'];
                    $calculo['porcentaje_deudores'] = ($calculo['deudores'] * 100) / $calculo['clientes_activos'];
                } elseif (is_null($registro->borrado_c) and is_null($registro->borrado_cln) and $registro->st_cliente_id == 3) {
                    $baja = HistoriaCliente::where('cliente_id', $registro->id)
                        ->where('evento_cliente_id', 2)
                        ->where('fecha', '>=', $datos['fecha_f'])
                        ->where('fecha', '<=', $datos['fecha_t'])
                        ->first();
                    //$baja = DB::select('CALL maestroRHistoriaCliente(?,?,?)', array($registro->id, $datos['fecha_f'], $datos['fecha_t']));
                    //dd($baja);
                    if (is_array($baja) and $registro->caja > 0) {
                        $calculo['bajas_pagadas'] = $calculo['bajas_pagadas'] + 1;
                    }
                }
            }
            array_push($lineas_procesadas, $calculo);

            $conceptos = array();
            foreach ($registros_totales as $registro) {
                if (!array_has($conceptos, $registro->concepto_id)) {
                    //array_push($conceptos, array($registro->concepto_id=>$registro->concepto));
                    $conceptos[$registro->concepto_id] = $registro->concepto;
                }
            }

            foreach ($conceptos as $id => $concepto) {
                //dd($id);
                //$calculo = array();
                $calculo = [
                    'plantel' => "",
                    'concepto' => $concepto,
                    'clientes_activos' => 0,
                    'clientes_pagados' => 0,
                    'total_monto_pagado' => 0,
                    'suma_deudores' => 0,
                    'monto_deuda' => 0,
                    'porcentaje_pagado' => 0,
                    'deudores' => 0,
                    'bajas_pagadas' => 0,
                    'porcentaje_deudores' => 0,
                ];
                foreach ($registros_totales as $registro) {
                    // dd($conceptos);
                    if ($registro->concepto_id == $id) {
                        $calculo['plantel'] = $registro->razon;
                        if (is_null($registro->borrado_c) and is_null($registro->borrado_cln) and ($registro->st_cliente_id == 4 or $registro->st_cliente_id == 20)) {
                            $calculo['concepto'] = $concepto;
                            $calculo['clientes_activos']++;
                            if ($registro->pagado_bnd == 1) {
                                $calculo['clientes_pagados'] = $calculo['clientes_pagados'] + $registro->pagado_bnd;
                                $calculo['total_monto_pagado'] = $calculo['total_monto_pagado'] + $registro->pago_calculado_adeudo;
                                /*$query_pagos = Pago::where('caja_id', $registro->caja)->where('caja_id', '>', 0)->whereNull('pagos.deleted_at')->get();
                            foreach ($query_pagos as $pago) {
                            if ($pago->forma_pago_id == 1 and $pago->monto >= $registro->pago_calculado_adeudo) {
                            $calculo['pagos_efectivo'] = $calculo['pagos_efectivo'] + $registro->pago_calculado_adeudo;
                            } elseif ($pago->forma_pago_id <> 1 and $pago->monto >= $registro->pago_calculado_adeudo) {
                            $calculo['pagos_banco'] = $calculo['pagos_banco'] + $registro->pago_calculado_adeudo;
                            }
                            }*/
                            } elseif ($registro->pagado_bnd == 0) {
                                $calculo['suma_deudores'] = $calculo['suma_deudores'] + 1;
                                $calculo['monto_deuda'] = $calculo['monto_deuda'] + $registro->adeudo_planeado;
                            }
                            $calculo['porcentaje_pagado'] = ($calculo['clientes_pagados'] * 100) / $calculo['clientes_activos'];
                            $calculo['deudores'] = $calculo['clientes_activos'] - $calculo['clientes_pagados'];
                            $calculo['porcentaje_deudores'] = ($calculo['deudores'] * 100) / $calculo['clientes_activos'];
                        } elseif (is_null($registro->borrado_c) and is_null($registro->borrado_cln) and $registro->st_cliente_id == 3) {
                            $baja = HistoriaCliente::where('cliente_id', $registro->id)
                                ->where('evento_cliente_id', 2)
                                ->where('fecha', '>=', $datos['fecha_f'])
                                ->where('fecha', '<=', $datos['fecha_t'])
                                ->first();

                            //$baja = DB::select('CALL maestroRHistoriaCliente(?,?,?)', array($registro->id, $datos['fecha_f'], $datos['fecha_t']));
                            if (is_array($baja) and $registro->caja > 0) {
                                $calculo['bajas_pagadas'] = $calculo['bajas_pagadas'] + 1;
                            }
                        }
                    }
                }
                array_push($lineas_procesadas, $calculo);
            }
        }
        //dd($lineas_detalle);
        /*
        $cajas=array();
        $i=0;
        foreach($registros_totales as $registro){
        if($registro->caja>0){
        $cajas[$i]=$registro->caja;
        $i++;
        }
        }

        $pagos=Pago::whereIn('caja_id',$cajas)->whereNull('deleted_at')->get();

        $pagos_resultados=array();
        foreach($pagos as $pago){
        if($pago->forma_pago_id==1){
        $pagos_resultados['Efectivo']= $pagos_resultados['Efectivo']+$pago->monto;
        }else{
        $pagos_resultados['Banco'] = $pagos_resultados['Banco'] + $pago->monto;
        }
        }
        //dd($pagos_resultados);

        $fecha_f=Carbon::createFromFormat('Y-m-d', $datos['fecha_f']);
        $fecha_t = Carbon::createFromFormat('Y-m-d', $datos['fecha_t']);
        $adeudos_invalidos=CajaLn::join('adeudos as a','a.id','=','caja_lns.adeudo_id')
        ->whereRaw('month(a.fecha_pago) <> '.$fecha_f->month)
        ->whereRaw('month(a.fecha_pago) <>'.$fecha_t->month)
        ->whereIn('caja_lns.caja_id',$cajas)
        //->get();
        ->sum('caja_lns.total');
        //dd($adeudos_invalidos);
        //dd($lineas_procesadas);
         */
        //dd($lineas_detalle);
        return view('adeudos.reportes.maestroJR', compact('lineas_procesadas', 'lineas_detalle', 'datos'));
    }

    public function maestroEjecutivo()
    {
        if (Auth::user()->can('adeudos.maestroXPlantel')) {
            $empleado = Empleado::where('user_id', Auth::user()->id)->first();
            $planteles = array();
            foreach ($empleado->plantels as $p) {
                //dd($p->id);
                array_push($planteles, $p->id);
            }

            $planteles = Plantel::whereIn('id', $planteles)->pluck('razon', 'id');
        } else {
            $planteles = Plantel::pluck('razon', 'id');
        }

        $conceptos = CajaConcepto::pluck('name', 'id');

        //dd($stCajas);
        return view('adeudos.reportes.maestroEjecutivo', compact('planteles', 'conceptos'));
    }

    public function maestroEjecutivoR(Request $request)
    {
        $datos = $request->all();
        //dd($datos);
        $hoy = Carbon::createFromFormat('Y-m-d', Date('Y-m-d'));
        $lineas_procesadas = array();
        $lineas_detalle = array();

        if ($datos['tipo_reporte'] == 1) {
            foreach ($datos['plantel_f'] as $plantel) {

                $registros_totales_aux = Adeudo::join('clientes as c', 'c.id', '=', 'adeudos.cliente_id')
                    ->join('st_clientes as stc', 'stc.id', '=', 'c.st_cliente_id')
                    ->join('seguimientos as s', 's.cliente_id', '=', 'c.id')
                    ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
                    ->join('caja_conceptos as adeudo_concepto', 'adeudo_concepto.id', '=', 'adeudos.caja_concepto_id')
                    ->join('combinacion_clientes as ccli', 'ccli.id', '=', 'adeudos.combinacion_cliente_id')
                    ->join('grados as g', 'g.id', '=', 'ccli.grado_id')
                    ->join('turnos as t', 't.id', '=', 'ccli.turno_id');

                $registros_totales_aux->leftJoin('caja_lns as cln', 'cln.adeudo_id', '=', 'adeudos.id')
                    ->leftJoin('cajas as caj', 'caj.id', '=', 'adeudos.caja_id')
                    ->join('plantels as p', 'p.id', '=', 'c.plantel_id')
                    ->join('caja_conceptos as cc', 'cc.id', '=', 'adeudos.caja_concepto_id')
                    ->select(
                        'p.id as plantel_id',
                        'p.razon',
                        'c.id',
                        'c.nombre',
                        'c.nombre2',
                        'c.ape_paterno',
                        'c.ape_materno',
                        'c.matricula',
                        'adeudos.pagado_bnd',
                        'adeudos.monto as adeudo_planeado',
                        DB::raw('0 as adeudo_planeado_calculado'),
                        'g.seccion',
                        'cc.name as concepto',
                        'cc.id as concepto_id',
                        'cln.total as pago_calculado_adeudo',
                        'caj.id as caja',
                        'caj.consecutivo',
                        'cln.deleted_at as borrado_cln',
                        'caj.deleted_at as borrado_c',
                        'caj.usu_alta_id',
                        'c.st_cliente_id',
                        'stc.name as st_cliente',
                        's.st_seguimiento_id',
                        'sts.name as st_seguimiento',
                        'adeudos.fecha_pago',
                        'adeudos.caja_id',
                        'adeudo_concepto.bnd_mensualidad as mensualidad',
                        't.name as turno',
                        'adeudos.id as adeudo'
                    )
                    ->whereDate('adeudos.fecha_pago', '>=', $datos['fecha_f'])
                    ->whereDate('adeudos.fecha_pago', '<=', $datos['fecha_t'])
                    ->where('adeudos.pagado_bnd', 0)
                    ->whereNull('ccli.deleted_at');
                //->where('adeudos.caja_id', 0);

                $registros_totales = $registros_totales_aux->where('p.id', $plantel)
                    ->whereIn('stc.id', array(4, 22, 25))
                    ->whereIn('sts.id', array(2))
                    ->whereIn('adeudos.caja_concepto_id', $datos['concepto_f'])
                    ->whereNull('adeudos.deleted_at')
                    ->whereNull('s.deleted_at')
                    //->orderBy('p.id')
                    //->orderBy('adeudos.caja_concepto_id')
                    ->orderBy('p.id')
                    ->orderBy('seccion')
                    ->orderBy('concepto_id')
                    ->get();
                //dd($registros_totales->toArray());


                //dd($conceptos);

                //$calculo = array();
                $calculo = [
                    'plantel' => "",
                    'seccion' => "",
                    'concepto' => "",
                    'clientes_activos' => 0,
                    'clientes_pagados' => 0,
                    'total_monto_pagado' => 0,
                    'suma_deudores' => 0,
                    'monto_deuda' => 0,
                    'porcentaje_pagado' => 0,
                    'deudores' => 0,
                    'bajas_pagadas' => 0,
                    'porcentaje_deudores' => 0,
                ];

                //recorrido linea de totales
                foreach ($registros_totales as $registro) {

                    $fecha_aux = Carbon::createFromFormat('Y-m-d', $registro->fecha_pago)->addDay(9);
                    $hoy = Carbon::createFromFormat('Y-m-d', date('Y-m-d'));

                    $calculo['plantel'] = $registro->razon;

                    if (
                        is_null($registro->borrado_c) and is_null($registro->borrado_cln) and
                        $registro->st_cliente_id <> 3

                    ) {
                        //Armado de detalle
                        $registro->adeudo_planeado = $this->getMontoPlaneadoCalculadoAdeudos($registro->adeudo, $registro->id);
                        //dd($registro);
                        array_push($lineas_detalle, $registro->toArray());
                        //dd($lineas_detalle);

                        //Fin Armado de detalle
                        $calculo['clientes_activos']++;
                        $calculo['concepto'] = "Total";
                        if ($registro->pagado_bnd == 1) {
                            $calculo['clientes_pagados'] = $calculo['clientes_pagados'] + $registro->pagado_bnd;
                            $calculo['total_monto_pagado'] = $calculo['total_monto_pagado'] + $registro->monto_pago;
                        } elseif ($registro->pagado_bnd == 0) {
                            $calculo['suma_deudores'] = $calculo['suma_deudores'] + 1;
                            $calculo['monto_deuda'] = $calculo['monto_deuda'] + $registro->adeudo_planeado;
                        }
                        $calculo['porcentaje_pagado'] = ($calculo['clientes_pagados'] * 100) / $calculo['clientes_activos'];
                        $calculo['deudores'] = $calculo['clientes_activos'] - $calculo['clientes_pagados'];
                        $calculo['porcentaje_deudores'] = ($calculo['deudores'] * 100) / $calculo['clientes_activos'];
                    } elseif (
                        is_null($registro->borrado_c) and
                        is_null($registro->borrado_cln) and
                        $registro->st_cliente_id == 3
                    ) {

                        $baja = HistoriaCliente::where('cliente_id', $registro->id)
                            ->where('evento_cliente_id', 2)
                            ->where('fecha', '>=', $datos['fecha_f'])
                            ->where('fecha', '<=', $datos['fecha_t'])
                            ->first();

                        if (is_array($baja) and $registro->caja > 0) {
                            $calculo['bajas_pagadas'] = $calculo['bajas_pagadas'] + 1;
                        }
                    }
                    //array_push($lineas_detalle, $registro->toArray());
                }
                array_push($lineas_procesadas, $calculo);
                /*
                $conceptos = array();
                foreach ($registros_totales as $registro) {
                    if (!in_array($registro->concepto_id, $conceptos)) {
                        $conceptos[$registro->concepto_id] = $registro->concepto;
                    }
                }
                $secciones=array();
                foreach ($registros_totales as $registro) {
                    if (!in_array($registro->seccion, $secciones)) {
                        $secciones[$registro->seccion] = $registro->seccion;
                    }
                }*/
                $calculo = [
                    'plantel' => "",
                    'seccion' => "",
                    'concepto' => "",
                    'clientes_activos' => 0,
                    'clientes_pagados' => 0,
                    'total_monto_pagado' => 0,
                    'suma_deudores' => 0,
                    'monto_deuda' => 0,
                    'porcentaje_pagado' => 0,
                    'deudores' => 0,
                    'bajas_pagadas' => 0,
                    'porcentaje_deudores' => 0,
                ];
                $seccion_aux = "";
                $concepto_aux = "";
                foreach ($registros_totales as $registro) {

                    if (
                        is_null($registro->borrado_c) and is_null($registro->borrado_cln) and
                        $registro->st_cliente_id <> 3
                    ) {
                        if ($seccion_aux <> "" and $concepto_aux <> "") {

                            if ($seccion_aux <> $registro->seccion or $concepto_aux <> $registro->concepto) {
                                array_push($lineas_procesadas, $calculo);
                                //$calculo['seccion']=$registro->seccion;
                                $calculo['clientes_activos'] = 0;
                                $calculo['monto_deuda'] = 0;
                            }
                        }
                        $calculo['plantel'] = $registro->razon;
                        $calculo['seccion'] = $registro->seccion;

                        $calculo['concepto'] = $registro->concepto;
                        $calculo['clientes_activos']++;
                        if ($registro->pagado_bnd == 1) {
                            $calculo['clientes_pagados'] = $calculo['clientes_pagados'] + $registro->pagado_bnd;
                            $calculo['total_monto_pagado'] = $calculo['total_monto_pagado'] + $registro->monto_pago;
                        } elseif ($registro->pagado_bnd == 0) {
                            $calculo['suma_deudores'] = $calculo['suma_deudores'] + 1;
                            $calculo['monto_deuda'] = $calculo['monto_deuda'] + $registro->adeudo_planeado;
                        }
                        $calculo['porcentaje_pagado'] = ($calculo['clientes_pagados'] * 100) / $calculo['clientes_activos'];
                        $calculo['deudores'] = $calculo['clientes_activos'] - $calculo['clientes_pagados'];
                        $calculo['porcentaje_deudores'] = ($calculo['deudores'] * 100) / $calculo['clientes_activos'];
                        $concepto_aux = $registro->concepto;
                        $seccion_aux = $registro->seccion;
                    } elseif (is_null($registro->borrado_c) and is_null($registro->borrado_cln) and $registro->st_cliente_id == 3) {
                        $baja = HistoriaCliente::where('cliente_id', $registro->id)
                            ->where('evento_cliente_id', 2)
                            ->where('fecha', '>=', $datos['fecha_f'])
                            ->where('fecha', '<=', $datos['fecha_t'])
                            ->first();
                        if (is_array($baja) and $registro->caja > 0) {
                            $calculo['bajas_pagadas'] = $calculo['bajas_pagadas'] + 1;
                        }
                    }
                }
                array_push($lineas_procesadas, $calculo);


                //dd($secciones);

            }
            return view('adeudos.reportes.maestroEjecutivoAdeudosR', compact('lineas_procesadas', 'lineas_detalle', 'datos'));
        } else {
            foreach ($datos['plantel_f'] as $plantel) {
                $cajas_sin_adeudos = Caja::select(
                    'p.id as plantel_id',
                    'p.razon',
                    'c.id as cliente_id',
                    'c.nombre',
                    'c.nombre2',
                    'c.ape_paterno',
                    'c.ape_materno',
                    DB::raw('"vacio" as especialidad'),
                    'g.seccion',
                    'c.matricula',
                    'cc.name as concepto',
                    'cc.id as concepto_id',
                    'cln.total as pago_calculado_adeudo',
                    'cajas.id as caja',
                    'cajas.consecutivo',
                    'cln.deleted_at as borrado_cln',
                    'cajas.deleted_at as borrado_c',
                    'cajas.usu_alta_id',
                    'c.st_cliente_id',
                    'stc.name as st_cliente',
                    's.st_seguimiento_id',
                    'sts.name as st_seguimiento',
                    DB::raw('date(0000-00-00) as fecha_pago'),
                    'cajas.id',
                    'cc.name as mensualidad',
                    DB::raw('1 as pagado_bnd'),
                    't.name as turno',
                    'pag.monto as monto_pago',
                    'pag.fecha as fecha_pago',
                    'cajas.created_at as fec_creacion_caja',
                    'fp.name as forma_pago'
                )
                    ->join('clientes as c', 'c.id', '=', 'cajas.cliente_id')
                    ->join('st_clientes as stc', 'stc.id', '=', 'c.st_cliente_id')
                    ->join('seguimientos as s', 's.cliente_id', '=', 'c.id')
                    ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
                    ->join('plantels as p', 'p.id', '=', 'cajas.plantel_id')
                    ->join('caja_lns as cln', 'cln.caja_id', '=', 'cajas.id')
                    ->join('caja_conceptos as cc', 'cc.id', 'cln.caja_concepto_id')
                    ->join('pagos as pag', 'pag.caja_id', '=', 'cajas.id')
                    ->join('combinacion_clientes as ccli', 'ccli.cliente_id', '=', 'c.id')
                    ->join('especialidads as esp', 'esp.id', 'ccli.especialidad_id')
                    ->join('grados as g', 'g.id', '=', 'ccli.grado_id')
                    ->join('turnos as t', 't.id', '=', 'ccli.turno_id')
                    ->join('forma_pagos as fp', 'fp.id', 'cajas.forma_pago_id')
                    ->where('cajas.plantel_id', $plantel)
                    ->where('cajas.st_caja_id', 1)
                    ->where('cln.adeudo_id', 0)
                    ->whereNull('cln.deleted_at')
                    ->whereNull('pag.deleted_at')
                    ->whereIn('cc.id', $datos['concepto_f'])
                    ->whereNull('p.deleted_at')
                    ->whereNull('cajas.deleted_at')
                    ->whereNull('ccli.deleted_at')
                    ->whereDate('pag.fecha', '>=', $datos['fecha_f'])
                    ->whereDate('pag.fecha', '<=', $datos['fecha_t'])
                    ->orderBy('c.id');

                $registros_totales_aux = Adeudo::join('clientes as c', 'c.id', '=', 'adeudos.cliente_id')
                    ->join('st_clientes as stc', 'stc.id', '=', 'c.st_cliente_id')
                    ->join('seguimientos as s', 's.cliente_id', '=', 'c.id')
                    ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
                    ->join('caja_conceptos as adeudo_concepto', 'adeudo_concepto.id', '=', 'adeudos.caja_concepto_id')
                    ->join('combinacion_clientes as ccli', 'ccli.id', '=', 'adeudos.combinacion_cliente_id')
                    ->join('especialidads as esp', 'esp.id', 'ccli.especialidad_id')
                    ->join('grados as g', 'g.id', '=', 'ccli.grado_id')
                    ->join('turnos as t', 't.id', '=', 'ccli.turno_id')
                    ->join('caja_lns as cln', 'cln.adeudo_id', '=', 'adeudos.id')
                    ->join('cajas as caj', 'caj.id', '=', 'adeudos.caja_id')
                    ->join('forma_pagos as fp', 'fp.id', 'caj.forma_pago_id')
                    ->join('pagos as pag', 'pag.caja_id', '=', 'caj.id')
                    ->join('plantels as p', 'p.id', '=', 'caj.plantel_id')
                    ->whereDate('pag.fecha', '>=', $datos['fecha_f'])
                    ->whereDate('pag.fecha', '<=', $datos['fecha_t'])
                    ->join('caja_conceptos as cc', 'cc.id', '=', 'adeudos.caja_concepto_id')
                    ->where('caj.st_caja_id', 1)
                    ->whereNull('cln.deleted_at')
                    ->whereNull('pag.deleted_at')
                    ->select(
                        'p.id as plantel_id',
                        'p.razon',
                        'c.id as cliente_id',
                        'c.nombre',
                        'c.nombre2',
                        'c.ape_paterno',
                        'c.ape_materno',
                        'esp.name as especialidad',
                        'g.seccion',
                        'c.matricula',
                        'cc.name as concepto',
                        'cc.id as concepto_id',
                        'cln.total as pago_calculado_adeudo',
                        'caj.id as caja',
                        'caj.consecutivo',
                        'cln.deleted_at as borrado_cln',
                        'caj.deleted_at as borrado_c',
                        'caj.usu_alta_id',
                        'c.st_cliente_id',
                        'stc.name as st_cliente',
                        's.st_seguimiento_id',
                        'sts.name as st_seguimiento',
                        'adeudos.fecha_pago',
                        'adeudos.caja_id',
                        'adeudo_concepto.bnd_mensualidad as mensualidad',
                        'adeudos.pagado_bnd',
                        't.name as turno',
                        'pag.monto as monto_pago',
                        'pag.fecha as fecha_pago',
                        'caj.created_at as fec_creacion_caja',
                        'fp.name as forma_pago'
                        //DB::raw('(select sum(pp.monto) as monto_pago from pagos as pp where pp.caja_id=caj.id and pp.deleted_at is null and pp.bnd_pagado=1)')
                    )
                    ->whereNull('caj.deleted_at')
                    ->whereNull('ccli.deleted_at')
                    ->where('adeudos.pagado_bnd', 1)
                    ->orderBy('c.id')
                    ->union($cajas_sin_adeudos);

                $registros_totales1 = $registros_totales_aux->where('p.id', $plantel)

                    ->whereIn('adeudos.caja_concepto_id', $datos['concepto_f'])
                    ->whereNull('adeudos.deleted_at')
                    ->whereNull('s.deleted_at')
                    //->orderBy('p.id')
                    //->orderBy('adeudos.caja_concepto_id')
                    //->orderBy('c.id')
                    //->orderBy('p.id')
                    ->orderBy('seccion')
                    ->orderBy('concepto_id')
                    ->orderBy('cliente_id')
                    //->where('c.id',6072)
                    ->get();
                //dd($registros_totales1->toArray());
                $registros_totales = $registros_totales1;
                $registros_totales2 = $registros_totales1;

                $calculo = [
                    'plantel' => "",
                    'seccion' => "",
                    'concepto' => "",
                    'clientes_activos' => 0,
                    'clientes_pagados' => 0,
                    'total_monto_pagado' => 0,
                    'suma_deudores' => 0,
                    'monto_deuda' => 0,
                    'porcentaje_pagado' => 0,
                    'deudores' => 0,
                    'bajas_pagadas' => 0,
                    'porcentaje_deudores' => 0,
                ];

                foreach ($registros_totales as $registro) {

                    if (
                        is_null($registro->borrado_c) and is_null($registro->borrado_cln) /*and
                        $registro->st_cliente_id <> 3*/
                    ) {

                        array_push($lineas_detalle, $registro->toArray());
                    }
                }
                //dd($lineas_detalle);

                //recorrido linea de totales
                $caja_aux1 = "";
                $caja_aux2 = "";
                foreach ($registros_totales as $registro) {
                    //array_push($lineas_detalle, (array) $registro);
                    $fecha_aux = Carbon::createFromFormat('Y-m-d', $registro->fecha_pago)->addDay(9);
                    $hoy = Carbon::createFromFormat('Y-m-d', date('Y-m-d'));
                    //dd($hoy);

                    $calculo['plantel'] = $registro->razon;

                    if (
                        is_null($registro->borrado_c) and is_null($registro->borrado_cln) /*and
                        $registro->st_cliente_id <> 3*/

                    ) {

                        //Fin Armado de detalle
                        if ($caja_aux1 <> $registro->caja) {
                            $calculo['clientes_activos']++;
                        }
                        $caja_aux1 = $registro->caja;

                        //$calculo['clientes_activos']++;
                        $calculo['concepto'] = "Total";
                        if ($registro->pagado_bnd == 1) {
                            if ($caja_aux2 <> $registro->caja) {
                                $calculo['clientes_pagados'] = $calculo['clientes_pagados'] + $registro->pagado_bnd;
                            }
                            $caja_aux2 = $registro->caja;

                            $calculo['total_monto_pagado'] = $calculo['total_monto_pagado'] + $registro->monto_pago;
                        } elseif ($registro->pagado_bnd == 0) {
                            $calculo['suma_deudores'] = $calculo['suma_deudores'] + 1;
                            $calculo['monto_deuda'] = $calculo['monto_deuda'] + $registro->adeudo_planeado;
                        }
                        $calculo['porcentaje_pagado'] = ($calculo['clientes_pagados'] * 100) / $calculo['clientes_activos'];
                        $calculo['deudores'] = $calculo['clientes_activos'] - $calculo['clientes_pagados'];
                        $calculo['porcentaje_deudores'] = ($calculo['deudores'] * 100) / $calculo['clientes_activos'];
                    } //antes else if
                    if (is_null($registro->borrado_c) and is_null($registro->borrado_cln) and $registro->st_cliente_id == 3) {
                        $baja = HistoriaCliente::where('cliente_id', $registro->id)
                            ->where('evento_cliente_id', 2)
                            ->where('fecha', '>=', $datos['fecha_f'])
                            ->where('fecha', '<=', $datos['fecha_t'])
                            ->first();
                        //dd($baja);
                        if (is_array($baja) and $registro->caja > 0) {
                            $calculo['bajas_pagadas'] = $calculo['bajas_pagadas'] + 1;
                        }
                    }
                }
                array_push($lineas_procesadas, $calculo);
                //dd($lineas_procesadas);

                $calculo = [
                    'plantel' => "",
                    'seccion' => "",
                    'concepto' => "",
                    'clientes_activos' => 0,
                    'clientes_pagados' => 0,
                    'total_monto_pagado' => 0,
                    'suma_deudores' => 0,
                    'monto_deuda' => 0,
                    'porcentaje_pagado' => 0,
                    'deudores' => 0,
                    'bajas_pagadas' => 0,
                    'porcentaje_deudores' => 0,
                ];

                $concepto_aux = "";
                $seccion_aux = "";
                $caja_aux1 = "";
                $caja_aux2 = "";
                foreach ($registros_totales as $registro) {
                    if (
                        is_null($registro->borrado_c) and is_null($registro->borrado_cln) /*and
                        $registro->st_cliente_id <> 3*/

                    ) {
                        if ($seccion_aux <> "" and $concepto_aux <> "" and $calculo['clientes_activos'] > 0) {

                            if ($seccion_aux <> $registro->seccion or $concepto_aux <> $registro->concepto) {
                                array_push($lineas_procesadas, $calculo);
                                //$calculo['seccion']=$registro->seccion;
                                $calculo['clientes_activos'] = 0;
                                $calculo['monto_deuda'] = 0;
                                $calculo['total_monto_pagado'] = 0;
                                $calculo['clientes_pagados'] = 0;
                            }
                        }
                        $calculo['plantel'] = $registro->razon;
                        $calculo['seccion'] = $registro->seccion;
                        $calculo['concepto'] = $registro->concepto;
                        if ($caja_aux1 <> $registro->caja) {
                            $calculo['clientes_activos']++;
                        }
                        $caja_aux1 = $registro->caja;
                        if ($registro->pagado_bnd == 1) {
                            if ($caja_aux2 <> $registro->caja) {
                                $calculo['clientes_pagados'] = $calculo['clientes_pagados'] + $registro->pagado_bnd;
                            }
                            $caja_aux2 = $registro->caja;

                            $calculo['total_monto_pagado'] = $calculo['total_monto_pagado'] + $registro->monto_pago;
                        } elseif ($registro->pagado_bnd == 0) {
                            $calculo['suma_deudores'] = $calculo['suma_deudores'] + 1;
                            $calculo['monto_deuda'] = $calculo['monto_deuda'] + $registro->adeudo_planeado;
                        }
                        if ($calculo['seccion'] == "LANI") {
                            //dd($calculo['clientes_pagados'] ."-". $calculo['clientes_activos']);
                        }

                        $calculo['porcentaje_pagado'] = ($calculo['clientes_pagados'] * 100) / $calculo['clientes_activos'];
                        $calculo['deudores'] = $calculo['clientes_activos'] - $calculo['clientes_pagados'];
                        $calculo['porcentaje_deudores'] = ($calculo['deudores'] * 100) / $calculo['clientes_activos'];
                        $concepto_aux = $registro->concepto;
                        $seccion_aux = $registro->seccion;
                    } //antes else if
                    if (is_null($registro->borrado_c) and is_null($registro->borrado_cln) and $registro->st_cliente_id == 3) {
                        $baja = HistoriaCliente::where('cliente_id', $registro->id)
                            ->where('evento_cliente_id', 2)
                            ->where('fecha', '>=', $datos['fecha_f'])
                            ->where('fecha', '<=', $datos['fecha_t'])
                            ->first();

                        if (is_array($baja) and $registro->caja > 0) {
                            $calculo['bajas_pagadas'] = $calculo['bajas_pagadas'] + 1;
                        }
                    }
                }
                array_push($lineas_procesadas, $calculo);
                //dd($lineas_detalle);

            }
            return view('adeudos.reportes.maestroEjecutivoPagosR', compact('lineas_procesadas', 'lineas_detalle', 'datos'));
        }



        //dd($lineas_detalle);


    }

    public function alumnosActivosAdeudos()
    {
        $planteles = Plantel::pluck('razon', 'id');
        $conceptos = CajaConcepto::pluck('name', 'id');
        $estatus = StCliente::pluck('name', 'id');
        return view('adeudos.reportes.alumnosActivosAdeudos', compact('planteles', 'conceptos', 'estatus'));
    }

    public function alumnosActivosAdeudosR(Request $request)
    {
        $datos = $request->all();
        //dd($datos);
        $registros = Adeudo::select(
            'p.razon',
            'l.ciclo_escolar',
            'l.periodo_escolar',
            'cli.id as cliente_id',
            'cli.matricula',
            'g.name as grupo',
            'cli.nombre',
            'cli.nombre2',
            'cli.ape_paterno',
            'cli.ape_materno',
            'adeudos.monto',
            'stc.name as st_cliente',
            'cc.name as concepto',
            'caj.total',
            DB::raw('IF(adeudos.pagado_bnd=1, "SI", "NO") as pagado_bnd'),
            'caj.id as caja_id',
            'gra.seccion'
        )
            ->leftJoin('cajas as caj', 'caj.id', 'adeudos.caja_id')
            ->join('caja_conceptos as cc', 'cc.id', 'adeudos.caja_concepto_id')
            ->join('clientes as cli', 'cli.id', 'adeudos.cliente_id')
            ->join('st_clientes as stc', 'stc.id', 'cli.st_cliente_id')
            ->leftJoin('inscripcions as i', 'i.cliente_id', 'cli.id')
            ->join('plantels as p', 'p.id', 'i.plantel_id')
            ->join('grupos as g', 'g.id', 'i.grupo_id')
            ->join('lectivos as l', 'l.id', 'i.lectivo_id')
            ->join('grados as gra', 'gra.id', 'i.grado_id')
            ->whereIn('p.id', $datos['plantel_f'])
            ->whereIn('cc.id', $datos['concepto_f'])
            ->whereIn('stc.id', $datos['estatus_f'])
            ->whereDate('adeudos.fecha_pago', '>=', $datos['fecha_f'])
            ->whereDate('adeudos.fecha_pago', '<=', $datos['fecha_t'])
            ->whereNull('i.deleted_at')
            ->whereNull('cli.deleted_at')
            ->orderBy('p.razon')
            ->orderBy('cc.id')
            ->orderBy('cli.ape_paterno')
            ->orderBy('cli.ape_materno')
            ->orderBy('cli.nombre')
            ->orderBy('cli.nombre2')
            ->get();
        //dd($registros->toArray());

        //dd($resumen);

        return view('adeudos.reportes.alumnosActivosAdeudosR', compact('registros'));
    }

    public function alumnosActivosAdeudosPlantelR(Request $request)
    {
        $datos = $request->all();
        //dd($datos);
        $hoy = Carbon::createFromFormat('Y-m-d', Date('Y-m-d'));
        $hoy->day = 1;
        $fecha_planeada = $hoy;
        $fecha_4meses_atras = Carbon::createFromFormat('Y-m-d', Date('Y-m-d'));
        $fecha_4meses_atras->subMonth(4);

        //dd($fecha_planeada->toDateString());
        $mesNumero = $hoy->month;
        $mes = Mese::find($mesNumero);
        $cuenta_detalle = Adeudo::select(
            DB::raw('IF(adeudos.pagado_bnd=1, "SI", "NO") as pagado_bnd'),
            'p.razon',
            'cli.id as cliente_id',
            'stc.name as estatus',
            'adeudos.monto'
        )
            ->join('clientes as cli', 'cli.id', 'adeudos.cliente_id')
            ->join('caja_conceptos as cc', 'cc.id', 'adeudos.caja_concepto_id')
            ->join('st_clientes as stc', 'stc.id', 'cli.st_cliente_id')
            ->join('plantels as p', 'p.id', 'cli.plantel_id')
            ->where('cli.plantel_id', $datos['plantel'])
            ->where('cc.name', 'like', '%' . $mes->name . '%')
            ->where('adeudos.fecha_pago', $fecha_planeada->toDateString())
            ->whereIn('cli.st_cliente_id', array(4, 20, 22, 25, 26))
            ->whereNull('cli.deleted_at')
            ->orderBy('stc.id')
            ->get();

        $detalle_bajas = Adeudo::select(
            'p.razon',
            'cli.id as cliente_id',
            'stc.name as estatus',
            'stc.id as st_cliente_id',
            'cc.name as concepto',
            'adeudos.fecha_pago as fecha_planeada',
            DB::raw('IF(adeudos.pagado_bnd=1, "SI", "NO") as pagado_bnd'),
            'adeudos.id as adeudo_id',
            'adeudos.caja_id'
        )
            ->join('clientes as cli', 'cli.id', 'adeudos.cliente_id')
            ->join('caja_conceptos as cc', 'cc.id', 'adeudos.caja_concepto_id')
            ->join('plantels as p', 'p.id', 'cli.plantel_id')
            ->join('st_clientes as stc', 'stc.id', 'cli.st_cliente_id')
            ->where('cli.plantel_id', $datos['plantel'])
            ->where('adeudos.pagado_bnd', 0)
            ->whereDate('adeudos.fecha_pago', '>=', $fecha_4meses_atras->toDateString())
            ->whereDate('adeudos.fecha_pago', '<=', $fecha_planeada->toDateString())
            ->whereIn('cli.st_cliente_id', array(25, 26))
            ->whereNull('cli.deleted_at')
            ->orderBy('p.id')
            ->orderBy('cli.st_cliente_id')
            ->orderBy('cli.id')
            ->orderBy('adeudos.fecha_pago')
            ->get();
        $tabla = array();
        $linea = array();
        foreach ($detalle_bajas as $detalle) {
            $linea['razon'] = $detalle->razon;
            $linea['cliente_id'] = $detalle->cliente_id;
            $linea['estatus'] = $detalle->estatus;
            $linea['st_cliente_id'] = $detalle->st_cliente_id;
            $linea['concepto'] = $detalle->concepto;
            $linea['fecha_planeada'] = $detalle->fecha_planeada;
            $linea['pagado_bnd'] = $detalle->pagado_bnd;
            $linea['adeudo_id'] = $detalle->adeudo_id;
            $linea['caja_id'] = $detalle->caja_id;
            if ($detalle->pagado_bnd == "NO") {
                $linea['adeudo_calculado'] = $this->getMontoPlaneadoCalculadoAdeudos($detalle->adeudo_id, $detalle->cliente_id);
                $linea['pago_caja'] = 0;
                $linea['monto'] = $linea['adeudo_calculado'];
            } else {
                $linea['pago_caja'] = Pago::where('caja_id', $detalle->caja_id)->sum('monto');
                $linea['adeudo_calculado'] = 0;
                $linea['monto'] = $linea['pago_caja'];
            }
            array_push($tabla, $linea);
        }
        //dd($tabla);
        $detalle_activos_vigentes = Adeudo::select(
            'p.razon',
            'cli.id as cliente_id',
            'stc.name as estatus',
            'stc.id as st_cliente_id',
            'cc.name as concepto',
            'adeudos.fecha_pago as fecha_planeada',
            DB::raw('IF(adeudos.pagado_bnd=1, "SI", "NO") as pagado_bnd'),
            'adeudos.id as adeudo_id',
            'adeudos.caja_id'
        )
            ->join('clientes as cli', 'cli.id', 'adeudos.cliente_id')
            ->join('caja_conceptos as cc', 'cc.id', 'adeudos.caja_concepto_id')
            ->join('plantels as p', 'p.id', 'cli.plantel_id')
            ->join('st_clientes as stc', 'stc.id', 'cli.st_cliente_id')
            ->where('cli.plantel_id', $datos['plantel'])
            //->where('adeudos.pagado_bnd', 0)
            ->whereDate('adeudos.fecha_pago', $fecha_planeada->toDateString())
            ->whereIn('cli.st_cliente_id', array(4, 20, 22))
            ->whereNull('cli.deleted_at')
            ->orderBy('p.id')
            ->orderBy('cli.st_cliente_id')
            ->orderBy('cli.id')
            ->orderBy('adeudos.fecha_pago')
            ->get();
        //dd($detalle_dinero->toArray());    

        foreach ($detalle_activos_vigentes as $detalle) {
            $linea['razon'] = $detalle->razon;
            $linea['cliente_id'] = $detalle->cliente_id;
            $linea['estatus'] = $detalle->estatus;
            $linea['st_cliente_id'] = $detalle->st_cliente_id;
            $linea['concepto'] = $detalle->concepto;
            $linea['fecha_planeada'] = $detalle->fecha_planeada;
            $linea['pagado_bnd'] = $detalle->pagado_bnd;
            $linea['adeudo_id'] = $detalle->adeudo_id;
            $linea['caja_id'] = $detalle->caja_id;
            if ($detalle->pagado_bnd == "NO") {
                $linea['adeudo_calculado'] = $this->getMontoPlaneadoCalculadoAdeudos($detalle->adeudo_id, $detalle->cliente_id);
                $linea['pago_caja'] = 0;
                $linea['monto'] = $linea['adeudo_calculado'];
            } else {
                $linea['pago_caja'] = Pago::where('caja_id', $detalle->caja_id)->sum('monto');
                $linea['adeudo_calculado'] = 0;
                $linea['monto'] = $linea['pago_caja'];
            }
            array_push($tabla, $linea);
        }


        //dd($tabla);
        //dd($cuenta_detalle->toArray());
        return view('adeudos.reportes.alumnosActivosAdeudosPlantelR', compact('cuenta_detalle', 'tabla'));
    }

    public function globalFinanciero()
    {
        $planteles = Plantel::pluck('razon', 'id');
        $conceptos = CajaConcepto::pluck('name', 'id');
        $estatus = StCliente::pluck('name', 'id');
        return view('adeudos.reportes.globalFinanciero', compact('planteles', 'conceptos', 'estatus'));
    }

    public function globalFinancieroR(Request $request)
    {
        $datos = $request->all();
        $planteles = Plantel::whereIn('id', $datos['plantel_f'])->get();
        $hoy = Carbon::createFromFormat('Y-m-d', Date('Y-m-d'));
        $hoy->day = 1;
        $fecha_planeada = $hoy;
        $fecha_4meses_atras = Carbon::createFromFormat('Y-m-d', Date('Y-m-d'));
        $fecha_4meses_atras->subMonth(4);
        //dd($fecha_4meses_atras);
        //dd($fecha_planeada->toDateString());
        $mesNumero = $hoy->month;
        $mes = Mese::find($mesNumero);
        //dd($mes);
        $resumen = array();
        $registro = array();

        foreach ($planteles as $plantel) {
            $registro['plantel_id'] = $plantel->id;
            $registro['plantel'] = $plantel->razon;
            $suma_estatus = 0;
            //calcula cantidad de clientes con adeudos planeado segun estatus recibidos

            $cuenta = Adeudo::join('clientes as cli', 'cli.id', 'adeudos.cliente_id')
                ->join('caja_conceptos as cc', 'cc.id', 'adeudos.caja_concepto_id')
                ->where('cli.plantel_id', $plantel->id)
                ->where('cc.name', 'like', '%' . $mes->name . '%')
                ->whereDate('adeudos.fecha_pago', '=', $fecha_planeada->toDateString())
                ->where('cli.st_cliente_id', 26)
                ->whereNull('cli.deleted_at')
                ->count();
            //dd($cuenta);
            $registro['baja_administrativa'] = $cuenta;
            $suma_estatus = $suma_estatus + $cuenta;

            $cuenta = Adeudo::join('clientes as cli', 'cli.id', 'adeudos.cliente_id')
                ->join('caja_conceptos as cc', 'cc.id', 'adeudos.caja_concepto_id')
                ->where('cli.plantel_id', $plantel->id)
                ->where('cc.name', 'like', '%' . $mes->name . '%')
                ->whereDate('adeudos.fecha_pago', '=', $fecha_planeada->toDateString())
                ->where('cli.st_cliente_id', 25)
                ->whereNull('cli.deleted_at')
                ->count();
            //dd($cuenta);
            $registro['baja_temporal_por_pago'] = $cuenta;
            $suma_estatus = $suma_estatus + $cuenta;

            $cuenta = Adeudo::join('clientes as cli', 'cli.id', 'adeudos.cliente_id')
                ->join('seguimientos as s', 's.cliente_id', 'cli.id')
                ->join('caja_conceptos as cc', 'cc.id', 'adeudos.caja_concepto_id')
                ->where('cli.plantel_id', $plantel->id)
                ->where('cc.name', 'like', '%' . $mes->name . '%')
                ->whereNull('cli.deleted_at')
                ->whereDate('adeudos.fecha_pago', '=', $fecha_planeada->toDateString())
                ->whereIn('cli.st_cliente_id', array(4, 20, 22))
                ->count();
            //dd($cuenta);
            $registro['activos_vigentes'] = $cuenta;
            $suma_estatus = $suma_estatus + $cuenta;

            $registro['suma_estatus'] = $suma_estatus;

            $cuenta = Adeudo::join('clientes as cli', 'cli.id', 'adeudos.cliente_id')
                ->join('caja_conceptos as cc', 'cc.id', 'adeudos.caja_concepto_id')
                ->where('cli.plantel_id', $plantel->id)
                ->where('cc.name', 'like', '%' . $mes->name . '%')
                ->whereNull('cli.deleted_at')
                ->whereDate('adeudos.fecha_pago', '=', $fecha_planeada->toDateString())
                ->where('cli.st_cliente_id', 22)
                ->count();
            //dd($cuenta);
            $registro['preinscritos'] = $cuenta;

            $cuenta_pagados = Adeudo::join('clientes as cli', 'cli.id', 'adeudos.cliente_id')
                ->join('caja_conceptos as cc', 'cc.id', 'adeudos.caja_concepto_id')
                ->where('cli.plantel_id', $plantel->id)
                ->where('cc.name', 'like', '%' . $mes->name . '%')
                ->whereDate('adeudos.fecha_pago', $fecha_planeada->toDateString())
                ->where('adeudos.pagado_bnd', 1)
                ->whereNull('cli.deleted_at')
                ->whereIn('cli.st_cliente_id', array(4, 20, 22, 25, 26))
                ->count();
            $registro['cuenta_pagados'] = $cuenta_pagados;

            $cuenta_no_pagados = Adeudo::join('clientes as cli', 'cli.id', 'adeudos.cliente_id')
                ->join('caja_conceptos as cc', 'cc.id', 'adeudos.caja_concepto_id')
                ->where('cli.plantel_id', $plantel->id)
                ->where('cc.name', 'like', '%' . $mes->name . '%')
                ->whereDate('adeudos.fecha_pago', $fecha_planeada->toDateString())
                ->where('adeudos.pagado_bnd', '<>', 1)
                ->whereNull('cli.deleted_at')
                ->whereIn('cli.st_cliente_id', array(4, 20, 22, 25, 26))
                ->count();
            $registro['cuenta_no_pagados'] = $cuenta_no_pagados;


            //Se obtiene el universo de registros con su pago o monto planeado calculado
            $tabla = array();
            $linea = array();
            if (isset($datos['bnd_suma_monetaria'])) {
                $detalle_bajas = Adeudo::select(
                    'p.razon',
                    'cli.id as cliente_id',
                    'stc.name as estatus',
                    'stc.id as st_cliente_id',
                    'cc.name as concepto',
                    'adeudos.fecha_pago as fecha_planeada',
                    DB::raw('IF(adeudos.pagado_bnd=1, "SI", "NO") as pagado_bnd'),
                    'adeudos.id as adeudo_id',
                    'adeudos.caja_id'
                )
                    ->join('clientes as cli', 'cli.id', 'adeudos.cliente_id')
                    ->join('caja_conceptos as cc', 'cc.id', 'adeudos.caja_concepto_id')
                    ->join('plantels as p', 'p.id', 'cli.plantel_id')
                    ->join('st_clientes as stc', 'stc.id', 'cli.st_cliente_id')
                    ->where('cli.plantel_id', $plantel->id)
                    ->where('adeudos.pagado_bnd', 0)
                    ->whereDate('adeudos.fecha_pago', '>=', $fecha_4meses_atras->toDateString())
                    ->whereDate('adeudos.fecha_pago', '<=', $fecha_planeada->toDateString())
                    ->whereIn('cli.st_cliente_id', array(25, 26))
                    ->whereNull('cli.deleted_at')
                    ->orderBy('p.id')
                    ->orderBy('cli.st_cliente_id')
                    ->orderBy('cli.id')
                    ->orderBy('adeudos.fecha_pago')
                    ->get();

                foreach ($detalle_bajas as $detalle) {
                    $linea['razon'] = $detalle->razon;
                    $linea['cliente_id'] = $detalle->cliente_id;
                    $linea['estatus'] = $detalle->estatus;
                    $linea['st_cliente_id'] = $detalle->st_cliente_id;
                    $linea['concepto'] = $detalle->concepto;
                    $linea['fecha_planeada'] = $detalle->fecha_planeada;
                    $linea['pagado_bnd'] = $detalle->pagado_bnd;
                    $linea['adeudo_id'] = $detalle->adeudo_id;
                    $linea['caja_id'] = $detalle->caja_id;
                    if ($detalle->pagado_bnd == "NO") {
                        $linea['adeudo_calculado'] = $this->getMontoPlaneadoCalculadoAdeudos($detalle->adeudo_id, $detalle->cliente_id);
                        $linea['pago_caja'] = 0;
                        $linea['monto'] = $linea['adeudo_calculado'];
                    } else {
                        $linea['pago_caja'] = Pago::where('caja_id', $detalle->caja_id)->sum('monto');
                        $linea['adeudo_calculado'] = 0;
                        $linea['monto'] = $linea['pago_caja'];
                    }
                    array_push($tabla, $linea);
                }
                //dd($tabla);
                $detalle_activos_vigentes = Adeudo::select(
                    'p.razon',
                    'cli.id as cliente_id',
                    'stc.name as estatus',
                    'stc.id as st_cliente_id',
                    'cc.name as concepto',
                    'adeudos.fecha_pago as fecha_planeada',
                    DB::raw('IF(adeudos.pagado_bnd=1, "SI", "NO") as pagado_bnd'),
                    'adeudos.id as adeudo_id',
                    'adeudos.caja_id'
                )
                    ->join('clientes as cli', 'cli.id', 'adeudos.cliente_id')
                    ->join('caja_conceptos as cc', 'cc.id', 'adeudos.caja_concepto_id')
                    ->join('plantels as p', 'p.id', 'cli.plantel_id')
                    ->join('st_clientes as stc', 'stc.id', 'cli.st_cliente_id')
                    ->where('cli.plantel_id', $plantel->id)
                    //->where('adeudos.pagado_bnd', 0)
                    ->whereDate('adeudos.fecha_pago', $fecha_planeada->toDateString())
                    ->whereIn('cli.st_cliente_id', array(4, 20, 22))
                    ->whereNull('cli.deleted_at')
                    ->orderBy('p.id')
                    ->orderBy('cli.st_cliente_id')
                    ->orderBy('cli.id')
                    ->orderBy('adeudos.fecha_pago')
                    ->get();
                //dd($detalle_dinero->toArray());    

                foreach ($detalle_activos_vigentes as $detalle) {
                    $linea['razon'] = $detalle->razon;
                    $linea['cliente_id'] = $detalle->cliente_id;
                    $linea['estatus'] = $detalle->estatus;
                    $linea['st_cliente_id'] = $detalle->st_cliente_id;
                    $linea['concepto'] = $detalle->concepto;
                    $linea['fecha_planeada'] = $detalle->fecha_planeada;
                    $linea['pagado_bnd'] = $detalle->pagado_bnd;
                    $linea['adeudo_id'] = $detalle->adeudo_id;
                    $linea['caja_id'] = $detalle->caja_id;
                    if ($detalle->pagado_bnd == "NO") {
                        $linea['adeudo_calculado'] = $this->getMontoPlaneadoCalculadoAdeudos($detalle->adeudo_id, $detalle->cliente_id);
                        $linea['pago_caja'] = 0;
                        $linea['monto'] = $linea['adeudo_calculado'];
                    } else {
                        $linea['pago_caja'] = Pago::where('caja_id', $detalle->caja_id)->sum('monto');
                        $linea['adeudo_calculado'] = 0;
                        $linea['monto'] = $linea['pago_caja'];
                    }
                    array_push($tabla, $linea);
                }


                //Filtro del universo para bajas administrativas
                $conjunto_ba = Arr::where($tabla, function ($r, $key) {
                    if ($r['st_cliente_id'] == 26) {
                        return $r;
                    }
                });
                $suma_ba = 0;
                foreach ($conjunto_ba as $r) {
                    $suma_ba = $suma_ba + $r['monto'];
                }
                $registro['suma_ba'] = $suma_ba;

                //Filtro del universo para baja temporal por pago
                $conjunto_btp = Arr::where($tabla, function ($r, $key) {
                    if ($r['st_cliente_id'] == 25) {
                        return $r;
                    }
                });
                $suma_btp = 0;
                foreach ($conjunto_btp as $r) {
                    $suma_btp = $suma_btp + $r['monto'];
                }
                $registro['suma_btp'] = $suma_btp;

                //Filtro del universo para activos vigentes
                $conjunto_activos_vigentes = Arr::where($tabla, function ($r, $key) {
                    if ($r['st_cliente_id'] == 4 or $r['st_cliente_id'] == 20 or $r['st_cliente_id'] == 22) {
                        return $r;
                    }
                });

                $suma_activos_vigentes = 0;
                foreach ($conjunto_activos_vigentes as $r) {
                    $suma_activos_vigentes = $suma_activos_vigentes + $r['monto'];
                }
                $registro['suma_activos_vigentes'] = $suma_activos_vigentes;

                //suma de bajas y activos vigentes
                $suma = $suma_ba + $suma_btp + $suma_activos_vigentes;
                $registro['suma'] = $suma;

                //Filtro del universo para no pagados
                $conjunto_no_pagados = Arr::where($tabla, function ($r, $key) {
                    if ($r['pagado_bnd'] == 'NO') {
                        return $r;
                    }
                });

                $suma_no_pagados = 0;
                foreach ($conjunto_no_pagados as $r) {
                    $suma_no_pagados = $suma_no_pagados + $r['monto'];
                }
                $registro['suma_no_pagados'] = $suma_no_pagados;

                //Filtro del universo para pagados
                $conjunto_pagados = Arr::where($tabla, function ($r, $key) {
                    if ($r['pagado_bnd'] <> 'NO') {
                        return $r;
                    }
                });

                $suma_pagados = 0;
                foreach ($conjunto_pagados as $r) {
                    $suma_pagados = $suma_pagados + $r['monto'];
                }
                $registro['suma_pagados'] = $suma_pagados;
                //dd($registro);
                //Filtro del universo para preinscritos
                $conjunto_preinscritos = Arr::where($tabla, function ($r, $key) {
                    if ($r['st_cliente_id'] == 22) {
                        return $r;
                    }
                });
                $suma_preinscritos = 0;
                foreach ($conjunto_preinscritos as $r) {
                    $suma_preinscritos = $suma_preinscritos + $r['monto'];
                }
                $registro['suma_preinscritos'] = $suma_preinscritos;
            }
            array_push($resumen, $registro);
        }

        //dd($tabla);

        //dd($resumen);
        return view('adeudos.reportes.globalFinancieroR', compact('resumen', 'tabla'));
    }

    public function ingresosTotales()
    {
        if (Auth::user()->can('adeudos.maestroXPlantel')) {
            $empleado = Empleado::where('user_id', Auth::user()->id)->first();
            $planteles = array();
            foreach ($empleado->plantels as $p) {
                //dd($p->id);
                array_push($planteles, $p->id);
            }

            $planteles = Plantel::whereIn('id', $planteles)->pluck('razon', 'id');
        } else {
            $planteles = Plantel::pluck('razon', 'id');
        }

        $conceptos = CajaConcepto::pluck('name', 'id');

        //dd($stCajas);
        return view('adeudos.reportes.ingresosTotales', compact('planteles', 'conceptos'));
    }

    public function ingresosTotalesR(Request $request)
    {
        $datos = $request->all();
        //dd($datos);
        $hoy = Carbon::createFromFormat('Y-m-d', Date('Y-m-d'));
        $lineas_procesadas = array();
        $lineas_detalle = array();
        $formas_pago = FormaPago::where('id', '>', 0)->get();
        $planteles = Plantel::with('cuentaP')->where('id', '>', 1)
            ->orderBy('plantels.id')
            ->orderBy('plantels.razon')
            ->get();


        $resultado = array();
        $grafica = array();

        foreach ($planteles as $plantel) {
            $registro = array();
            $totales_efectivo = Pago::join('cajas as caj', 'caj.id', 'pagos.caja_id')
                ->join('forma_pagos as fm', 'fm.id', 'caj.forma_pago_id')
                ->where('pagos.created_at', '>=', $datos['fecha_f'])
                ->where('pagos.created_at', '<=', $datos['fecha_t'])
                ->where('pagos.forma_pago_id', 1)
                ->where('bnd_pagado', 1)
                ->where('caj.plantel_id', $plantel->id)
                ->whereIn('caj.st_caja_id', array(1, 3))
                ->sum('pagos.monto');
            $totales_otros = Pago::join('cajas as caj', 'caj.id', 'pagos.caja_id')
                ->join('forma_pagos as fm', 'fm.id', 'caj.forma_pago_id')
                ->where('pagos.created_at', '>=', $datos['fecha_f'])
                ->where('pagos.created_at', '<=', $datos['fecha_t'])
                ->where('pagos.forma_pago_id', '<>', 1)
                ->where('bnd_pagado', 1)
                ->where('caj.plantel_id', $plantel->id)
                ->whereIn('caj.st_caja_id', array(1, 3))
                ->sum('pagos.monto');
            $registro['razon'] = $plantel->razon;
            $registro['efectivo'] = $totales_efectivo;
            $registro['resto'] = $totales_otros;
            $registro['suma_total'] = $registro['efectivo'] + $registro['resto'];
            //dd($plantel);
            if ($registro['efectivo'] > 0 and $registro['resto'] > 0) {
                array_push($resultado, $registro);
                array_push($grafica, array('x' => optional($plantel->cuentaP)->name, 'value' => round($registro['suma_total'], 2), 'fill' => $this->randomColor()));
            }

            //dd($grafica);
        }
        //dd($grafica);
        /*
        

        $totales_otros=Pago::select('p.id as plantel_id','p.razon','c.id','c.nombre','c.nombre2', 'c.ape_paterno', 'c.ape_materno',
        'caj.consecutivo','pagos.created_at','pagos.fecha','pagos.monto', 'fm.id as forma_pago_id',
        'fm.name as forma_pago')
        ->join('cajas as caj', 'caj.id','pagos.caja_id')
        ->join('forma_pagos as fm', 'fm.id', 'caj.forma_pago_id')
        ->join('plantels as p','p.id','caj.plantel_id')
        //->join('caja_lns as cln','cln.caja_id','caj.id' )
        ->join('clientes as c','c.id','caj.cliente_id')
        ->where('pagos.created_at','>=', $datos['fecha_f'])
        ->where('pagos.created_at','<=', $datos['fecha_t'])
        ->where('pagos.forma_pago_id',"<>",1)
        ->where('bnd_pagado',1)
        ->whereIn('caj.st_caja_id',array(1,3))
        ->orderBy('p.razon')
        ->orderBy('pagos.fecha')
        ->get();

        }
        
        */
        //dd($totales->toArray());
        /*
        $resultado=array();
        $registro=array();
        $formas_pago=FormaPago::where('id','>',0)->get();
        
        foreach($planteles as $plantel){
            $registro['razon']=$plantel->razon;
            $sumaTotal=0;
            $sumaEfectivo=0;
            $sumaResto=0;
            foreach($formas_pago as $forma_pago){
                
                foreach($totales as $total){
                    if($forma_pago->id==1 and $plantel->id==$total->plantel_id){
                        $sumaEfectivo=$sumaEfectivo+$total->monto;
                        $sumaTotal=$sumaTotal+$total->monto;
                    }elseif($forma_pago->id<>1 and $plantel->id==$total->plantel_id){
                        $sumaResto=$sumaResto+$total->monto;
                        $sumaTotal=$sumaTotal+$total->monto;
                    }
                }
                $registro['efectivo']=$sumaEfectivo;
                $registro['resto']=$sumaResto;
            }
            $registro['suma_total']=$sumaTotal;
            array_push($resultado, $registro);
        }
        //dd($resultado);
        */
        return view('adeudos.reportes.ingresosTotalesR', compact('formas_pago', 'resultado', 'grafica'));
    }

    /*public function ingresosTotalesR(Request $request)
    {
        $datos = $request->all();
        //dd($datos);
        $hoy = Carbon::createFromFormat('Y-m-d', Date('Y-m-d'));
        $lineas_procesadas = array();
        $lineas_detalle = array();
        $planteles=Plantel::where('id','>',1)->get();
        
        $totales=Pago::select('p.id as plantel_id','p.razon','c.id','c.nombre','c.nombre2', 'c.ape_paterno', 'c.ape_materno',
        'caj.consecutivo','pagos.created_at','pagos.fecha','pagos.monto', 'fm.id as forma_pago_id',
        'fm.name as forma_pago')
        ->join('cajas as caj', 'caj.id','pagos.caja_id')
        ->join('forma_pagos as fm', 'fm.id', 'caj.forma_pago_id')
        ->join('plantels as p','p.id','caj.plantel_id')
        //->join('caja_lns as cln','cln.caja_id','caj.id' )
        ->join('clientes as c','c.id','caj.cliente_id')
        ->where('pagos.created_at','>=', $datos['fecha_f'])
        ->where('pagos.created_at','<=', $datos['fecha_t'])
        ->where('bnd_pagado',1)
        ->whereIn('caj.st_caja_id',array(1,3))
        ->orderBy('p.razon')
        ->orderBy('pagos.fecha')
        ->get();
        //dd($totales->toArray());
        $resultado=array();
        $registro=array();
        $formas_pago=FormaPago::where('id','>',0)->get();
        
        foreach($planteles as $plantel){
            $registro['razon']=$plantel->razon;
            $sumaTotal=0;
            $sumaEfectivo=0;
            $sumaResto=0;
            foreach($formas_pago as $forma_pago){
                
                foreach($totales as $total){
                    if($forma_pago->id==1 and $plantel->id==$total->plantel_id){
                        $sumaEfectivo=$sumaEfectivo+$total->monto;
                        $sumaTotal=$sumaTotal+$total->monto;
                    }elseif($forma_pago->id<>1 and $plantel->id==$total->plantel_id){
                        $sumaResto=$sumaResto+$total->monto;
                        $sumaTotal=$sumaTotal+$total->monto;
                    }
                }
                $registro['efectivo']=$sumaEfectivo;
                $registro['resto']=$sumaResto;
            }
            $registro['suma_total']=$sumaTotal;
            array_push($resultado, $registro);
        }
        //dd($resultado);

        return view('adeudos.reportes.ingresosTotalesR', compact('formas_pago', 'resultado', 'totales'));
    }*/

    public function ingresosTotalesDetalle(Request $request)
    {
        $datos = $request->all();
        //dd($datos);
        $data = $datos['datos'];
        $formas_pago = array('efectivo' . "-" . $datos['datos']['efectivo'], 'resto' . "-" . $datos['datos']['resto'], 'suma_total' . "-" . $datos['datos']['suma_total']);
        $data = array(
            'efectivo' . "-" . $datos['datos']['efectivo'] => $datos['datos']['efectivo'],
            'resto' . "-" . $datos['datos']['resto'] => $datos['datos']['resto'],
            'suma_total' . "-" . $datos['datos']['suma_total'] => $datos['datos']['suma_total']
        );
        $plantel = $datos['datos']['razon'];

        $data = json_encode(Arr::except($data, ['razon']));
        $formas_pago = json_encode($formas_pago);
        //dd($formas_pago);

        return view('adeudos.reportes.ingresosTotalesDetalle', compact('formas_pago', 'data', 'plantel'));
    }

    function randomColor()
    {
        $str = "#";
        for ($i = 0; $i < 6; $i++) {
            $randNum = rand(0, 15);
            switch ($randNum) {
                case 10:
                    $randNum = "A";
                    break;
                case 11:
                    $randNum = "B";
                    break;
                case 12:
                    $randNum = "C";
                    break;
                case 13:
                    $randNum = "D";
                    break;
                case 14:
                    $randNum = "E";
                    break;
                case 15:
                    $randNum = "F";
                    break;
            }
            $str .= $randNum;
        }
        return $str;
    }

    public function adeudosXConcepto()
    {
        if (Auth::user()->can('adeudos.maestroXPlantel')) {
            $empleado = Empleado::where('user_id', Auth::user()->id)->first();
            $planteles = array();
            foreach ($empleado->plantels as $p) {
                //dd($p->id);
                array_push($planteles, $p->id);
            }

            $planteles = Plantel::whereIn('id', $planteles)->pluck('razon', 'id');
        } else {
            $planteles = Plantel::pluck('razon', 'id');
        }

        $conceptos = CajaConcepto::pluck('name', 'id');
        $agrupamientoPlantels = PlantelAgrupamiento::pluck('name', 'id');
        $agrupamientoPlantels->prepend('Seleccionar Opcion', 0);

        //dd($stCajas);
        return view('adeudos.reportes.adeudosXConcepto', compact('planteles', 'conceptos', 'agrupamientoPlantels'));
    }

    public function adeudosXConceptoR(Request $request)
    {
        $datos = $request->all();

        $secciones = Adeudo::select('p.razon', 'p.id as plantel_id', 'g.seccion')
            ->join('clientes as c', 'c.id', 'adeudos.cliente_id')
            ->join('combinacion_clientes as comb', 'comb.cliente_id', 'c.id')
            ->join('grados as g', 'g.id', 'comb.grado_id')
            ->join('plantels as p', 'p.id', 'c.plantel_id')
            ->join('caja_conceptos as cc', 'cc.id', 'adeudos.caja_concepto_id')
            ->whereIn('c.plantel_id', $datos['plantel_f'])
            ->where('adeudos.caja_concepto_id', $datos['concepto_f'])
            ->whereRaw('year(adeudos.fecha_pago)=?', [$datos['fecha_f']])
            ->distinct()
            ->orderBy('p.id')
            ->orderBy('g.seccion')
            ->get();

        $totales = array();

        $totales_no_pagados = array();

        foreach ($secciones as $seccion) {
            //dd($seccion);
            $linea = array();
            $linea['plantel'] = $seccion->razon;
            $linea['seccion'] = $seccion->seccion;
            $calculo = Adeudo::select('adeudos.caja_concepto_id')
                ->join('clientes as c', 'c.id', 'adeudos.cliente_id')
                ->join('combinacion_clientes as comb', 'comb.cliente_id', 'c.id')
                ->join('grados as g', 'g.id', 'comb.grado_id')
                ->join('plantels as p', 'p.id', 'c.plantel_id')
                ->join('caja_conceptos as cc', 'cc.id', 'adeudos.caja_concepto_id')
                ->where('c.plantel_id', $seccion->plantel_id)
                ->where('adeudos.caja_concepto_id', $datos['concepto_f'])
                ->where('adeudos.pagado_bnd', 1)
                ->where('g.seccion', $seccion->seccion)
                ->whereRaw('year(adeudos.fecha_pago)=?', [$datos['fecha_f']])
                ->whereNull('comb.deleted_at')
                ->distinct()
                ->count();
            $linea['total_pagados'] = $calculo;
            $calculo = Adeudo::select('adeudos.caja_concepto_id')
                ->join('clientes as c', 'c.id', 'adeudos.cliente_id')
                ->join('combinacion_clientes as comb', 'comb.cliente_id', 'c.id')
                ->join('grados as g', 'g.id', 'comb.grado_id')
                ->join('plantels as p', 'p.id', 'c.plantel_id')
                ->join('caja_conceptos as cc', 'cc.id', 'adeudos.caja_concepto_id')
                ->where('c.plantel_id', $seccion->plantel_id)
                ->where('adeudos.caja_concepto_id', $datos['concepto_f'])
                ->where('adeudos.pagado_bnd', "<>", 1)
                ->where('g.seccion', $seccion->seccion)
                ->whereRaw('year(adeudos.fecha_pago)=?', [$datos['fecha_f']])
                ->whereNull('comb.deleted_at')
                ->distinct()
                ->count();
            $linea['total_no_pagados'] = $calculo;
            array_push($totales, $linea);
        }

        //dd($totales);

        $detalle = Adeudo::select(
            'c.id as cliente_id',
            'c.nombre',
            'c.nombre2',
            'c.ape_paterno',
            'c.ape_materno',
            'c.matricula',
            'p.razon',
            'g.seccion',
            'cc.name as concepto',
            'adeudos.pagado_bnd',
            'adeudos.monto',
            'caj.total',
            'caj.fecha as caja_fecha',
            'stc.name as estatus',
            't.name as turno'
        )
            ->join('clientes as c', 'c.id', 'adeudos.cliente_id')
            ->join('st_clientes as stc', 'stc.id', 'c.st_cliente_id')
            ->join('combinacion_clientes as comb', 'comb.cliente_id', 'c.id')
            ->join('turnos as t', 't.id', 'comb.turno_id')
            ->join('grados as g', 'g.id', 'comb.grado_id')
            ->join('plantels as p', 'p.id', 'c.plantel_id')
            ->join('caja_conceptos as cc', 'cc.id', 'adeudos.caja_concepto_id')
            ->whereIn('c.plantel_id', $datos['plantel_f'])
            ->where('adeudos.caja_concepto_id', $datos['concepto_f'])
            ->whereRaw('year(adeudos.fecha_pago)=?', [$datos['fecha_f']])
            ->whereNull('comb.deleted_at')
            ->leftJoin('cajas as caj', 'caj.id', 'adeudos.caja_id')
            ->orderBy('p.id')
            ->orderBy('g.seccion')
            ->orderBy('c.id')
            ->get();
        //dd($adeudos);

        return view('adeudos.reportes.adeudosXConceptoR', compact('totales', 'detalle'));
    }

    public function adeudosXConceptoAlMes()
    {
        if (Auth::user()->can('adeudos.maestroXPlantel')) {
            $empleado = Empleado::where('user_id', Auth::user()->id)->first();
            $planteles = array();
            foreach ($empleado->plantels as $p) {
                //dd($p->id);
                array_push($planteles, $p->id);
            }

            $planteles = Plantel::whereIn('id', $planteles)->pluck('razon', 'id');
        } else {
            $planteles = Plantel::pluck('razon', 'id');
        }

        $conceptos = CajaConcepto::pluck('name', 'id');

        $agrupamientoPlantels = PlantelAgrupamiento::pluck('name', 'id');
        $agrupamientoPlantels->prepend('Seleccionar Opcion', 0);
        //dd($stCajas);
        return view('adeudos.reportes.adeudosXConceptoAlMes', compact('planteles', 'conceptos', 'agrupamientoPlantels'));
    }

    public function adeudosXConceptoAlMesR(Request $request)
    {
        $datos = $request->all();

        $fecha = Carbon::createFromFormat('Y-m-d', $datos['fecha_f']);
        //dd($fecha);

        $secciones = Adeudo::select('p.razon', 'p.id as plantel_id', 'g.seccion')
            ->join('clientes as c', 'c.id', 'adeudos.cliente_id')
            ->join('combinacion_clientes as comb', 'comb.cliente_id', 'c.id')
            ->join('grados as g', 'g.id', 'comb.grado_id')
            ->join('plantels as p', 'p.id', 'c.plantel_id')
            ->join('caja_conceptos as cc', 'cc.id', 'adeudos.caja_concepto_id')
            ->whereIn('c.plantel_id', $datos['plantel_f'])
            ->where('adeudos.caja_concepto_id', $datos['concepto_f'])
            ->whereRaw('year(adeudos.fecha_pago)=?', [$fecha->year])
            //->whereRaw('year(adeudos.fecha_pago)<=?', [$datos['fecha_f']])
            ->distinct()
            ->orderBy('p.id')
            ->orderBy('g.seccion')
            ->get();

        //dd($secciones);

        $totales = array();

        $totales_no_pagados = array();

        foreach ($secciones as $seccion) {
            //dd($seccion);
            $linea = array();
            $linea['plantel'] = $seccion->razon;
            $linea['seccion'] = $seccion->seccion;
            $calculo = Adeudo::select('adeudos.caja_concepto_id')
                ->join('clientes as c', 'c.id', 'adeudos.cliente_id')
                ->join('combinacion_clientes as comb', 'comb.cliente_id', 'c.id')
                ->join('grados as g', 'g.id', 'comb.grado_id')
                ->join('plantels as p', 'p.id', 'c.plantel_id')
                ->join('caja_conceptos as cc', 'cc.id', 'adeudos.caja_concepto_id')
                ->join('cajas as caj', 'caj.id', 'adeudos.caja_id')
                //->join('pagos as pag','pag.caja_id','caj.id')
                ->where('c.plantel_id', $seccion->plantel_id)
                ->where('adeudos.caja_concepto_id', $datos['concepto_f'])
                ->where('adeudos.pagado_bnd', 1)
                ->where('g.seccion', $seccion->seccion)
                ->whereNull('comb.deleted_at')
                ->whereRaw('year(adeudos.fecha_pago)=?', [$fecha->year])
                ->whereRaw('caj.fecha<=?', [$datos['fecha_f']])
                ->distinct()
                ->count();
            $linea['total_pagados'] = $calculo;
            $calculo = Adeudo::select('adeudos.caja_concepto_id')
                ->join('clientes as c', 'c.id', 'adeudos.cliente_id')
                ->join('combinacion_clientes as comb', 'comb.cliente_id', 'c.id')
                ->join('grados as g', 'g.id', 'comb.grado_id')
                ->join('plantels as p', 'p.id', 'c.plantel_id')
                ->join('caja_conceptos as cc', 'cc.id', 'adeudos.caja_concepto_id')
                ->where('c.plantel_id', $seccion->plantel_id)
                ->where('adeudos.caja_concepto_id', $datos['concepto_f'])
                ->where('adeudos.pagado_bnd', "<>", 1)
                ->where('g.seccion', $seccion->seccion)
                ->whereRaw('year(adeudos.fecha_pago)=?', [$fecha->year])
                ->whereNull('comb.deleted_at')
                //->whereRaw('year(adeudos.fecha_pago)<=?', [$datos['fecha_f']])
                ->distinct()
                ->count();
            $linea['total_no_pagados'] = $calculo;
            array_push($totales, $linea);
        }

        //dd($totales);

        $detalle_lineas = Adeudo::select(
            'c.id as cliente_id',
            'c.nombre',
            'c.nombre2',
            'c.ape_paterno',
            'c.ape_materno',
            'c.matricula',
            'p.razon',
            'g.seccion',
            'cc.name as concepto',
            'adeudos.pagado_bnd',
            'adeudos.monto',
            'caj.total',
            'caj.fecha as caja_fecha',
            'stc.name as estatus',
            't.name as turno'
        )
            ->join('clientes as c', 'c.id', 'adeudos.cliente_id')
            ->join('st_clientes as stc', 'stc.id', 'c.st_cliente_id')
            ->join('combinacion_clientes as comb', 'comb.cliente_id', 'c.id')
            ->join('turnos as t', 't.id', 'comb.turno_id')
            ->join('grados as g', 'g.id', 'comb.grado_id')
            ->join('plantels as p', 'p.id', 'c.plantel_id')
            ->join('caja_conceptos as cc', 'cc.id', 'adeudos.caja_concepto_id')
            ->leftJoin('cajas as caj', 'caj.id', 'adeudos.caja_id')
            //->leftJoin('pagos as pag','pag.caja_id','caj.id')
            ->whereIn('c.plantel_id', $datos['plantel_f'])
            ->where('adeudos.caja_concepto_id', $datos['concepto_f'])
            ->whereRaw('year(adeudos.fecha_pago)=?', [$fecha->year])
            //->leftJoin('cajas as caj','caj.id','adeudos.caja_id')
            ->whereNull('comb.deleted_at')
            ->orderBy('p.id')
            ->orderBy('g.seccion')
            ->orderBy('c.id')
            ->get();

        $detalle = array();
        foreach ($detalle_lineas as $linea) {
            if (isset($linea->caja_fecha) and Carbon::createFromFormat('Y-m-d', $linea->caja_fecha)->lessThanOrEqualTo($fecha)) {
                array_push($detalle, $linea->toArray());
            } elseif (!isset($linea->caja_fecha) and $linea->pagado_bnd == 0) {
                array_push($detalle, $linea->toArray());
            }
        }
        //dd($detalle);

        return view('adeudos.reportes.adeudosXConceptoAlMesR', compact('totales', 'detalle'));
    }
}
