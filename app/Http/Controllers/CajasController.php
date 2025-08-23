<?php

namespace App\Http\Controllers;

use DB;
use Log;
use Auth;
use Mail;
use Session;
use App\Caja;
use App\Pago;
use App\Param;
use Exception;
use App\Adeudo;
use App\BsBaja;
use App\CajaLn;
use App\Cliente;
use App\Plantel;
use App\Empleado;
use Carbon\Carbon;
use App\PromoPlanLn;
use App\CajaConcepto;
use App\CuentasEfectivo;
use App\AdeudoPagoOnLine;
use App\AutorizacionBeca;
use App\CombinacionCliente;
use Illuminate\Http\Request;
use App\Http\Requests\createCaja;
use App\Http\Requests\updateCaja;
use App\Http\Controllers\Controller;
use App\valenceSdk\samples\BasicSample\UsoApi;

class CajasController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $cajas = Caja::getAllData($request);

        return view('cajas.index', compact('cajas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {

        return view('cajas.create')
            ->with('list', Caja::getListFromAllRelationApps());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(createCaja $request)
    {
        $input = $request->all();
        //dd($input);
        if (!isset($input['fecha'])) {
            $input['fecha'] = Date('Y-m-d');
        }
        $hoy = Carbon::createFromFormat('Y-m-d', Date('Y-m-d'));
        $fecha_caja = Carbon::createFromFormat('Y-m-d', $input['fecha']);
        //dd($input);
        if ($input['forma_pago_id'] == 0) {
            Session::flash('msj', 'Forma Pago Vacia');
            return redirect()->route('cajas.caja')
                ->withInput();
        } elseif ($fecha_caja->greaterThan($hoy)) {
            Session::flash('msj', 'Fecha de caja no puede ser mayor a la del dia de hoy');
            return redirect()->route('cajas.caja')
                ->withInput();
        }


        //dd($input);
        $cliente = Cliente::find($input['cliente_id']);

        $caja = Caja::select('cajas.id', 'cajas.consecutivo', 'p.razon', 'cajas.cliente_id', 'pag.bnd_referenciado')
            ->where('st_caja_id', 0)
            ->leftJoin('pagos as pag', 'pag.caja_id', '=', 'cajas.id')
            ->join('plantels as p', 'p.id', '=', 'cajas.plantel_id')
            ->where('plantel_id', $cliente->plantel_id)
            ->get();
        $caja_filtrada = $caja->whereIn('bnd_referenciado', [NULL, 0]);
        $caja_filtrada->all();
        //dd($caja_filtrada);

        //de los registros conestatus invalido se busca uno pagado
        $caja_pagada = 0;
        foreach ($caja_filtrada as $r_filtrado) {
            $buscar_caja_pagada = Caja::find($r_filtrado->id);
            if ($buscar_caja_pagada->st_caja_id == 1) {
                $caja_pagada = 1;
            }
        }

        $cajas = Caja::select('cajas.consecutivo as caja', 'cajas.fecha', 'ln.caja_concepto_id as concepto_id', 'cc.name as concepto', 'ln.total', 'st.name as estatus', 'ln.adeudo_id')
            ->join('caja_lns as ln', 'ln.caja_id', '=', 'cajas.id')
            ->join('caja_conceptos as cc', 'cc.id', '=', 'ln.caja_concepto_id')
            ->join('st_cajas as st', 'st.id', '=', 'cajas.st_caja_id')
            ->where('cliente_id', $cliente->id)
            ->where('ln.adeudo_id', '0')
            ->whereNull('cajas.deleted_at')
            ->whereNull('ln.deleted_at')
            ->get();




        //dd($caja);
        if (count($caja_filtrada) > 0 and $caja_pagada == 0) {
            $ids_invalidos = $caja_filtrada->toArray();
            /*Caja::select('cajas.consecutivo', 'p.razon', 'cajas.cliente_id', 'pag.bnd_referenciado')
                ->join('plantels as p', 'p.id', '=', 'cajas.plantel_id')
                ->leftJoin('pagos as pag', 'pag.caja_id', '=', 'cajas.id')
                ->where('plantel_id', $cliente->plantel_id)
                ->where('cajas.st_caja_id', '=', 0)
                ->where('cajas.id', '>', 0)
                //->where('pag.bnd_referenciado', '<>', 1)
                ->get();*/
            //dd($ids_invalidos);

            Session::flash('ids_invalidos', $ids_invalidos);
            //dd(session('ids_invalidos'));
            return redirect()->route('cajas.caja')
                ->withInput();
        }
        //}

        $empleado = Empleado::where('user_id', '=', Auth::user()->id)->first();

        $cliente = Cliente::find($input['cliente_id']);
        $plantel = Plantel::find($cliente->plantel_id);

        $caja_r['cliente_id'] = $cliente->id;
        $caja_r['plantel_id'] = $cliente->plantel_id;
        $caja_r['forma_pago_id'] = $input['forma_pago_id'];
        $caja_r['fecha'] = $input['fecha'];
        $caja_r['subtotal'] = 0;
        $caja_r['descuento'] = 0;
        $caja_r['recargo'] = 0;

        $caja_r['total'] = 0;
        $caja_r['st_caja_id'] = 0;

        if (isset($input['bnd_sin_reactivacion'])) {
            $caja_r['bnd_sin_reactivacion'] = $input['bnd_sin_reactivacion'];
        } else {
            $caja_r['bnd_sin_reactivacion'] = 0;
        }

        $caja_r['usu_alta_id'] = Auth::user()->id;
        $caja_r['usu_mod_id'] = Auth::user()->id;
        //$plantel->consecutivo = $plantel->consecutivo + 1;
        //$plantel->save();
        $caja_r['consecutivo'] = ++$plantel->consecutivo;
        $plantel->save();

        //dd($caja_r);
        $caja = Caja::create($caja_r);


        $empleados = Empleado::select(DB::raw('concat(nombre," ",ape_paterno," ",ape_materno) as name, id'))->pluck('name', 'id');

        $combinaciones = CombinacionCliente::where('cliente_id', '=', $caja->cliente_id)->get();

        return view('cajas.caja', compact('cliente', 'caja', 'combinaciones', 'cajas', 'empleados'))
            ->with('list', Caja::getListFromAllRelationApps())
            ->with('list1', CajaLn::getListFromAllRelationApps());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id, Caja $caja)
    {
        $caja = $caja->find($id);
        return view('cajas.show', compact('caja'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id, Caja $caja)
    {
        $caja = $caja->find($id);
        $cliente = Cliente::find($caja->cliente_id);
        $cajas = Caja::select('cajas.consecutivo as caja', 'cajas.fecha', 'ln.caja_concepto_id as concepto_id', 'cc.name as concepto', 'ln.total', 'st.name as estatus', 'ln.adeudo_id')
            ->join('caja_lns as ln', 'ln.caja_id', '=', 'cajas.id')
            ->join('caja_conceptos as cc', 'cc.id', '=', 'ln.caja_concepto_id')
            ->join('st_cajas as st', 'st.id', '=', 'cajas.st_caja_id')
            ->where('cliente_id', $cliente->id)
            ->where('ln.adeudo_id', '0')
            ->whereNull('cajas.deleted_at')
            ->whereNull('ln.deleted_at')
            ->get();
        $combinaciones = CombinacionCliente::where('cliente_id', '=', $caja->cliente_id)->get();
        $empleados = Empleado::select(DB::raw('concat(nombre," ",ape_paterno," ",ape_materno) as name, id'))->pluck('name', 'id');

        return view('cajas.caja', compact('caja', 'cliente', 'combinaciones', 'cajas', 'empleados'))
            ->with('list', Caja::getListFromAllRelationApps())
            ->with('list1', CajaLn::getListFromAllRelationApps());
    }

    /**
     * Show the form for duplicatting the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function duplicate($id, Caja $caja)
    {
        $caja = $caja->find($id);
        return view('cajas.duplicate', compact('caja'))
            ->with('list', Caja::getListFromAllRelationApps());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param Request $request
     * @return Response
     */
    public function update($id, Caja $caja, updateCaja $request)
    {
        $input = $request->all();
        $input['usu_mod_id'] = Auth::user()->id;
        //update data
        $caja = $caja->find($id);
        $caja->update($input);

        return redirect()->route('cajas.index')->with('message', 'Registro Actualizado.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id, Caja $caja)
    {
        $caja = $caja->find($id);
        $caja->usu_delete_id = Auth::user()->id;
        $caja->save();
        $caja->delete();

        return redirect()->route('cajas.index')->with('message', 'Registro Borrado.');
    }

    public function getCaja(Request $request)
    {
        $datos = $request->all();
        if (isset($datos['plantel']) and isset($datos['consecutivo'])) {
            $vplantel = $datos['plantel'];
            $vconsecutivo = $datos['consecutivo'];
            return view('cajas.caja', compact('vplantel', 'vconsecutivo'))->with('list', Caja::getListFromAllRelationApps())->with('list1', CajaLn::getListFromAllRelationApps());
        } else {
            return view('cajas.caja')->with('list', Caja::getListFromAllRelationApps())->with('list1', CajaLn::getListFromAllRelationApps());
        }
    }

    public function buscarCliente(Request $request)
    {
        //$empleado = Empleado::where('user_id', Auth::user()->id)->first();
        $planteles = Empleado::where('user_id', '=', Auth::user()->id)->first()->plantels->pluck('id')->toArray();
        /*
        $planteles = array();
        foreach ($empleado->plantels as $p) {
            array_push($planteles, $p->id);
        }*/
        //dd($planteles);

        $empleados = Empleado::select(DB::raw('concat(nombre," ",ape_paterno," ",ape_materno) as name, id'))->pluck('name', 'id');

        //dd($empleados);
        $cliente = Cliente::where('id', $request['cliente_id'])->whereIn('plantel_id', $planteles)->first();
        if (!is_object($cliente)) {
            Session::flash('msj', 'Cliente no existe');
            return view('cajas.caja', compact('empleados'))->with('list', Caja::getListFromAllRelationApps())->with('list1', CajaLn::getListFromAllRelationApps());
        }
        //$adeudos=Adeudo::where('cliente_id', '=', $cliente->id)->get();
        //dd($cliente);
        $combinaciones = CombinacionCliente::where('cliente_id', '=', $cliente->id)->whereNull('deleted_at')->get();
        if ($combinaciones->count() == 0) {
            Session::flash('msj', 'Cliente sin combinacion definida');
            return view('cajas.caja', compact('empleados'))->with('list', Caja::getListFromAllRelationApps())->with('list1', CajaLn::getListFromAllRelationApps());
        }

        $cajas = Caja::select(
            'cajas.consecutivo as caja',
            'cajas.fecha',
            'ln.caja_concepto_id as concepto_id',
            'cc.name as concepto',
            'ln.total',
            'st.name as estatus',
            'ln.adeudo_id'
        )
            ->join('caja_lns as ln', 'ln.caja_id', '=', 'cajas.id')
            ->join('caja_conceptos as cc', 'cc.id', '=', 'ln.caja_concepto_id')
            ->join('st_cajas as st', 'st.id', '=', 'cajas.st_caja_id')
            ->where('cliente_id', $cliente->id)
            ->where('ln.adeudo_id', 0)
            ->whereNull('cajas.deleted_at')
            ->whereNull('ln.deleted_at')
            ->get();
        //dd($cajas->toArray());
        /*foreach($combinaciones as $c){
        dd($c->adeudos);
        }*/
        //dd($combinaciones);
        //dd(Caja::getListFromAllRelationApps());
        //dd("fil");
        $permiso_caja_buscarCliente = Auth::user()->can('permiso_caja_buscarCliente');
        //dd($permiso_caja_buscarCliente);
        //dd($planteles);
        //dd($cliente->plantel_id);
        //dd(array_search($cliente->plantel_id, $planteles) <> false);
        //dd(array_search($cliente->plantel_id, $planteles));
        if (
            is_object($cliente) and
            count($combinaciones) > 0 and
            array_search($cliente->plantel_id, $planteles) <> false
        ) {

            return view('cajas.caja', compact('cliente', 'combinaciones', 'cajas', 'empleados'))
                ->with('list', Caja::getListFromAllRelationApps())
                ->with('list1', CajaLn::getListFromAllRelationApps());
        } elseif (
            is_object($cliente) and
            count($combinaciones) > 0 and
            array_search($cliente->plantel_id, $planteles) == false and
            $permiso_caja_buscarCliente
        ) {

            return view('cajas.caja', compact('cliente', 'combinaciones', 'cajas', 'empleados'))
                ->with('list', Caja::getListFromAllRelationApps())
                ->with('list1', CajaLn::getListFromAllRelationApps());
        }
        Session::flash('msj', 'Cliente buscado pertenece a otro plantel');
        return view('cajas.caja', compact('empleados'))->with('list', Caja::getListFromAllRelationApps())->with('list1', CajaLn::getListFromAllRelationApps());
    }

    public function buscarVenta(Request $request)
    {
        $data = $request->all();
        //dd($data);
        $empleado = Empleado::where('user_id', '=', Auth::user()->id)->first();
        $planteles = array();
        array_push($planteles, 0);
        foreach ($empleado->plantels as $p) {
            //dd($p->id);
            array_push($planteles, $p->id);
        }

        $empleados = Empleado::select(DB::raw('concat(nombre," ",ape_paterno," ",ape_materno) as name, id'))->pluck('name', 'id');
        //dd($empleado->toArray());
        //$caja = Caja::where('consecutivo', '=', $data['consecutivo'])->where('plantel_id', '=', $data['plantel_id'])->where('st_caja_id', '<>', 2)->first();
        $caja_aux = Caja::where('consecutivo', '=', $data['consecutivo'])->where('st_caja_id', '<>', 2)->whereIn('plantel_id', $planteles);
        if (isset($data['plantel_id']) and $data['plantel_id'] <> 0) {
            $caja_aux->where('plantel_id', $data['plantel_id']);
        }
        if (isset($data['cliente_caja']) and $data['cliente_caja'] <> "") {
            $caja_aux->where('cliente_id', $data['cliente_caja']);
        }
        $caja = $caja_aux->first();

        if (!is_object($caja)) {
            Session::flash('msj', 'Caja no existe');
            return view('cajas.caja')->with('list', Caja::getListFromAllRelationApps())->with('list1', CajaLn::getListFromAllRelationApps());
        }
        //dd($caja);
        $combinaciones = CombinacionCliente::where('cliente_id', '=', $caja->cliente_id)->get();
        $cajas = Caja::select('cajas.consecutivo as caja', 'cajas.fecha', 'ln.caja_concepto_id as concepto_id', 'cc.name as concepto', 'ln.total', 'st.name as estatus', 'ln.adeudo_id')
            ->join('caja_lns as ln', 'ln.caja_id', '=', 'cajas.id')
            ->join('caja_conceptos as cc', 'cc.id', '=', 'ln.caja_concepto_id')
            ->join('st_cajas as st', 'st.id', '=', 'cajas.st_caja_id')
            ->where('cliente_id', $caja->cliente->id)
            ->where('ln.adeudo_id', '0')
            ->whereNull('cajas.deleted_at')
            ->whereNull('ln.deleted_at')
            ->get();
        $cuentasEfectivo = CuentasEfectivo::pluck('name', 'id');
        //dd($cajas->toArray());
        $permiso_caja_buscarVenta = Auth::user()->can('permiso_caja_buscarVenta');
        //dd($permiso_caja_buscarVenta);

        //dd(array_search($caja->plantel_id, $planteles));
        if (is_object($caja) and array_search($caja->plantel_id, $planteles) <> false) { //$caja->plantel_id == $empleado->plantel_id) {
            //Apliacion de recargos
            if ($caja->st_caja_id == 0 and $caja->descuento == 0) {
                //dd($caja->st_caja_id);
                $recargo = 0;
            }

            $cliente = Cliente::find($caja->cliente_id);

            return view('cajas.caja', compact('cliente', 'caja', 'combinaciones', 'cajas', 'cuentasEfectivo', 'empleados'))
                ->with('list', Caja::getListFromAllRelationApps())
                ->with('list1', CajaLn::getListFromAllRelationApps());
        } elseif (is_object($caja) and $permiso_caja_buscarVenta and array_search($caja->plantel_id, $planteles) == false) { //$caja->plantel_id != $empleado->plantel_id) {
            //Apliacion de recargos
            if ($caja->st_caja_id == 0 and $caja->descuento == 0) {
                //dd($caja->st_caja_id);
                $recargo = 0;
            }

            //dd($cuentasEfectivo);
            $cliente = Cliente::find($caja->cliente_id);
            return view('cajas.caja', compact('cliente', 'caja', 'combinaciones', 'cajas', 'cuentasEfectivo', 'empleados'))
                ->with('list', Caja::getListFromAllRelationApps())
                ->with('list1', CajaLn::getListFromAllRelationApps());
        }
        Session::flash('msj', 'Informacion buscada pertenece a otro plantel');

        return view('cajas.caja', compact('cuentasEfectivo', 'empleados'))->with('list', Caja::getListFromAllRelationApps())->with('list1', CajaLn::getListFromAllRelationApps());
    }

    //Lineas de la caja con adeudos predefinidos
    public function guardaAdeudoPredefinido(Request $request)
    {
        //dd($request->get('adeudo'));
        $data = $request->all();
        //dd($data);

        $caja = Caja::find($data['caja']);
        $cliente = Cliente::find($data['cliente_id']);
        $cajas = Caja::select('cajas.consecutivo as caja', 'cajas.fecha', 'ln.caja_concepto_id as concepto_id', 'cc.name as concepto', 'ln.total', 'st.name as estatus', 'ln.adeudo_id')
            ->join('caja_lns as ln', 'ln.caja_id', '=', 'cajas.id')
            ->join('caja_conceptos as cc', 'cc.id', '=', 'ln.caja_concepto_id')
            ->join('st_cajas as st', 'st.id', '=', 'cajas.st_caja_id')
            ->where('cliente_id', $cliente->id)
            ->where('ln.adeudo_id', '0')
            ->whereNull('cajas.deleted_at')
            ->whereNull('ln.deleted_at')
            ->get();

        $lns = CajaLn::where('caja_id', $caja->id)->whereNull('deleted_at')->count();
        if ($lns == 0) {
            $conceptosValidos = $caja->plantel->conceptoMultipagos->toArray();
            //dd($conceptosValidos);

            foreach ($data['adeudos_tomados'] as $adeudo_tomado) {
                $adeudos = Adeudo::where('id', '=', $adeudo_tomado)->get();


                //dd($adeudos->toArray());



                $subtotal = 0;
                $recargo = 0;
                $descuento = 0;
                //dd($adeudos->toArray());

                foreach ($adeudos as $adeudo) {

                    $existe_linea = CajaLn::where('adeudo_id', '=', $adeudo->id)->first();
                    //dd($existe_linea->toArray());
                    if (!is_object($existe_linea)) {
                        $adeudo->caja_id = $caja->id;
                        $adeudo->save();
                        $caja_ln['caja_id'] = $caja->id;
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
                            //dd($cliente->autorizacionBecas->toArray());
                            foreach ($cliente->autorizacionBecas as $beca) {
                                //dd(is_null($beca->deleted_at));
                                //$diaAdeudo = Carbon::createFromFormat('Y-m-d', $adeudo->fecha_pago)->dia;
                                if (is_null($beca->deleted_at)) {
                                    //dd($beca->toArray());
                                    if ($beca->bnd_tiene_vigencia == 1 and !is_null($beca->vigencia)) {
                                        $fechaAdeudo = Carbon::createFromFormat('Y-m-d', $adeudo->fecha_pago);
                                        $fechaInicioVigenciaBeca = Carbon::createFromFormat('Y-m-d', $beca->inicio_vigencia);
                                        $fechaFinVigenciaBeca = Carbon::createFromFormat('Y-m-d', $beca->vigencia);
                                        //dd($fechaAdeudo->lessThanOrEqualTo($fechaVigenciaBeca));
                                        if ($fechaAdeudo->greaterThanOrEqualTo($fechaInicioVigenciaBeca) and $fechaAdeudo->lessThanOrEqualTo($fechaFinVigenciaBeca)) {
                                            $beca_a = $beca->id;
                                        }
                                    } elseif ($beca->bnd_tiene_vigencia == 0 and is_null($beca->vigencia)) {
                                        $mesAdeudo = Carbon::createFromFormat('Y-m-d', $adeudo->fecha_pago)->month;
                                        $anioAdeudo = Carbon::createFromFormat('Y-m-d', $adeudo->fecha_pago)->year;
                                        $mesInicio = Carbon::createFromFormat('Y-m-d', $beca->lectivo->inicio)->month;
                                        $anioInicio = Carbon::createFromFormat('Y-m-d', $beca->lectivo->inicio)->year;
                                        $mesFin = Carbon::createFromFormat('Y-m-d', $beca->lectivo->fin)->month;
                                        //$diaFin = Carbon::createFromFormat('Y-m-d', $beca->lectivo->fin)->day;
                                        $anioFin = Carbon::createFromFormat('Y-m-d', $beca->lectivo->fin)->year;

                                        //dd($anioInicio."-".$anioAdeudo."-".$mesInicio."-".$mesAdeudo."-".);
                                        //dd(($beca->lectivo->inicio <= $adeudo->fecha_pago and $beca->lectivo->fin >= $adeudo->fecha_pago));
                                        //dd(($anioInicio == $anioAdeudo or $mesInicio <= $mesAdeudo) and ($anioFin == $anioAdeudo and $mesFin >= $mesAdeudo));
                                        //dd(($anioInicio < $anioAdeudo or $mesInicio >= $mesAdeudo) and ($anioFin >= $anioAdeudo and $mesFin <= $mesAdeudo));
                                        //dd();
                                        if (
                                            (($beca->lectivo->inicio <= $adeudo->fecha_pago and $beca->lectivo->fin >= $adeudo->fecha_pago) or
                                                (($anioInicio == $anioAdeudo or $mesInicio <= $mesAdeudo) and ($anioFin == $anioAdeudo and $mesFin >= $mesAdeudo)) or
                                                (($anioInicio == $anioAdeudo or $mesInicio <= $mesAdeudo) and ($anioFin > $anioAdeudo)) or
                                                (($anioInicio < $anioAdeudo) and ($anioFin == $anioAdeudo and $mesFin >= $mesAdeudo))) and
                                            $beca->st_beca_id == 4 and is_null($beca->deleted_at)
                                        ) {

                                            //dd(($beca->lectivo->inicio <= $adeudo->fecha_pago and $beca->lectivo->fin >= $adeudo->fecha_pago));
                                            //dd(($anioInicio == $anioAdeudo or $mesInicio <= $mesAdeudo) and ($anioFin == $anioAdeudo and $mesFin >= $mesAdeudo));
                                            //dd(($anioInicio < $anioAdeudo or $mesInicio >= $mesAdeudo) and ($anioFin >= $anioAdeudo and $mesFin <= $mesAdeudo));
                                            $beca_a = $beca->id;
                                            //dd($beca);
                                        }
                                    }
                                }
                            }

                            $beca_autorizada = AutorizacionBeca::find($beca_a);
                            //dd($beca_autorizada->toArray());

                            if (
                                !is_null($beca_autorizada) and
                                $beca_autorizada->monto_mensualidad > 0 and
                                $adeudo->cajaConcepto->bnd_mensualidad == 1 and
                                ($adeudo->bnd_eximir_descuento_beca == 0 or is_null($adeudo->bnd_eximir_descuento_beca))
                            ) {
                                $calculo_monto_mensualidad = $caja_ln['subtotal'] * $beca_autorizada->monto_mensualidad;
                                //dd($caja_ln['subtotal'].'*'.$beca_autorizada->monto_mensualidad."=".$calculo_monto_mensualidad);
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
                                        $hoy = Carbon::createFromFormat('Y-m-d', $caja->fecha);
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
                            //dd($caja_ln);
                            //********************************* */
                            //Fin calculo descuento por promocion
                            //********************************* */    


                            //********************************* */
                            //Calcula regla descuento recargo
                            //********************************* */
                            $regla_recargo = 0;
                            $regla_descuento = 0;
                            //dd($caja_ln);
                            //dd($adeudo);

                            foreach ($adeudo->planPagoLn->reglaRecargos as $regla) {
                                //dd($regla->toArray());
                                if (($adeudo->bnd_eximir_descuento_regla == 0 or is_null($adeudo->bnd_eximir_descuento_regla)) and
                                    //$adeudo->cajaConcepto->bnd_mensualidad == 1 or
                                    //$adeudo->caja_concepto_id <= 26
                                    $adeudo->caja_concepto_id <= 33
                                ) {
                                    //dd($adeudo->planPagoLn->reglaRecargos->toArray());
                                    $fecha_caja = Carbon::createFromFormat('Y-m-d', $caja->fecha);
                                    $fecha_adeudo = Carbon::createFromFormat('Y-m-d', $adeudo->fecha_pago);
                                    //dd($fecha_caja->greaterThanOrEqualTo($fecha_adeudo));
                                    if ($fecha_caja->greaterThanOrEqualTo($fecha_adeudo)) {

                                        $dias = $fecha_caja->diffInDays($fecha_adeudo);
                                        //dd($dias);
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
                                                        $regla_descuento = $caja_ln['subtotal'] * $regla->porcentaje * -1;
                                                        //dd($regla_descuento);
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
                                                        //dd($regla_descuento);
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


                        }

                        $caja_ln['total'] = $caja_ln['subtotal'] + $caja_ln['recargo'] - $caja_ln['descuento'];

                        $caja_ln['adeudo_id'] = $adeudo->id;
                        $caja_ln['usu_alta_id'] = Auth::user()->id;
                        $caja_ln['usu_mod_id'] = Auth::user()->id;

                        $caja_ln['subtotal'] = round($caja_ln['subtotal'], 0);
                        $caja_ln['total'] = round($caja_ln['total'], 0);
                        $caja_ln['recargo'] = round($caja_ln['recargo'], 0);
                        $caja_ln['descuento'] = round($caja_ln['descuento'], 0);

                        /*if($cliente->beca_bnd==1 and $caja_ln['caja_concepto_id']==1){
                    $caja_ln['descuento']=$caja_ln['descuento']+($caja_ln['subtotal']*$cliente->beca_porcentaje);
                    $caja_ln['total']=$caja_ln['total']-($caja_ln['subtotal']-$caja_ln['descuento']);
                    }*/
                        //dd($caja_ln);
                        $caja_linea = CajaLn::create($caja_ln);
                        //dd($caja_linea);
                        $subtotal = $subtotal + $caja_ln['subtotal'];
                        $recargo = $recargo + $caja_ln['recargo'];
                        $descuento = $descuento + $caja_ln['descuento'];
                    }
                }
                if ($subtotal > 0) {
                    //dd($subtotal);
                    $caja->subtotal = round($caja->subtotal + $subtotal, 0);
                    $caja->recargo = round($caja->recargo + $recargo, 2);
                    $caja->descuento = round($caja->descuento + $descuento);
                    $caja->total = round($caja->subtotal + $caja->recargo - $caja->descuento);
                    //dd($caja);
                    $caja->save();
                }
            }

            //Valida pagos y adeudos para establecer estatus en caja
            $pagos = 0;
            if (isset($caja->pagos)) {
                foreach ($caja->pagos as $pago) {
                    $pagos = $pago->monto + $pagos;
                }
                if ($caja->total > $pagos and $pagos > 0) {
                    $caja->st_caja_id = 3;
                } elseif ($caja->total >= $pagos and $pagos > 0) {
                    $caja->st_caja_id = 1;
                }
                $caja->save();
            }
        }



        $combinaciones = CombinacionCliente::where('cliente_id', '=', $caja->cliente_id)->get();
        $empleados = Empleado::select(DB::raw('concat(nombre," ",ape_paterno," ",ape_materno) as name, id'))->pluck('name', 'id');

        return view('cajas.caja', compact('cliente', 'caja', 'combinaciones', 'cajas', 'empleados'))
            ->with('list', Caja::getListFromAllRelationApps())
            ->with('list1', CajaLn::getListFromAllRelationApps());
    }

    //Linea de la caja con conceptos existentes
    public function guardaAdeudo(Request $request)
    {
        $data = $request->all();

        //$plantel=Plantel::find(Auth::user()->id);

        $cliente = Cliente::find($data['cliente']);
        $caja = Caja::find($data['caja']);
        $concepto = CajaConcepto::find($data['concepto']);
        $registro['caja_id'] = $caja->id;
        $registro['caja_concepto_id'] = $concepto->id;
        if ($data['monto_concepto'] == 0) {
            $registro['subtotal'] = $concepto->monto;
        } else {
            $registro['subtotal'] = $data['monto_concepto'];
        }

        $registro['descuento'] = 0;
        $registro['recargo'] = 0;
        $registro['total'] = $registro['subtotal'];
        $registro['autorizacion_descuento'] = "";
        $registro['adeudo_id'] = 0;
        $registro['usu_alta_id'] = Auth::user()->id;
        $registro['usu_mod_id'] = Auth::user()->id;
        $linea = CajaLn::create($registro);

        $caja->subtotal = $caja->subtotal + $linea->subtotal;
        $caja->recargo = $caja->recargo + $linea->recargo;
        $caja->descuento = $caja->descuento + $linea->descuento;
        $caja->total = $caja->subtotal + $caja->recargo - $caja->descuento;

        $caja->save();

        echo json_encode($linea);
    }

    public function pagar(Request $request)
    {
        $caja = Caja::find($request->get('caja'));

        $cliente = Cliente::find($caja->cliente_id);
        $cajas = Caja::select('cajas.consecutivo as caja', 'cajas.fecha', 'ln.caja_concepto_id as concepto_id', 'cc.name as concepto', 'ln.total', 'st.name as estatus', 'ln.adeudo_id')
            ->join('caja_lns as ln', 'ln.caja_id', '=', 'cajas.id')
            ->join('caja_conceptos as cc', 'cc.id', '=', 'ln.caja_concepto_id')
            ->join('st_cajas as st', 'st.id', '=', 'cajas.st_caja_id')
            ->where('cliente_id', $cliente->id)
            ->where('ln.adeudo_id', '0')
            ->whereNull('cajas.deleted_at')
            ->whereNull('ln.deleted_at')
            ->get();

        $combinaciones = CombinacionCliente::where('cliente_id', '=', $caja->cliente_id)->get();

        foreach ($caja->cajaLns as $linea) {
            $adeudo = Adeudo::find($linea->adeudo_id);
            $adeudo->pagado_bnd = 1;
            $adeudo->caja_id = $caja->id;
            $adeudo->save();
        }

        $caja->st_caja_id = 1;
        $caja->referencia = $request->get('referencia');
        $caja->forma_pago_id = $request->get('forma_pago_id');
        $caja->save();

        return view('cajas.caja', compact('cliente', 'caja', 'combinaciones', 'cajas'))
            ->with('list', Caja::getListFromAllRelationApps())
            ->with('list1', CajaLn::getListFromAllRelationApps());
    }

    public function cancelar(Request $request)
    {
        //dd($request->get('caja'));
        $caja = Caja::find($request->get('caja'));
        if (!Auth::user()->can('cajas.cancelar')) {
            return response()->json(['msj' => 'No tiene permisos para cancelar']);
        }
        if ($caja->st_caja_id <> 1 and $caja->st_caja_id <> 3) {
            $caja->st_caja_id = 2;
            $caja->usu_cancelar_id = Auth::user()->id;
            $caja->subtotal = 0;
            $caja->descuento = 0;
            $caja->recargo = 0;
            $caja->total = 0;
            $caja->save();
            foreach ($caja->cajaLns as $ln) {
                $ln->adeudo_id = 0;
                $ln->save();
                $ln->delete();
            }
            foreach ($caja->pagos as $pago) {
                $pc = new PagosController();
                $pc->destroy($pago->id, new Pago());
            }
            $adeudos = Adeudo::where('caja_id', $caja->id)->get();
            foreach ($adeudos as $adeudo) {
                $adeudo->caja_id = 0;
                $adeudo->pagado_bnd = 0;
                $adeudo->save();
            }
        }

        $empleados = Empleado::select(DB::raw('concat(nombre," ",ape_paterno," ",ape_materno) as name, id'))->pluck('name', 'id');
        return view('cajas.caja', compact('empleados'))
            ->with('list', Caja::getListFromAllRelationApps())
            ->with('list1', CajaLn::getListFromAllRelationApps());
    }

    public function cancelarEnLinea(Request $request)
    {
        //dd($request->get('caja'));
        $caja = Caja::find($request->get('caja'));

        $enLinea = AdeudoPagoOnLine::where('caja_id', $caja->id)->where('matricula', $caja->cliente->matricula)->first();

        if (!is_null($enLinea)) {
            foreach ($caja->pagos as $pago) {
                $pc = new PagosController();
                $pc->destroy($pago->id, new Pago());
            }

            $caja->st_caja_id = 2;
            $caja->usu_cancelar_id = Auth::user()->id;
            $caja->subtotal = 0;
            $caja->descuento = 0;
            $caja->recargo = 0;
            $caja->total = 0;
            $caja->save();

            if (count($caja->cajaLns) > 0) {
                foreach ($caja->cajaLns as $ln) {
                    $ln->adeudo_id = 0;
                    $ln->save();
                    $ln->delete();
                }
            }

            $adeudos = Adeudo::where('caja_id', $caja->id)->get();
            foreach ($adeudos as $adeudo) {
                $adeudo->caja_id = 0;
                $adeudo->pagado_bnd = 0;
                $adeudo->save();
            }
            $enLinea = AdeudoPagoOnLine::where('caja_id', $caja->id)->where('matricula', $caja->cliente->matricula)->first();
            if (!is_null($enLinea)) {
                $enLinea->delete();
            }
        }

        return view('cajas.caja')->with('list', Caja::getListFromAllRelationApps())->with('list1', CajaLn::getListFromAllRelationApps());
    }

    public function imprimir(Request $request)
    {
        $data = $request->all();

        $caja = Caja::find($data['caja_id']);

        $adeudo = Adeudo::where('caja_id', '=', $caja->id)->first();

        if (!is_null($adeudo)) {
            $combinacion = CombinacionCliente::find($adeudo->combinacion_cliente_id);

            $cliente = Cliente::find($caja->cliente_id);
            $empleado = Empleado::where('user_id', '=', Auth::user()->id)->first();

            $carbon = new \Carbon\Carbon();
            $date = $carbon->now();
            $date = $date->format('d-m-Y H:i:s');

            $atendio_pago = Empleado::where('user_id', $caja->pagos->pluck('usu_alta_id')->first())->first();
            //dd($atendio_pago);

            //dd($adeudo->toArray());
            return view('cajas.imprimirTicket', array(
                'cliente' => $cliente,
                'caja' => $caja,
                'empleado' => $empleado,
                'fecha' => $date,
                'combinacion' => $combinacion,
                'atendio_pago' => $atendio_pago
            ));
        } else {
            $combinacion = 0;
            $cliente = Cliente::find($caja->cliente_id);
            $empleado = Empleado::where('user_id', '=', Auth::user()->id)->first();

            $carbon = new \Carbon\Carbon();
            $date = $carbon->now();
            $date = $date->format('d-m-Y H:i:s');

            $atendio_pago = Empleado::where('user_id', $caja->pagos->pluck('usu_alta_id')->first())->first();
            //dd($atendio_pago);

            //dd($adeudo->toArray());
            return view('cajas.imprimirTicket', array(
                'cliente' => $cliente,
                'caja' => $caja,
                'empleado' => $empleado,
                'fecha' => $date,
                'combinacion' => $combinacion,
                'atendio_pago' => $atendio_pago
            ));
        }
    }

    public function ingresosPlantelFormaPago()
    {

        return view('cajas.reportes.ingresosPlantelFormaPago')
            ->with('list', Cliente::getListFromAllRelationApps());
    }

    public function ingresosPlantelFormaPagoR(Request $request)
    {
        $data = $request->all();
        //dd($data);
        $empleado = Empleado::where('user_id', Auth::user()->id)->first();
        if (!isset($data['plantel_f'])) {
            //$data['plantel_f'] = $empleado->plantel_id;
            //$data['plantel_t'] = $empleado->plantel_id;
            $planteles = array();
            foreach ($empleado->plantels as $p) {
                //dd($p->id);
                array_push($planteles, $p->id);
            }
        }

        $resultado = Caja::select(DB::raw('sum(cajas.total) as total_cajas, p.razon ,fm.name as forma_pago'))
            ->join('forma_pagos as fm', 'fm.id', '=', 'cajas.forma_pago_id')
            ->join('plantels as p', 'p.id', '=', 'cajas.plantel_id')
            ->join('pagos as pag', 'pag.caja_id', '=', 'cajas.id')
            ->where('pag.fecha', '>=', $data['fecha_f'])
            ->where('pag.fecha', '<=', $data['fecha_t'])
            //->where('p.id', '>=', $data['plantel_f'])
            //->where('p.id', '<=', $data['plantel_t'])
            ->whereIn('p.id', $planteles)
            ->groupBy('p.razon')
            ->whereNull('cajas.deleted_at')
            ->groupBy('forma_pago')
            ->get();
        //dd($resultado->toArray());
        /*
        PDF::setOptions(['defaultFont' => 'arial']);
        $pdf = PDF::loadView('cajas.reportes.ingresosPlantelFormaPagoR', array('resultado' => $resultado))
        ->setPaper('letter', 'portrait');
        return $pdf->download('reporte.pdf');*/
        return view('cajas.reportes.ingresosPlantelFormaPagoR', array('resultado' => $resultado, 'datos' => $data));
    }

    public function eliminarRecargo(Request $request)
    {
        $data = $request->all();

        $caja = Caja::find($data['caja_id']);
        if ($caja->st_caja_id == 0) {
            $caja->recargo = 0;
            $caja->total =  $caja->recargo + $caja->subtotal - $caja->descuento;
            $caja->save();
        }

        $cliente = Cliente::find($caja->cliente_id);
        $combinaciones = CombinacionCliente::where('cliente_id', '=', $caja->cliente_id)->get();
        $cajas = Caja::select('cajas.consecutivo as caja', 'cajas.fecha', 'ln.caja_concepto_id as concepto_id', 'cc.name as concepto', 'ln.total', 'st.name as estatus', 'ln.adeudo_id')
            ->join('caja_lns as ln', 'ln.caja_id', '=', 'cajas.id')
            ->join('caja_conceptos as cc', 'cc.id', '=', 'ln.caja_concepto_id')
            ->join('st_cajas as st', 'st.id', '=', 'cajas.st_caja_id')
            ->where('cliente_id', $cliente->id)
            ->where('ln.adeudo_id', '0')
            ->whereNull('cajas.deleted_at')
            ->whereNull('ln.deleted_at')
            ->get();
        $empleados = Empleado::select(DB::raw('concat(nombre," ",ape_paterno," ",ape_materno) as name, id'))->pluck('name', 'id');

        return view('cajas.caja', compact('cliente', 'caja', 'combinaciones', 'cajas', 'empleados'))
            ->with('list', Caja::getListFromAllRelationApps())
            ->with('list1', CajaLn::getListFromAllRelationApps());
    }

    public function becaInscripcion(Request $request)
    {
        $datos = $request->all();

        $caja = Caja::find($datos['caja_id']);
        $cliente = Cliente::find($caja->cliente_id);
        if ($caja->becado_bnd == 0 and $cliente->beca_porcentaje > 0) {
            $caja->descuento = $caja->descuento + $cliente->beca_porcentaje; //monto para inscripcion
            $caja->total = $caja->total - $cliente->beca_porcentaje;
            $caja->becado_bnd = 1;
            $caja->save();
        }
        $combinaciones = CombinacionCliente::where('cliente_id', '=', $caja->cliente_id)->get();
        $cajas = Caja::select('cajas.consecutivo as caja', 'cajas.fecha', 'ln.caja_concepto_id as concepto_id', 'cc.name as concepto', 'ln.total', 'st.name as estatus', 'ln.adeudo_id')
            ->join('caja_lns as ln', 'ln.caja_id', '=', 'cajas.id')
            ->join('caja_conceptos as cc', 'cc.id', '=', 'ln.caja_concepto_id')
            ->join('st_cajas as st', 'st.id', '=', 'cajas.st_caja_id')
            ->where('cliente_id', $caja->cliente_id)
            ->where('ln.adeudo_id', '0')
            ->whereNull('cajas.deleted_at')
            ->whereNull('ln.deleted_at')
            ->get();
        return view('cajas.caja', compact('cliente', 'caja', 'combinaciones', 'cajas'))
            ->with('list', Caja::getListFromAllRelationApps())
            ->with('list1', CajaLn::getListFromAllRelationApps());
    }

    public function becaMensualidad(Request $request)
    {
        $datos = $request->all();

        $caja = Caja::find($datos['caja_id']);
        $cliente = Cliente::find($caja->cliente_id);
        if ($caja->becado_bnd == 0 and $cliente->monto_mensualidad > 0) {
            $descuento_total = 0;
            foreach ($caja->cajaLns as $linea) {
                if ($linea->cajaConcepto->bnd_aplicar_beca == 1) {
                    $linea->descuento = $linea->descuento + $cliente->monto_mensualidad;
                    $linea->total = $linea->total - $cliente->monto_mensualidad;
                    $linea->save();
                    $descuento_total = $descuento_total + $cliente->monto_mensualidad;
                }
            }
            $caja->descuento = $caja->descuento + $descuento_total; //monto para inscripcion
            $caja->total = $caja->total - $descuento_total;
            $caja->becado_bnd = 1;
            $caja->save();
        }

        $combinaciones = CombinacionCliente::where('cliente_id', '=', $caja->cliente_id)->get();
        $cajas = Caja::select('cajas.consecutivo as caja', 'cajas.fecha', 'ln.caja_concepto_id as concepto_id', 'cc.name as concepto', 'ln.total', 'st.name as estatus', 'ln.adeudo_id')
            ->join('caja_lns as ln', 'ln.caja_id', '=', 'cajas.id')
            ->join('caja_conceptos as cc', 'cc.id', '=', 'ln.caja_concepto_id')
            ->join('st_cajas as st', 'st.id', '=', 'cajas.st_caja_id')
            ->where('cliente_id', $caja->cliente_id)
            ->where('ln.adeudo_id', '0')
            ->whereNull('cajas.deleted_at')
            ->whereNull('ln.deleted_at')
            ->get();

        return view('cajas.caja', compact('cliente', 'caja', 'combinaciones', 'cajas'))
            ->with('list', Caja::getListFromAllRelationApps())
            ->with('list1', CajaLn::getListFromAllRelationApps());
    }

    public function IngresosAdedudosXPeriodoXPlantel()
    {
        return view('cajas.reportes.IngresosAdedudosXPeriodoXPlantel')
            ->with('list', Pago::getListFromAllRelationApps())
            ->with('list2', Caja::getListFromAllRelationApps());
    }

    public function IngresosAdedudosXPeriodoXPlantelR(Request $request)
    {
        $datos = $request->all();
        $plantel = Plantel::find($datos['plantel_f']);

        $resultado = array();

        $adeudosPendientes = Adeudo::select(
            'esp.name as especialidad',
            'n.name as nivel',
            'g.name as grado',
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
            //->where('pagado_bnd', '=', 0)
            ->whereDate('adeudos.fecha_pago', '>=', $datos['fecha_f'])
            ->whereDate('adeudos.fecha_pago', '<=', $datos['fecha_t'])
            ->where('c.plantel_id', '=', $datos['plantel_f'])
            ->groupBy('esp.name')->groupBy('n.name')->groupBy('g.name')->groupBy('c.id')
            ->groupBy('c.nombre')->groupBy('c.nombre2')->groupBy('c.ape_paterno')->groupBy('c.ape_materno')
            ->orderBy('c.id', 'asc')
            ->whereNull('cc.deleted_at')
            ->get();

        //dd($registros->toArray());

        return view(
            'cajas.reportes.IngresosAdedudosXPeriodoXPlantelR',
            array(
                'adeudos' => $adeudosPendientes,
                'plantel' => $plantel,
                'datos' => $datos,
            )
        );
    }

    public function editFecha(Request $request)
    {
        $data = $request->all();
        $caja = Caja::find($data['caja']);
        $caja->fecha = $data['fecha'];
        $caja->save();
        echo json_encode(true);
    }

    public function adeudosXplantel()
    {
        //$data=$request->all();

        //$user=Auth::user()->id;
        $empleado = Empleado::where('user_id', Auth::user()->id)->first();

        $plantel = Plantel::find($empleado->plantel_id);
        $planteles = array();
        foreach ($empleado->plantels as $p) {
            //dd($p->id);
            array_push($planteles, $p->id);
        }
        //dd($data);

        $hoy = date('Y-m-d');
        $tresMesesAntes = strtotime('-3 month', strtotime($hoy));
        $tresMesesAntes = date('Y-m-d', $tresMesesAntes);
        //dd($hoy);

        //$adeudos_tomados=Adeudo::join('combinacion_clientes as cc','cc.id','=','adeudos.combinacion_cliente_id')
        $adeudos_tomados = Adeudo::select(
            'stc.id',
            'adeudos.id as adeudo',
            'adeudos.*',
            'cc.*',
            'c.*',
            'g.id as grupo_id',
            'g.name as grupo',
            'stc.name as st_cliente',
            'stc.name as st_seguimiento',
            'e.name as especialidad',
            's.id as seguimiento'
        )
            ->join('combinacion_clientes as cc', 'cc.id', '=', 'adeudos.combinacion_cliente_id')
            ->join('clientes as c', 'c.id', '=', 'adeudos.cliente_id')
            ->join('st_clientes as stc', 'stc.id', '=', 'c.st_cliente_id')
            ->join('seguimientos as s', 's.cliente_id', '=', 'c.id')
            ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
            ->join('inscripcions as i', 'i.cliente_id', '=', 'c.id')
            ->join('especialidads as e', 'e.id', '=', 'i.especialidad_id')
            ->join('grupos as g', 'g.id', '=', 'i.grupo_id')
            ->where('fecha_pago', '>=', $tresMesesAntes)
            ->where('fecha_pago', '<=', $hoy)
            //->where('c.plantel_id', '=', $plantel->id)
            ->whereIn('c.plantel_id', $planteles)
            //->where('i.st_inscripcion_id',1)
            ->where('caja_id', '<>', 0)
            ->where('i.grupo_id', '>', 0)
            ->whereNull('cc.deleted_at')
            ->distinct()
            ->orderBy('stc.id', 'desc')
            ->orderBy('g.id')
            ->with('planPagoLn')
            ->with('cliente')
            ->with('cajaConcepto')
            ->with('cajaLn')
            ->with('caja')
            ->get();
        //dd($adeudos_tomados->toArray());
        $registros = array();
        foreach ($adeudos_tomados as $adeudo_tomado) {
            //$adeudos=Adeudo::where('id', '=', $adeudo_tomado)->get();
            //dd($adeudo_tomado);
            //$cliente = Cliente::find($adeudo_tomado->cliente_id);
            $cliente = $adeudo_tomado->cliente;
            //dd($adeudos->toArray());
            $subtotal = 0;
            $recargo = 0;
            $descuento = 0;
            //dd($adeudos->toArray());

            //foreach($adeudos as $adeudo){
            $existe_linea = CajaLn::where('adeudo_id', '=', $adeudo_tomado->adeudo)
                ->whereNull('caja_lns.deleted_at')
                ->with('caja')
                ->first();
            //dd($existe_linea->caja->toArray());
            if (!is_object($existe_linea)) {

                //dd($existe_linea->toArray());
                $caja_ln['razon'] = $adeudo_tomado->cliente->plantel->razon;
                $caja_ln['grupo'] = $adeudo_tomado->grupo;
                $caja_ln['concepto'] = $adeudo_tomado->cajaConcepto->name;
                $caja_ln['cliente'] = $cliente->id . '-' . $cliente->nombre . ' ' . $cliente->nombre2 . " " . $cliente->ape_paterno . ' ' . $cliente->ape_materno;
                $caja_ln['seguimiento'] = $cliente->seguimiento;
                $caja_ln['estatus_caja'] = "";
                $caja_ln['caja_concepto_id'] = $adeudo_tomado->caja_concepto_id;
                $caja_ln['subtotal'] = $adeudo_tomado->monto;
                $caja_ln['bnd_pagado'] = $adeudo_tomado->bnd_pagado;
                $caja_ln['fecha_pago'] = $adeudo_tomado->fecha_pago;
                $caja_ln['especialidad'] = $adeudo_tomado->especialidad;
                $caja_ln['st_cliente'] = $adeudo_tomado->st_cliente;
                $caja_ln['st_seguimiento'] = $adeudo_tomado->st_seguimiento;
                //                    dd($adeudo->planPagoLn->reglaRecargos);
                $caja_ln['total'] = 0;
                $caja_ln['recargo'] = 0;
                $caja_ln['descuento'] = 0;
                foreach ($adeudo_tomado->planPagoLn->reglaRecargos as $regla) {

                    $dias = date_diff(date_create($hoy), date_create($adeudo_tomado->fecha_pago));
                    //dd($dias);
                    $dia = $dias->format('%R%a') * -1;

                    //calcula recargo o descuento segun regla y aplica
                    if ($dia >= $regla->dia_inicio and $dia <= $regla->dia_fin) {
                        if ($regla->tipo_regla_id == 1) {
                            //dd($regla->porcentaje);
                            if ($regla->porcentaje > 0) {
                                //dd($regla->porcentaje);
                                $caja_ln['recargo'] = $adeudo_tomado->monto * $regla->porcentaje;
                                //echo $caja_ln['recargo'];
                            } else {
                                $caja_ln['descuento'] = $adeudo_tomado->monto * $regla->porcentaje * -1;
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
                    $promociones = PromoPlanLn::where('plan_pago_ln_id', $adeudo_tomado->plan_pago_ln_id)->get();
                    $caja_ln['promo_plan_ln_id'] = 0;
                    if ($cliente->beca_bnd != 1) {
                        foreach ($promociones as $promocion) {
                            $inscripcion = Adeudo::where('cliente_id', $adeudo_tomado->cliente_id)
                                //->where('plan_pago_ln_id',$adeudo->plan_pago_ln_id)
                                ->where('caja_concepto_id', 1)
                                ->where('combinacion_cliente_id', $adeudo_tomado->combinacion_cliente_id)
                                ->where('pagado_bnd', 1)
                                ->with('caja')
                                ->first();
                            //dd($inscripcion);
                            if (is_object($inscripcion)) {
                                $inicio = Carbon::createFromFormat('Y-m-d', $promocion->fec_inicio);
                                $fin = Carbon::createFromFormat('Y-m-d', $promocion->fec_fin);

                                //$hoy=date('Y-m-d');
                                //$hoy=Carbon::now();
                                //La caja tiene la fecha de pago de un solo concepto que debe ser la inscripcion
                                $caja_inscripcion = $inscripcion->caja; //Caja::find($inscripcion->caja_id);
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
                                //$caja_inscripcion=Caja::find($inscripcion->caja_id);
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
                    }
                } catch (Exception $e) {
                    dd($e);
                }
                $caja_ln['total'] = $caja_ln['subtotal'] + $caja_ln['recargo'] - $caja_ln['descuento'];

                $caja_ln['adeudo_id'] = $adeudo_tomado->id;
                $caja_ln['usu_alta_id'] = Auth::user()->id;
                $caja_ln['usu_mod_id'] = Auth::user()->id;

                //    }
                array_push($registros, $caja_ln);
            } elseif (is_object($existe_linea) and $existe_linea->caja->st_caja_id == 3) {
                //dd($adeudo_tomado->toArray());
                $caja_ln['razon'] = $adeudo_tomado->cliente->plantel->razon;
                $caja_ln['grupo'] = $adeudo_tomado->grupo;
                $caja_ln['concepto'] = $adeudo_tomado->cajaConcepto->name;
                $caja_ln['cliente'] = $cliente->id . '-' . $cliente->nombre . ' ' . $cliente->nombre2 . " " . $cliente->ape_paterno . ' ' . $cliente->ape_materno;
                $caja_ln['seguimiento'] = $cliente->seguimiento;
                $caja_ln['estatus_caja'] = $existe_linea->caja->stCaja->name;
                $caja_ln['caja_concepto_id'] = $adeudo_tomado->caja_concepto_id;
                //$caja_ln['subtotal']=$adeudo_tomado->monto;
                $caja_ln['bnd_pagado'] = $adeudo_tomado->pagado_bnd;
                $caja_ln['fecha_pago'] = $adeudo_tomado->fecha_pago;
                //                    dd($adeudo->planPagoLn->reglaRecargos);
                $caja_ln['subtotal'] = $existe_linea->subtotal;
                $caja_ln['total'] = $existe_linea->total;
                $caja_ln['recargo'] = $existe_linea->recargo;
                $caja_ln['descuento'] = $existe_linea->descuento;
                $caja_ln['especialidad'] = $adeudo_tomado->especialidad;
                $caja_ln['st_cliente'] = $adeudo_tomado->st_cliente;
                $caja_ln['st_seguimiento'] = $adeudo_tomado->st_seguimiento;
                array_push($registros, $caja_ln);
            }
        }

        $fecha = date('d-m-Y');
        //dd($registros);
        //dd($registros);

        /*
        PDF::setOptions(['defaultFont' => 'arial']);

        $pdf = PDF::loadView('inscripcions.reportes.lista_calificacionesr', array('registros'=>$registros,'carga_ponderacions_enc'=>$carga_ponderacion))
        ->setPaper('legal', 'landscape');
        return $pdf->download('reporte.pdf');
         */
        return view('cajas.adeudosXplantel', array(
            'registros' => $registros,
            'plantel' => $plantel,
            'fecha' => $fecha,
        ));
    }

    public function moodleAdeudosXplantel(Request $request)
    {
        $data = $request->all();

        $empleado = Empleado::where('user_id', Auth::user()->id)->first();

        //$plantel = Plantel::find($empleado->plantel_id);

        //dd($data);

        $hoy = date('Y-m-d');
        $tresMesesAntes = strtotime('-3 month', strtotime($hoy));
        $tresMesesAntes = date('Y-m-d', $tresMesesAntes);
        //dd($tresMesesAntes);

        $registros = array();
        //foreach ($planteles as $plantel) {
        $adeudos_tomados = Adeudo::select(
            'stc.id',
            'adeudos.id as adeudo',
            'adeudos.*',
            'cc.*',
            'c.*',
            'g.id as grupo_id',
            'g.name as grupo',
            'stc.name as st_cliente',
            'stc.name as st_seguimiento',
            'e.name as especialidad',
            's.id as seguimiento'
        )
            ->join('combinacion_clientes as cc', 'cc.id', '=', 'adeudos.combinacion_cliente_id')
            ->join('clientes as c', 'c.id', '=', 'adeudos.cliente_id')
            ->join('st_clientes as stc', 'stc.id', '=', 'c.st_cliente_id')
            ->join('seguimientos as s', 's.cliente_id', '=', 'c.id')
            ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
            ->join('inscripcions as i', 'i.cliente_id', '=', 'c.id')
            ->join('especialidads as e', 'e.id', '=', 'i.especialidad_id')
            ->join('grupos as g', 'g.id', '=', 'i.grupo_id')
            ->where('fecha_pago', '>=', $tresMesesAntes)
            ->where('fecha_pago', '<=', $hoy)
            ->where('c.plantel_id', '=', $data['plantel_id'])
            ->where('adeudos.pagado_bnd', 0)
            //->whereIn('c.plantel_id', $planteles)
            //->where('i.st_inscripcion_id',1)
            //->where('caja_id', '<>', 0)
            //->where('i.grupo_id', '>', 0)
            ->whereNull('cc.deleted_at')
            ->whereNull('i.deleted_at')
            ->distinct()
            ->orderBy('stc.id', 'desc')
            ->orderBy('g.id', 'asc')
            ->with('planPagoLn')
            ->with('cliente')
            ->with('cajaConcepto')
            //->with('cajaLn')
            ->with('caja')
            ->get();
        //dd($adeudos_tomados->toArray());

        foreach ($adeudos_tomados as $adeudo_tomado) {

            $cliente = $adeudo_tomado->cliente;
            //dd($adeudos->toArray());
            $subtotal = 0;
            $recargo = 0;
            $descuento = 0;
            //dd($adeudos->toArray());
            $caja_ln['razon'] = $adeudo_tomado->cliente->plantel->razon;
            $caja_ln['grupo'] = $adeudo_tomado->grupo;
            $caja_ln['concepto'] = $adeudo_tomado->cajaConcepto->name;
            $caja_ln['cliente'] = $cliente->id . '-' . $cliente->nombre . ' ' . $cliente->nombre2 . " " . $cliente->ape_paterno . ' ' . $cliente->ape_materno;
            $caja_ln['cliente_id'] = $cliente->id;
            $caja_ln['seguimiento'] = $cliente->seguimiento;
            if ($adeudo_tomado->caja_id > 0) {
                $caja_ln['estatus_caja'] = $adeudo_tomado->caja->stCaja->name;
            } else {
                $caja_ln['estatus_caja'] = "";
            }

            $caja_ln['caja_concepto_id'] = $adeudo_tomado->caja_concepto_id;
            $caja_ln['subtotal'] = $adeudo_tomado->monto;
            $caja_ln['bnd_pagado'] = $adeudo_tomado->bnd_pagado;
            $caja_ln['fecha_pago'] = $adeudo_tomado->fecha_pago;
            $caja_ln['especialidad'] = $adeudo_tomado->especialidad;
            $caja_ln['st_cliente'] = $adeudo_tomado->st_cliente;
            $caja_ln['st_seguimiento'] = $adeudo_tomado->st_seguimiento;
            //                    dd($adeudo->planPagoLn->reglaRecargos);
            $caja_ln['total'] = $adeudo_tomado->monto;
            $caja_ln['recargo'] = 0;
            $caja_ln['descuento'] = 0;
            $caja_ln['adeudo_id'] = $adeudo_tomado->id;
            $caja_ln['usu_alta_id'] = Auth::user()->id;
            $caja_ln['usu_mod_id'] = Auth::user()->id;

            //dd($caja_ln);
            array_push($registros, $caja_ln);
            /*
                $existe_linea = CajaLn::select('subtotal', 'total', 'recargo', 'descuento')->where('adeudo_id', '=', $adeudo_tomado->adeudo)
                    ->whereNull('caja_lns.deleted_at')
                    //->with('caja')
                    ->first();
                //dd($existe_linea);
                if (!is_object($existe_linea)) {
                    $caja_ln['razon'] = $adeudo_tomado->cliente->plantel->razon;
                    $caja_ln['grupo'] = $adeudo_tomado->grupo;
                    $caja_ln['concepto'] = $adeudo_tomado->cajaConcepto->name;
                    $caja_ln['cliente'] = $cliente->id . '-' . $cliente->nombre . ' ' . $cliente->nombre2 . " " . $cliente->ape_paterno . ' ' . $cliente->ape_materno;
                    $caja_ln['seguimiento'] = $cliente->seguimiento;
                    $caja_ln['estatus_caja'] = "";
                    $caja_ln['caja_concepto_id'] = $adeudo_tomado->caja_concepto_id;
                    $caja_ln['subtotal'] = $adeudo_tomado->monto;
                    $caja_ln['bnd_pagado'] = $adeudo_tomado->bnd_pagado;
                    $caja_ln['fecha_pago'] = $adeudo_tomado->fecha_pago;
                    $caja_ln['especialidad'] = $adeudo_tomado->especialidad;
                    $caja_ln['st_cliente'] = $adeudo_tomado->st_cliente;
                    $caja_ln['st_seguimiento'] = $adeudo_tomado->st_seguimiento;
                    //                    dd($adeudo->planPagoLn->reglaRecargos);
                    $caja_ln['total'] = $adeudo_tomado->monto;
                    $caja_ln['recargo'] = 0;
                    $caja_ln['descuento'] = 0;
                    $caja_ln['adeudo_id'] = $adeudo_tomado->id;
                    $caja_ln['usu_alta_id'] = Auth::user()->id;
                    $caja_ln['usu_mod_id'] = Auth::user()->id;

                    //dd($caja_ln);
                    array_push($registros, $caja_ln);
                } elseif (is_object($existe_linea) and $existe_linea->caja->st_caja_id == 3) {
                    //dd($adeudo_tomado->toArray());
                    $caja_ln['razon'] = $adeudo_tomado->cliente->plantel->razon;
                    $caja_ln['grupo'] = $adeudo_tomado->grupo;
                    $caja_ln['concepto'] = $adeudo_tomado->cajaConcepto->name;
                    $caja_ln['cliente'] = $cliente->id . '-' . $cliente->nombre . ' ' . $cliente->nombre2 . " " . $cliente->ape_paterno . ' ' . $cliente->ape_materno;
                    $caja_ln['seguimiento'] = $cliente->seguimiento;
                    $caja_ln['estatus_caja'] = $existe_linea->caja->stCaja->name;
                    $caja_ln['caja_concepto_id'] = $adeudo_tomado->caja_concepto_id;
                    //$caja_ln['subtotal']=$adeudo_tomado->monto;
                    $caja_ln['bnd_pagado'] = $adeudo_tomado->pagado_bnd;
                    $caja_ln['fecha_pago'] = $adeudo_tomado->fecha_pago;
                    //                    dd($adeudo->planPagoLn->reglaRecargos);
                    $caja_ln['subtotal'] = $existe_linea->subtotal;
                    $caja_ln['total'] = $existe_linea->total;
                    $caja_ln['recargo'] = $existe_linea->recargo;
                    $caja_ln['descuento'] = $existe_linea->descuento;
                    $caja_ln['especialidad'] = $adeudo_tomado->especialidad;
                    $caja_ln['st_cliente'] = $adeudo_tomado->st_cliente;
                    $caja_ln['st_seguimiento'] = $adeudo_tomado->st_seguimiento;
                    array_push($registros, $caja_ln);
                }
                */
            //    }
        }




        $fecha = date('d-m-Y');
        //dd($registros);
        //dd($registros);

        /*
        PDF::setOptions(['defaultFont' => 'arial']);

        $pdf = PDF::loadView('inscripcions.reportes.lista_calificacionesr', array('registros'=>$registros,'carga_ponderacions_enc'=>$carga_ponderacion))
        ->setPaper('legal', 'landscape');
        return $pdf->download('reporte.pdf');
         */
        return view('cajas.moodleAdeudosXplantel', array(
            'registros' => $registros,
            'plantel' => $plantel,
            'fecha' => $fecha,
        ));
    }


    public function adeudosXplantelWidget()
    {
        //$data=$request->all();

        //$user=Auth::user()->id;
        $empleado = Empleado::where('user_id', Auth::user()->id)->first();

        //$plantel = Plantel::find($empleado->plantel_id);
        $planteles = array();
        foreach ($empleado->plantels as $p) {
            //dd($p->id);
            array_push($planteles, $p->id);
        }
        //dd($data);

        $hoy = date('Y-m-d');
        $tresMesesAntes = strtotime('-3 month', strtotime($hoy));
        $tresMesesAntes = date('Y-m-d', $tresMesesAntes);
        //dd($hoy);

        //$adeudos_tomados=Adeudo::join('combinacion_clientes as cc','cc.id','=','adeudos.combinacion_cliente_id')
        $adeudos_tomados = Adeudo::select(
            'stc.id',
            'adeudos.id as adeudo',
            'adeudos.*',
            'cc.*',
            'c.*',
            'g.id as grupo_id',
            'g.name as grupo',
            'stc.name as st_cliente',
            'stc.name as st_seguimiento',
            'e.name as especialidad',
            's.id as seguimiento'
        )
            ->join('combinacion_clientes as cc', 'cc.id', '=', 'adeudos.combinacion_cliente_id')
            ->join('clientes as c', 'c.id', '=', 'adeudos.cliente_id')
            ->join('st_clientes as stc', 'stc.id', '=', 'c.st_cliente_id')
            ->join('seguimientos as s', 's.cliente_id', '=', 'c.id')
            ->join('st_seguimientos as sts', 'sts.id', '=', 's.st_seguimiento_id')
            ->join('inscripcions as i', 'i.cliente_id', '=', 'c.id')
            ->join('especialidads as e', 'e.id', '=', 'i.especialidad_id')
            ->join('grupos as g', 'g.id', '=', 'i.grupo_id')
            ->where('fecha_pago', '>=', $tresMesesAntes)
            ->where('fecha_pago', '<=', $hoy)
            //->where('c.plantel_id', '=', $plantel->id)
            ->whereIn('c.plantel_id', $planteles)
            //->where('i.st_inscripcion_id',1)
            ->where('caja_id', '<>', 0)
            ->where('i.grupo_id', '>', 0)
            ->whereNull('cc.deleted_at')
            ->distinct()
            ->orderBy('stc.id', 'desc')
            ->orderBy('g.id')
            ->get();
        //echo $adeudos_tomados->toJson();
        //dd($adeudos_tomados->toArray());
        $registros = array();
        foreach ($adeudos_tomados as $adeudo_tomado) {
            //$adeudos=Adeudo::where('id', '=', $adeudo_tomado)->get();
            //dd($adeudo_tomado);
            $cliente = Cliente::find($adeudo_tomado->cliente_id);

            //dd($adeudos->toArray());
            $subtotal = 0;
            $recargo = 0;
            $descuento = 0;
            //dd($adeudos->toArray());

            //foreach($adeudos as $adeudo){
            $existe_linea = CajaLn::where('adeudo_id', '=', $adeudo_tomado->adeudo)->whereNull('caja_lns.deleted_at')->first();
            //dd($adeudo_tomado->adeudo);
            if (!is_object($existe_linea)) {
                //dd($existe_linea->toArray());
                $caja_ln['razon'] = $adeudo_tomado->cliente->plantel->razon;
                $caja_ln['grupo'] = $adeudo_tomado->grupo;
                $caja_ln['concepto'] = $adeudo_tomado->cajaConcepto->name;
                $caja_ln['cliente'] = $cliente->id . '-' . $cliente->nombre . ' ' . $cliente->nombre2 . " " . $cliente->ape_paterno . ' ' . $cliente->ape_materno;
                $caja_ln['seguimiento'] = $cliente->seguimiento;
                $caja_ln['estatus_caja'] = "";
                $caja_ln['caja_concepto_id'] = $adeudo_tomado->caja_concepto_id;
                $caja_ln['subtotal'] = $adeudo_tomado->monto;
                $caja_ln['bnd_pagado'] = $adeudo_tomado->bnd_pagado;
                $caja_ln['fecha_pago'] = $adeudo_tomado->fecha_pago;
                $caja_ln['especialidad'] = $adeudo_tomado->especialidad;
                $caja_ln['st_cliente'] = $adeudo_tomado->st_cliente;
                $caja_ln['st_seguimiento'] = $adeudo_tomado->st_seguimiento;
                //                    dd($adeudo->planPagoLn->reglaRecargos);
                $caja_ln['total'] = 0;
                $caja_ln['recargo'] = 0;
                $caja_ln['descuento'] = 0;
                foreach ($adeudo_tomado->planPagoLn->reglaRecargos as $regla) {

                    $dias = date_diff(date_create($hoy), date_create($adeudo_tomado->fecha_pago));
                    //dd($dias);
                    $dia = $dias->format('%R%a') * -1;

                    //calcula recargo o descuento segun regla y aplica
                    if ($dia >= $regla->dia_inicio and $dia <= $regla->dia_fin) {
                        if ($regla->tipo_regla_id == 1) {
                            //dd($regla->porcentaje);
                            if ($regla->porcentaje > 0) {
                                //dd($regla->porcentaje);
                                $caja_ln['recargo'] = $adeudo_tomado->monto * $regla->porcentaje;
                                //echo $caja_ln['recargo'];
                            } else {
                                $caja_ln['descuento'] = $adeudo_tomado->monto * $regla->porcentaje * -1;
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
                    $promociones = PromoPlanLn::where('plan_pago_ln_id', $adeudo_tomado->plan_pago_ln_id)->get();
                    $caja_ln['promo_plan_ln_id'] = 0;
                    if ($cliente->beca_bnd != 1) {
                        foreach ($promociones as $promocion) {
                            $inscripcion = Adeudo::where('cliente_id', $adeudo_tomado->cliente_id)
                                //->where('plan_pago_ln_id',$adeudo->plan_pago_ln_id)
                                ->where('caja_concepto_id', 1)
                                ->where('combinacion_cliente_id', $adeudo_tomado->combinacion_cliente_id)
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
                                //$caja_inscripcion=Caja::find($inscripcion->caja_id);
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
                    }
                } catch (Exception $e) {
                    dd($e);
                }
                $caja_ln['total'] = $caja_ln['subtotal'] + $caja_ln['recargo'] - $caja_ln['descuento'];

                $caja_ln['adeudo_id'] = $adeudo_tomado->id;
                $caja_ln['usu_alta_id'] = Auth::user()->id;
                $caja_ln['usu_mod_id'] = Auth::user()->id;

                //    }
                array_push($registros, $caja_ln);
            } elseif (is_object($existe_linea) and $existe_linea->caja->st_caja_id == 3) {
                //dd($adeudo_tomado->toArray());
                $caja_ln['razon'] = $adeudo_tomado->cliente->plantel->razon;
                $caja_ln['grupo'] = $adeudo_tomado->grupo;
                $caja_ln['concepto'] = $adeudo_tomado->cajaConcepto->name;
                $caja_ln['cliente'] = $cliente->id . '-' . $cliente->nombre . ' ' . $cliente->nombre2 . " " . $cliente->ape_paterno . ' ' . $cliente->ape_materno;
                $caja_ln['seguimiento'] = $cliente->seguimiento;
                $caja_ln['estatus_caja'] = $existe_linea->caja->stCaja->name;
                $caja_ln['caja_concepto_id'] = $adeudo_tomado->caja_concepto_id;
                //$caja_ln['subtotal']=$adeudo_tomado->monto;
                $caja_ln['bnd_pagado'] = $adeudo_tomado->pagado_bnd;
                $caja_ln['fecha_pago'] = $adeudo_tomado->fecha_pago;
                //                    dd($adeudo->planPagoLn->reglaRecargos);
                $caja_ln['subtotal'] = $existe_linea->subtotal;
                $caja_ln['total'] = $existe_linea->total;
                $caja_ln['recargo'] = $existe_linea->recargo;
                $caja_ln['descuento'] = $existe_linea->descuento;
                $caja_ln['especialidad'] = $adeudo_tomado->especialidad;
                $caja_ln['st_cliente'] = $adeudo_tomado->st_cliente;
                $caja_ln['st_seguimiento'] = $adeudo_tomado->st_seguimiento;
                array_push($registros, $caja_ln);
            }
        }

        $fecha = date('d-m-Y');
        $cantidad_adeudos = 0;
        foreach ($registros as $registro) {
            $cantidad_adeudos++;
        }
        //dd($registros);
        //dd($registros);

        /*
        PDF::setOptions(['defaultFont' => 'arial']);

        $pdf = PDF::loadView('inscripcions.reportes.lista_calificacionesr', array('registros'=>$registros,'carga_ponderacions_enc'=>$carga_ponderacion))
        ->setPaper('legal', 'landscape');
        return $pdf->download('reporte.pdf');
         */
        return json_encode($cantidad_adeudos);
    }

    public function aplicarRecargos(Request $request)
    {
        $data = $request->all();
        $caja = Caja::find($data['caja']);
        $caja->recargo = 0;
        $caja->save();
        //dd($caja->cajaLns);
        foreach ($caja->cajaLns as $adeudo_tomado) {
            $adeudos = Adeudo::where('id', '=', $adeudo_tomado->adeudo_id)->get();

            $cliente = Cliente::find($caja->cliente_id);
            $cajas = Caja::select('cajas.consecutivo as caja', 'cajas.fecha', 'ln.caja_concepto_id as concepto_id', 'cc.name as concepto', 'ln.total', 'st.name as estatus', 'ln.adeudo_id')
                ->join('caja_lns as ln', 'ln.caja_id', '=', 'cajas.id')
                ->join('caja_conceptos as cc', 'cc.id', '=', 'ln.caja_concepto_id')
                ->join('st_cajas as st', 'st.id', '=', 'cajas.st_caja_id')
                ->where('cliente_id', $cliente->id)
                ->where('ln.adeudo_id', '0')
                ->whereNull('cajas.deleted_at')
                ->whereNull('ln.deleted_at')
                ->get();

            $subtotal = 0;
            $recargo = 0;
            $descuento = 0;
            //dd($adeudos->toArray());

            foreach ($adeudos as $adeudo) {
                $existe_linea = CajaLn::where('adeudo_id', '=', $adeudo->id)->first();
                if (is_object($existe_linea)) {

                    $caja_ln['caja_id'] = $caja->id;
                    $caja_ln['caja_concepto_id'] = $adeudo->caja_concepto_id;
                    $caja_ln['subtotal'] = $adeudo->monto;
                    //                    dd($adeudo->planPagoLn->reglaRecargos);
                    $caja_ln['total'] = 0;
                    $caja_ln['recargo'] = 0;
                    $caja_ln['descuento'] = 0;
                    foreach ($adeudo->planPagoLn->reglaRecargos as $regla) {
                        $fecha_caja = Carbon::createFromFormat('Y-m-d', $caja->fecha);
                        $fecha_adeudo = Carbon::createFromFormat('Y-m-d', $adeudo->fecha_pago);
                        if ($fecha_caja >= $fecha_adeudo) {

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
                    }
                    //dd($caja_ln);
                    $caja_ln['total'] = 0;
                    $caja_ln['total'] = $caja_ln['subtotal'] + $caja_ln['recargo'] - $caja_ln['descuento'];

                    //calcula descuento segun promocion ligada a la linea del plan considerando la fecha de pago de la
                    //inscripcion del cliente
                    //dd($adeudo);
                    try {
                        $promociones = PromoPlanLn::where('plan_pago_ln_id', $adeudo->plan_pago_ln_id)->get();
                        $caja_ln['promo_plan_ln_id'] = 0;
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
                                    //dd($hoy);
                                    $monto_promocion = 0;
                                    //dd($hoy);
                                    if ($inicio->lessThanOrEqualTo($hoy) and $fin->greaterThanOrEqualTo($hoy) and $caja_ln['promo_plan_ln_id'] == 0) {

                                        $monto_promocion = $promocion->descuento * $caja_ln['subtotal'];
                                        $caja_ln['descuento'] = $caja_ln['descuento'] + $monto_promocion;
                                        $caja_ln['promo_plan_ln_id'] = $promocion->id;
                                    }
                                } else {
                                    $inicio = Carbon::createFromFormat('Y-m-d', $promocion->fec_inicio);
                                    $fin = Carbon::createFromFormat('Y-m-d', $promocion->fec_fin);

                                    $hoy = Carbon::createFromFormat('Y-m-d', $caja->fecha);
                                    $monto_promocion = 0;
                                    //dd($hoy);
                                    if ($inicio->lessThanOrEqualTo($hoy) and $fin->greaterThanOrEqualTo($hoy) and $caja_ln['promo_plan_ln_id'] == 0) {

                                        $monto_promocion = $promocion->descuento * $caja_ln['subtotal'];
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

                    $caja_ln['usu_mod_id'] = Auth::user()->id;
                    /*if($cliente->beca_bnd==1 and $caja_ln['caja_concepto_id']==1){
                    $caja_ln['descuento']=$caja_ln['descuento']+($caja_ln['subtotal']*$cliente->beca_porcentaje);
                    $caja_ln['total']=$caja_ln['total']-($caja_ln['subtotal']-$caja_ln['descuento']);
                    }*/
                    //dd($caja_ln);

                    $existe_linea->update($caja_ln);
                    $subtotal = $subtotal + $caja_ln['subtotal'];
                    $recargo = $recargo + $caja_ln['recargo'];
                    $descuento = $descuento + $caja_ln['descuento'];
                }
            }
            //dd($subtotal);
            if ($recargo > 0) {
                //dd($subtotal);
                $caja->subtotal = $caja->subtotal;
                $caja->recargo = $caja->recargo + $recargo;
                $caja->descuento = $caja->descuento + $descuento;
                $caja->total = $caja->subtotal + $caja->recargo - $caja->descuento;
                //dd($caja);
                $caja->save();
            }
        }

        //Valida pagos y adeudos para establecer estatus en caja
        $pagos = 0;
        if (isset($caja->pagos)) {
            foreach ($caja->pagos as $pago) {
                $pagos = $pago->monto + $pagos;
            }
            if ($caja->total > $pagos and $pagos > 0) {
                $caja->st_caja_id = 3;
            } elseif ($caja->total >= $pagos and $pagos > 0) {
                $caja->st_caja_id = 1;
            }
            $caja->save();
        }

        $combinaciones = CombinacionCliente::where('cliente_id', '=', $caja->cliente_id)->get();
        $empleados = Empleado::select(DB::raw('concat(nombre," ",ape_paterno," ",ape_materno) as name, id'))->pluck('name', 'id');


        return view('cajas.caja', compact('cliente', 'caja', 'combinaciones', 'cajas', 'empleados'))
            ->with('list', Caja::getListFromAllRelationApps())
            ->with('list1', CajaLn::getListFromAllRelationApps());
    }

    public function repetirActivarBs(Request $request)
    {
        $datos = $request->all();
        //dd($datos);
        $cliente = Cliente::find($datos['cliente']);
        $caja = Caja::find($datos['caja']);
        if ($cliente->st_cliente_id == 4) {
            $param = Param::where('llave', 'apiVersion_bSpace')->first();
            $bs_activo = Param::where('llave', 'api_brightSpace_activa')->first();
            if ($bs_activo->valor == 1) {
                try {
                    $apiBs = new UsoApi();

                    //dd($datos);
                    //Log::info('matricula bs reactivar en caja:'.$cliente->matricula);
                    $resultado = $apiBs->doValence2('GET', '/d2l/api/lp/' . $param->valor . '/users/?orgDefinedId=' . $cliente->matricula);
                    //Muestra resultado
                    $r = $resultado[0];

                    $datos = ['isActive' => True];
                    if (isset($r['UserId'])) {
                        $resultado2 = $apiBs->doValence2('PUT', '/d2l/api/lp/' . $param->valor . '/users/' . $r['UserId'] . '/activation', $datos);
                        $bsBaja = BsBaja::where('cliente_id', $cliente->id)
                            ->where('bnd_baja', 1)
                            ->whereNull('bnd_reactivar')
                            ->first();
                        //dd($bsBaja);
                        if (!is_null($bsBaja)) {
                            if (isset($resultado2['IsActive']) and $resultado2['IsActive'] and !is_null($bsBaja)) {
                                $input['cliente_id'] = $cliente->id;
                                $input['fecha_reactivar'] = Date('Y-m-d');
                                $input['bnd_reactivar'] = 1;
                                $input['usu_mod_id'] = Auth::user()->id;
                                $bsBaja->update($input);
                            } else {
                                $input['cliente_id'] = $cliente->id;
                                $input['fecha_reactivar'] = Date('Y-m-d');
                                $input['bnd_reactivar'] = 0;
                                $input['usu_mod_id'] = Auth::user()->id;
                                $bsBaja->update($input);
                            }
                        }
                    }
                } catch (Exception $e) {
                    //$this->enviarMailFallaBs($e->getMessage(), "Error al repetir activar BS dede caja");
                    Log::info("cliente no encontrado en Brigth Space u otro error: " . $cliente->matricula . " - " . $e->getMessage());
                    //return false;
                }
            }
        }

        $combinaciones = CombinacionCliente::where('cliente_id', '=', $caja->cliente_id)->get();
        $empleados = Empleado::select(DB::raw('concat(nombre," ",ape_paterno," ",ape_materno) as name, id'))->pluck('name', 'id');

        $cajas = Caja::select('cajas.consecutivo as caja', 'cajas.fecha', 'ln.caja_concepto_id as concepto_id', 'cc.name as concepto', 'ln.total', 'st.name as estatus', 'ln.adeudo_id')
            ->join('caja_lns as ln', 'ln.caja_id', '=', 'cajas.id')
            ->join('caja_conceptos as cc', 'cc.id', '=', 'ln.caja_concepto_id')
            ->join('st_cajas as st', 'st.id', '=', 'cajas.st_caja_id')
            ->where('cliente_id', $cliente->id)
            ->where('ln.adeudo_id', '0')
            ->whereNull('cajas.deleted_at')
            ->whereNull('ln.deleted_at')
            ->get();


        return view('cajas.caja', compact('cliente', 'caja', 'combinaciones', 'cajas', 'empleados'))
            ->with('list', Caja::getListFromAllRelationApps())
            ->with('list1', CajaLn::getListFromAllRelationApps());
    }

    public function enviarMailFallaBs($msj, $asunto)
    {
        $from = "ohpelayo@gmail.com";
        $destinatario = "linares82@gmail.com";
        $contenido = $msj;
        $n = Auth::user()->name;

        //dd(env('MAIL_FROM_ADDRESS'));

        $data = array('contenido' => $msj, 'nombre' => $n, 'correo' => $from);
        $r = \Mail::send('correos.errorBs', $data, function ($message)
        use ($asunto, $destinatario, $n, $from) {
            $message->from(env('MAIL_FROM_ADDRESS', 'hola@grupocedva.com'), env('MAIL_FROM_NAME', 'Grupo CEDVA'));
            $message->to($destinatario, $n)->subject($asunto);
            $message->replyTo($from);
        });
    }

    public function cajaGeneral()
    {
        $empleado = Empleado::where('user_id', Auth::user()->id)->first();
        $planteles = $empleado->plantels->pluck('razon', 'id');
        $conceptos = CajaConcepto::where('bnd_concepto_sin_plan', 1)->whereNull('deleted_at')->pluck('name', 'id');
        return view('cajas.reportes.cajaGeneral', compact('planteles', 'conceptos'))
            ->with('list', Caja::getListFromAllRelationApps());
    }

    public function cajaGeneralR(Request $request)
    {
        $datos = $request->all();

        //dd($conceptos_validos);

        $registros = Caja::select(
            'pl.razon',
            'cajas.consecutivo',
            'c.matricula',
            DB::raw('concat(c.ape_paterno," ",c.ape_materno," ",c.nombre," ",c.nombre2) as cliente'),
            'p.fecha',
            'u.name as usuario',
            'cc.name as concepto',
            'fp.name as forma_pago',
            'cajas.total'
        )
            ->join('forma_pagos as fp', 'fp.id', '=', 'cajas.forma_pago_id')
            ->join('clientes as c', 'c.id', '=', 'cajas.cliente_id')
            ->join('plantels as pl', 'pl.id', '=', 'cajas.plantel_id')
            ->join('caja_lns as cln', 'cln.caja_id', '=', 'cajas.id')
            ->join('caja_conceptos as cc', 'cc.id', '=', 'cln.caja_concepto_id')
            ->join('pagos as p', 'p.caja_id', '=', 'cajas.id')
            ->join('users as u', 'u.id', '=', 'p.usu_alta_id')
            ->where('p.bnd_pagado', 1)
            ->where('cajas.st_caja_id', 1)
            ->whereIn('cc.id', $datos['concepto_f'])
            ->whereIn('pl.id', $datos['plantel_f'])
            ->where('p.fecha', ">=", $datos['fecha_f'])
            ->where('p.fecha', "<=", $datos['fecha_t'])
            ->whereNull('cajas.deleted_at')
            ->whereNull('cln.deleted_at')
            ->whereNull('p.deleted_at')
            ->orderBy('pl.razon')
            ->orderBy('cc.name')
            ->get();

        //dd($registros->toArray());

        return view(
            'cajas.reportes.cajaGeneralR',
            compact('registros', 'datos')
        );
    }

    public function actualizarAdeudosPagos(Request $request)
    {

        $datos = $request->all();
        //$plantel = Plantel::find($plantel);

        $adeudos = Adeudo::where('id', $datos['adeudo'])->get();
        //dd($adeudos->toArray());
        foreach ($adeudos as $adeudo) {
            $adeudo_pago_online = AdeudoPagoOnLine::where('adeudo_id', $adeudo->id)->orderBy('id', 'desc')->first();
            //dd($adeudo_pago_online);
            //$adeudo_pago_online = optional($adeudo)->pagoOnLine;

            $caja = $adeudo->caja;
            //dd($hoy->toDateString());
            $input['pago_id'] = (optional($adeudo->caja->pago)->id <> 0 ? optional($adeudo->caja->pago)->id : 0);
            $input['caja_id'] = (optional($adeudo->caja)->id <> 0 ? optional($adeudo->caja)->id : 0);
            $datos_calculados = $this->calculaPredefinido($adeudo->id, $caja->id);
            //dd($datos_calculados);
            $input['subtotal'] = $datos_calculados['subtotal'];
            $input['descuento'] = $datos_calculados['descuento'];
            $input['recargo'] = $datos_calculados['recargo'];
            $input['total'] = $datos_calculados['total'];
            $input['fecha_limite'] = $datos_calculados['fecha_limite'];
            //dd($input);
            $adeudo_pago_online->update($input);
            //dd($adeudo_pago_online);
            $this->updateCajaPagoPeticion($adeudo_pago_online->id);
        }


        $combinaciones = CombinacionCliente::where('cliente_id', '=', $caja->cliente_id)->get();
        $cliente = $caja->cliente;
        //dd($combinaciones);
        $empleados = Empleado::select(DB::raw('concat(nombre," ",ape_paterno," ",ape_materno) as name, id'))->pluck('name', 'id');

        $cajas = Caja::select('cajas.consecutivo as caja', 'cajas.fecha', 'ln.caja_concepto_id as concepto_id', 'cc.name as concepto', 'ln.total', 'st.name as estatus', 'ln.adeudo_id')
            ->join('caja_lns as ln', 'ln.caja_id', '=', 'cajas.id')
            ->join('caja_conceptos as cc', 'cc.id', '=', 'ln.caja_concepto_id')
            ->join('st_cajas as st', 'st.id', '=', 'cajas.st_caja_id')
            ->where('cliente_id', $caja->cliente_id)
            ->where('ln.adeudo_id', '0')
            ->whereNull('cajas.deleted_at')
            ->whereNull('ln.deleted_at')
            ->get();
        $caja = Caja::find($caja->id); //se vuelve a buscar para que actualice informacion
        // dd($caja);
        return view('cajas.caja', compact('cliente', 'caja', 'combinaciones', 'cajas', 'empleados'))
            ->with('list', Caja::getListFromAllRelationApps())
            ->with('list1', CajaLn::getListFromAllRelationApps());
    }

    public function calculaPredefinido($adeudo_tomado, $cja)
    {
        $adeudo = Adeudo::with('planPagoLn')->find($adeudo_tomado);
        //dd($conceptoceptosValidos);
        $caja = Caja::find($cja);

        //$adeudos = Adeudo::where('id', '=', $adeudo_tomado)->get();
        //dd($adeudo);

        $cliente = Cliente::with('autorizacionBecas')->find($adeudo->cliente_id);
        //dd($adeudos->toArray());

        //foreach ($adeudos as $adeudo) {
        $caja_ln['caja_concepto_id'] = $adeudo->caja_concepto_id;
        $caja_ln['subtotal'] = $adeudo->monto;
        $caja_ln['total'] = 0;
        $caja_ln['recargo'] = 0;
        $caja_ln['descuento'] = 0;
        $caja_ln['fecha_limite'] = "";
        //dd($caja_ln);

        //Realiza descuento para inscripciones
        $param = Param::where('llave', 'prefijo_matricula_instalacion')->first();
        if (($param->valor == 0 or $param->valor == "AZ") and
            isset(optional($adeudo->descuento)->id) and
            ($adeudo->caja_concepto_id == 1 or $adeudo->caja_concepto_id == 23 or $adeudo->caja_concepto_id == 25)
        ) {
            $caja_ln['descuento'] = $caja_ln['subtotal'] * $adeudo->descuento->porcentaje;
            /*}elseif (($param->valor=="TL")and
            isset(optional($adeudo->descuento)->id) and
            ($adeudo->caja_concepto_id == 1 or $adeudo->caja_concepto_id == 23 or $adeudo->caja_concepto_id == 25)
        ){
            //$caja_ln['descuento'] = $caja_ln['subtotal'] * $adeudo->descuento->porcentaje;
            //Por ahora tlane no hace nada
            */
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
            //dd($caja_ln);
            $beca_autorizada = AutorizacionBeca::find($beca_a);
            //dd($beca_autorizada);
            if (
                optional($beca_autorizada)->monto_mensualidad > 0 and
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
                $promociones = $adeudo->planPagoLn->promoPlanLns;
                //dd($promociones->toArray());
                //PromoPlanLn::where('plan_pago_ln_id', $adeudo->plan_pago_ln_id)->get();
                $caja_ln['promo_plan_ln_id'] = 0;
                //if ($beca_a == 0 and $adeudo->bnd_eximir_descuentos == 0) {
                if ($adeudo->bnd_eximir_descuentos == 0 or is_null($adeudo->bnd_eximir_descuentos)) {
                    foreach ($promociones as $promocion) {

                        $inicio = Carbon::createFromFormat('Y-m-d', $promocion->fec_inicio);
                        $fin = Carbon::createFromFormat('Y-m-d', $promocion->fec_fin);
                        //$hoy = Carbon::createFromFormat('Y-m-d', Date('Y-m-d'));
                        $hoy = Carbon::createFromFormat('Y-m-d', $caja->fecha);
                        $monto_promocion = 0;
                        //dd($hoy);
                        if ($inicio->lessThanOrEqualTo($hoy) and $fin->greaterThanOrEqualTo($hoy) and $caja_ln['promo_plan_ln_id'] == 0) {

                            $monto_promocion = $promocion->descuento * $caja_ln['total'];
                            $caja_ln['descuento'] = $caja_ln['descuento'] + $monto_promocion;
                            $caja_ln['total'] = $caja_ln['subtotal'] - $caja_ln['descuento'];

                            $caja_ln['promo_plan_ln_id'] = $promocion->id;
                            $caja_ln['fecha_limite'] = $promocion->fec_fin;
                        }
                        //}
                    }
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
            foreach ($adeudo->planPagoLn->reglaRecargos as $regla) {
                if ($adeudo->bnd_eximir_descuento_regla == 0 or is_null($adeudo->bnd_eximir_descuento_regla)) {
                    //dd($adeudo->planPagoLn->reglaRecargos->toArray());
                    $fecha_caja = Carbon::createFromFormat('Y-m-d', $caja->fecha);
                    $fecha_adeudo = Carbon::createFromFormat('Y-m-d', $adeudo->fecha_pago);
                    //dd($fecha_caja->greaterThanOrEqualTo($fecha_adeudo));
                    //if ($fecha_caja >= $fecha_adeudo) {
                    if ($fecha_caja->greaterThanOrEqualTo($fecha_adeudo)) {
                        $dias = $fecha_caja->diffInDays($fecha_adeudo);
                        //dd($dias);
                        if ($fecha_caja < $fecha_adeudo) {
                            $dias = $dias * -1;
                        }
                        //dd($dias);

                        //calcula recargo o descuento segun regla y aplica
                        //dd($dias >= $regla->dia_inicio and $dias <= $regla->dia_fin);
                        if ($dias >= $regla->dia_inicio and $dias <= $regla->dia_fin) {
                            //dd($fecha_adeudo);
                            if ($regla->dia_fin > 90) {
                                $caja_ln['fecha_limite'] = $fecha_adeudo->addDay(90)->toDateString();
                            } else {
                                $caja_ln['fecha_limite'] = $fecha_adeudo->addDay($regla->dia_fin - 1)->toDateString();
                            }

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
                        //dd($dias >= $regla->dia_inicio and $dias <= $regla->dia_fin);
                        if ($dias >= $regla->dia_inicio and $dias <= $regla->dia_fin) {
                            if ($regla->dia_fin > 60) {
                                $caja_ln['fecha_limite'] = $fecha_adeudo->addDay(60)->toDateString();
                            } else {
                                $caja_ln['fecha_limite'] = $fecha_adeudo->addDay($regla->dia_fin - 1)->toDateString();
                            }
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
                }
            } //end regla recargo descuento


            //********************************* */
            //Fin calculo descuento por regla
            //********************************* */


        }
        //dd($caja_ln);
        if (!isset($caja_ln['fecha_limite']) or $caja_ln['fecha_limite'] == "") {
            //dd($caja_ln);
            $fecha_aux = Carbon::createFromFormat('Y-m-d', $caja->fecha);
            //dd($fecha_aux);
            $fechaAdeudo = Carbon::createFromFormat('Y-m-d', $adeudo->fecha_pago);
            $dia = $fecha_aux->day;
            $mes = $fecha_aux->month;
            if (($dia >= 1 and $dia <= 10 and $mes == $fechaAdeudo->month) or
                ($dia >= 28 and $dia <= 31 and $mes <> $fechaAdeudo->month and $fechaAdeudo->lessThanOrEqualTo($fecha_aux)) or
                $fechaAdeudo->greaterThanOrEqualTo($fecha_aux)
            ) {
                $caja_ln['fecha_limite'] = Carbon::createFromFormat('Y-m-d', $adeudo->fecha_pago)->addDay(9)->toDateString();
            } else {
                $caja_ln['fecha_limite'] = date('Y-m-d');
            }
        }
        //dd($caja_ln);
        $caja_ln['total'] = $caja_ln['subtotal'] + $caja_ln['recargo'] - $caja_ln['descuento'];

        $caja_ln['adeudo_id'] = $adeudo->id;
        $caja_ln['usu_alta_id'] = Auth::user()->id;
        $caja_ln['usu_mod_id'] = Auth::user()->id;

        $caja_ln['subtotal'] = round($caja_ln['subtotal'], 0);
        $caja_ln['total'] = round($caja_ln['total'], 0);
        $caja_ln['recargo'] = round($caja_ln['recargo'], 0);
        $caja_ln['descuento'] = round($caja_ln['descuento'], 0);

        return $caja_ln;

        //}
    }

    public function updateCajaPagoPeticion($adeudo_pago_online_id)
    {
        //$datos = $request->all();
        //dd($datos);
        $adeudo_pago_online = AdeudoPagoOnLine::find($adeudo_pago_online_id);
        //dd($adeudo_pago_online);
        $plantel = Plantel::find($adeudo_pago_online->plantel_id);

        //Se crea registro de caja si no tiene
        if ($adeudo_pago_online->caja_id == 0 or is_null($adeudo_pago_online->caja_id)) {
        } else {
            $caja = $adeudo_pago_online->caja;
            //Caja::find($adeudo_pago_online->caja_id);
            $inputCaja['subtotal'] = $adeudo_pago_online->subtotal;
            $inputCaja['descuento'] = $adeudo_pago_online->descuento;
            $inputCaja['recargo'] = $adeudo_pago_online->recargo;
            $inputCaja['total'] = $adeudo_pago_online->total;
            //$inputCaja['forma_pago_id'] = $datos['forma_pago_id'];
            //$inputCaja['fecha'] = Carbon::createFromFormat('Y-m-d', $caja->created_at->toDateString());
            //dd($inputCaja);
            $caja->update($inputCaja);
        }

        //dd($caja);
        //Se crea linea de caja si no la tiene
        if ($adeudo_pago_online->caja_ln_id == 0 or is_null($adeudo_pago_online->caja_ln_id)) {
        } else {
            //$cajaLn = $adeudo_pago_online->cajaLn;
            //dd();
            $cajaLn = CajaLn::find($adeudo_pago_online->caja_ln_id);
            $inputCajaLn['subtotal'] = $adeudo_pago_online->subtotal;
            $inputCajaLn['descuento'] = $adeudo_pago_online->descuento;
            $inputCajaLn['recargo'] = $adeudo_pago_online->recargo;
            $inputCajaLn['total'] = $adeudo_pago_online->total;
            $cajaLn->update($inputCajaLn);
        }
        //dd($caja);

        //Se crea registro de pago si no lo tiene
        if ($adeudo_pago_online->pago_id == 0 or is_null($adeudo_pago_online->pago_id)) {
        } else {
            $pago = $adeudo_pago_online->pago;
            //dd($pago);
            //Pago::find($adeudo_pago_online->pago_id);
            $inputPago['monto'] = $caja->total;
            $inputPago['fecha'] = $caja->fecha;
            //$inputPago['forma_pago_id'] = $caja->forma_pago_id;
            //$inputPago['cuenta_efectivo_id'] = $this->getCuentasPlantelFormaPago($caja->forma_pago_id, $caja->plantel_id);
            $pago->update($inputPago);
        }
        //dd($adeudo_pago_online);

        //Se genera el registro peticion de pago
        if ($adeudo_pago_online->peticion_multipago_id == 0 or is_null($adeudo_pago_online->peticion_multipago_id)) {
        } else {
            $peticion_multipagos = $adeudo_pago_online->peticionMultipago;
            //$peticion_multipagos->contador_peticiones++;
            //$peticion_multipagos->save();


            //$parametros = Param::where('llave', 'mp_account')->first();
            //$datosMultipagos['mp_account'] = $parametros->valor;
            //$datosMultipagos['mp_product'] = $cajaLn->cajaConcepto->cve_multipagos;
            //$datosMultipagos['mp_order'] = $this->formatoDato('000', $caja->plantel_id) . $this->formatoDato('000000000', $caja->id) . $this->formatoDato('000000', $caja->consecutivo);
            //$datosMultipagos['mp_reference'] = $this->formatoDato('000', $caja->plantel_id) . $this->formatoDato('000000000', $pago->id) . $this->formatoDato('000000', $pago->consecutivo);

            //$datosMultipagos['mp_node'] = $plantel->cve_multipagos; //VAlor depente del plantel por ahora default
            //$datosMultipagos['mp_concept'] = 1; //Valor depende del caja_conceptos por ahora default

            $datosMultipagos['mp_amount'] = number_format((float) $pago->monto, 2, '.', '');

            /*$datosMultipagos['mp_currency'] = 1;
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
            $datosMultipagos['mp_paymentmethod'] = $pago->formaPago->cve_multipagos;
            */
            //dd($adeudo_pago_online);
            $datosMultipagos['mp_datereference'] = $adeudo_pago_online->fecha_limite;

            $peticion_multipagos->update($datosMultipagos);
            //dd($peticion_multipagos);
        }
    }

    public function consultaStBs(Request $request)
    {
        $data = $request->all();
        $param = Param::where('llave', 'apiVersion_bSpace')->first();
        $bs_activo = Param::where('llave', 'api_brightSpace_activa')->first();
        try {
            $apiBs = new UsoApi();

            //dd($datos);
            //Log::info('matricula bs reactivar en caja:'.$cliente->matricula);
            $resultado = $apiBs->doValence2('GET', '/d2l/api/lp/' . $param->valor . '/users/?orgDefinedId=' . $data['matricula']);
            //Muestra resultado
            $r = $resultado[0];
            $datos = ['isActive' => True];
            if (!isset($r['UserId'])) {
                return json_encode(array('resultado' => 'no encontrado'));
            } else {
                return $resultado;
            }
        } catch (Exception $e) {
            Log::info("cliente no encontrado en Brigth Space u otro error: " . $e->getMessage());
            //return false;
        }
    }
}
