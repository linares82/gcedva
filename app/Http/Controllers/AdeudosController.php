<?php

namespace App\Http\Controllers;

use App\Adeudo;
use App\Caja;
use App\CajaConcepto;
use App\CajaLn;
use App\Cliente;
use App\CombinacionCliente;
use App\Empleado;
use App\HistoriaCliente;
use App\Http\Controllers\Controller;
use App\Http\Requests\createAdeudo;
use App\Http\Requests\updateAdeudo;
use App\Pago;
use App\PlanPago;
use App\PlanPagoLn;
use App\Plantel;
use App\PromoPlanLn;
use App\ReglaRecargo;
use App\Seguimiento;
use App\StCaja;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Log;
use PDF;
use Session;

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
        $input = $request->all();
        //dd($input);
        $input['usu_mod_id'] = Auth::user()->id;
        //update data
        $adeudo = $adeudo->find($id);
        $adeudo->update($input);

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
        $cajas = Caja::select('cajas.consecutivo as caja', 'ln.caja_concepto_id as concepto_id', 'cc.name as concepto', 'ln.total', 'st.name as estatus')
            ->join('caja_lns as ln', 'ln.caja_id', '=', 'cajas.id')
            ->join('caja_conceptos as cc', 'cc.id', '=', 'ln.caja_concepto_id')
            ->join('st_cajas as st', 'st.id', '=', 'cajas.st_caja_id')
            ->where('cliente_id', $caja->cliente->id)
            ->whereNull('cajas.deleted_at')
            ->whereNull('ln.deleted_at')
            ->get();
        $adeudo->delete();

        $cliente = Cliente::find($adeudo->cliente_id);
        $combinaciones = CombinacionCliente::where('cliente_id', '=', $cliente->id)->get();

        return view('cajas.caja', compact('cliente', 'combinaciones', 'caja', 'cajas'))
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

        $adeudos = Adeudo::where('cliente_id', '=', $cliente->id)->where('combinacion_cliente_id', '=', $combinacion->id)->get();
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
        return view('adeudos.reportes.adeudosXPlantel', compact('planteles', 'conceptos'));
    }

    public function reporteAdeudosPendientesr(Request $request)
    {
        $datos = $request->all();

        $fecha = date('Y/m/d');
        //dd($fecha);
        //$empleado=Empleado::where('user_id', '=', Auth::user()->id)->first();

        $plantel = Plantel::find($datos['plantel_f']);
        //dd($plantel);
        /*$adeudosPendientes=Adeudo::select('esp.name as especialidad','n.name as nivel','g.name as grado','c.id as cliente','c.nombre','c.nombre2',
        'c.ape_paterno','c.ape_materno','adeudos.fecha_pago','adeudos.monto')
        ->join('combinacion_clientes as cc','cc.id',"=",'adeudos.combinacion_cliente_id')
        ->join('especialidads as esp','esp.id','=','cc.especialidad_id')
        ->join('nivels as n','n.id','=','cc.nivel_id')
        ->join('grados as g','g.id','=','cc.grado_id')
        ->join('clientes as c', 'c.id', '=', 'adeudos.cliente_id')
        ->where('pagado_bnd', '=', 0)
        ->whereDate('fecha_pago', '<', $fecha)
        ->where('c.plantel_id', '=', session('plantel'))
        ->orderBy('c.id', 'asc')
        ->orderBy('adeudos.combinacion_cliente_id', 'asc')
        //->get();
        ->paginate(100);
         *
         */

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

        $planteles = Plantel::pluck('razon', 'id');
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
        $cliente = Cliente::find($data['cliente']);
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
            //conceptos diferentes de mensualidad, se ignoran los Â´primeros 3
            //if($adeudo->cajaConcepto->bnd_mensualidad<>1 and $descarte_inicial>3){
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
                    Log::info($cliente->id . "FLC:" . $cliente->beca_bnd . "-" . $adeudo->combinacionCliente->bnd_beca);
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
            /*$registros_totales = Adeudo::select(
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
            ->get();*/
            $registros_totales = DB::select('CALL maestroR(?,?,?)', array($plantel, $datos['fecha_f'], $datos['fecha_t']));
            //dd($registros_totales[0]->razon);
            //return view('adeudos.reportes.maestroR', compact('registros_totales'));
            //dd($registros_totales->toArray());

            //dd($conceptos);

            //$calculo = array();
            $calculo = [
                'plantel' => "", 'concepto' => "", 'clientes_activos' => 0, 'clientes_pagados' => 0, 'total_monto_pagado' => 0, 'suma_deudores' => 0,
                'monto_deuda' => 0, 'porcentaje_pagado' => 0, 'deudores' => 0, 'bajas_pagadas' => 0, 'porcentaje_deudores' => 0,
            ];

            foreach ($registros_totales as $registro) {
                array_push($lineas_detalle, (array) $registro);
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
                    /*$baja = HistoriaCliente::where('cliente_id', $registro->id)
                    ->where('evento_cliente_id', 2)
                    ->where('fecha', '>=', $datos['fecha_f'])
                    ->where('fecha', '<=', $datos['fecha_t'])
                    ->first();*/
                    $baja = DB::select('CALL maestroRHistoriaCliente(?,?,?)', array($registro->id, $datos['fecha_f'], $datos['fecha_t']));
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
                    'plantel' => "", 'concepto' => $concepto, 'clientes_activos' => 0, 'clientes_pagados' => 0, 'total_monto_pagado' => 0, 'suma_deudores' => 0,
                    'monto_deuda' => 0, 'porcentaje_pagado' => 0, 'deudores' => 0, 'bajas_pagadas' => 0, 'porcentaje_deudores' => 0,
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
                            /*$baja = HistoriaCliente::where('cliente_id', $registro->id)
                            ->where('evento_cliente_id', 2)
                            ->where('fecha', '>=', $datos['fecha_f'])
                            ->where('fecha', '<=', $datos['fecha_t'])
                            ->first();
                             */
                            $baja = DB::select('CALL maestroRHistoriaCliente(?,?,?)', array($registro->id, $datos['fecha_f'], $datos['fecha_t']));
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

        return view('adeudos.reportes.maestroR', compact('lineas_procesadas', 'pagos', 'lineas_detalle', 'datos'));
    }

    public function maestroIndicador(Request $request)
    {
        $datos = $request->all();

        //dd($datos);
        $lineas_procesadas = array();

        $mesActual = Carbon::createFromFormat('Y-m-d', Date('Y-m-d'))->month;
        $yearActual = Carbon::createFromFormat('Y-m-d', Date('Y-m-d'))->year;
        //dd($mesActual);
        $lineas_detalle = array();
        //foreach ($datos['plantel_f'] as $plantel) {
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
            //'pag.monto as monto_pago'
        )
            ->join('clientes as c', 'c.id', '=', 'adeudos.cliente_id')
            ->join('st_clientes as stc', 'stc.id', '=', 'c.st_cliente_id')
            ->join('seguimientos as s', 's.cliente_id', '=', 'c.id')
            ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
            ->join('plantels as p', 'p.id', '=', 'c.plantel_id')
            ->leftJoin('caja_lns as cln', 'cln.adeudo_id', '=', 'adeudos.id')
            ->leftJoin('cajas as caj', 'caj.id', '=', 'adeudos.caja_id')
            ->join('caja_conceptos as cc', 'cc.id', '=', 'adeudos.caja_concepto_id')
            ->where('c.plantel_id', $datos['plantel'])
            ->whereIn('c.st_cliente_id', array(3, 4, 20, 23, 24, 25))
            ->whereMonth('adeudos.fecha_pago', $mesActual)
            ->whereYear('adeudos.fecha_pago', $yearActual)
            //->whereDate('adeudos.fecha_pago', '>=', $datos['fecha_f'])
            //->whereDate('adeudos.fecha_pago', '<=', $datos['fecha_t'])
            ->whereNull('adeudos.deleted_at')
            ->whereNull('s.deleted_at')
            ->orderBy('p.id')
            ->orderBy('adeudos.caja_concepto_id')
            ->orderBy('c.id')
            //->orderBy('caj.id')
            ->get();

        //$calculo = array();
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
                    /*$query_pagos = Pago::where('caja_id', $registro->caja)->where('caja_id', '>', 0)->whereNull('pagos.deleted_at')->get();
                foreach ($query_pagos as $pago) {
                if ($pago->forma_pago_id == 1 and $pago->monto >= $registro->pago_calculado_adeudo) {
                //$calculo['pagos_efectivo'] = $calculo['pagos_efectivo'] + $registro->pago_calculado_adeudo;
                } elseif ($pago->forma_pago_id <> 1 and $pago->monto >= $registro->pago_calculado_adeudo) {
                //$calculo['pagos_banco'] = $calculo['pagos_banco'] + $registro->pago_calculado_adeudo;
                }
                }*/
                } elseif ($registro->pagado_bnd == 0) {
                    $calculo['suma_deudores'] = $calculo['suma_deudores'] + 1;
                    $calculo['monto_deuda'] = $calculo['monto_deuda'] + $registro->adeudo_planeado;
                }
                $calculo['porcentaje_pagado'] = ($calculo['clientes_pagados'] * 100) / $calculo['clientes_activos'];
                $calculo['deudores'] = $calculo['clientes_activos'] - $calculo['clientes_pagados'];
                $calculo['porcentaje_deudores'] = ($calculo['deudores'] * 100) / $calculo['clientes_activos'];
            } /*elseif (is_null($registro->borrado_c) and is_null($registro->borrado_cln) and $registro->st_cliente_id == 3) {
        $baja = HistoriaCliente::where('cliente_id', $registro->id)
        ->where('evento_cliente_id', 2)
        ->where('fecha', '>=', $datos['fecha_f'])
        ->where('fecha', '<=', $datos['fecha_t'])
        ->first();
        if (is_object($baja) and $registro->caja > 0) {
        $calculo['bajas_pagadas'] = $calculo['bajas_pagadas'] + 1;
        }
        }*/
        }
        array_push($lineas_procesadas, $calculo);
        //}
        //dd($lineas_procesadas);
        return json_encode(round($calculo['porcentaje_pagado'], 2));

        //return view('adeudos.reportes.maestroR', compact('lineas_procesadas', 'pagos', 'lineas_detalle','datos'));
    }

    public function maestroIndicadorDetalle(Request $request)
    {
        $datos = $request->all();
        //dd($datos);
        $mesActual = Carbon::createFromFormat('Y-m-d', Date('Y-m-d'))->month;
        $yearActual = Carbon::createFromFormat('Y-m-d', Date('Y-m-d'))->year;

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
                //'pag.monto as monto_pago'
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
                ->whereMonth('adeudos.fecha_pago', $mesActual)
                ->whereYear('adeudos.fecha_pago', $yearActual)
                ->whereNull('adeudos.deleted_at')
                ->whereNull('s.deleted_at')
                ->orderBy('p.id')
                ->orderBy('adeudos.caja_concepto_id')
                ->orderBy('c.id')
                //->orderBy('caj.id')
                ->get();

            //dd($conceptos);

            //$calculo = array();
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
                    'plantel' => "", 'concepto' => $concepto, 'clientes_activos' => 0, 'clientes_pagados' => 0, 'total_monto_pagado' => 0, 'suma_deudores' => 0,
                    'monto_deuda' => 0, 'porcentaje_pagado' => 0, 'deudores' => 0, 'bajas_pagadas' => 0, 'porcentaje_deudores' => 0,
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
        }
        //dd($lineas_detalle);

        return view('adeudos.reportes.maestroR', compact('lineas_procesadas', 'pagos', 'lineas_detalle', 'datos'));
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
}
