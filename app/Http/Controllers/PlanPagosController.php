<?php

namespace App\Http\Controllers;

use App\CajaConcepto;
use App\Http\Controllers\Controller;
use App\Http\Requests\createPlanPago;
use App\Http\Requests\updatePlanPago;
use App\PlanPago;
use App\PlanPagoLn;
use App\PromoPlanLn;
use App\ReglaRecargo;
use App\Turno;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PlanPagosController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $planPagos = PlanPago::getAllData($request);

        return view('planPagos.index', compact('planPagos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('planPagos.create')
            ->with('list', PlanPago::getListFromAllRelationApps());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(createPlanPago $request)
    {

        $input = $request->all();
        $input['usu_alta_id'] = Auth::user()->id;
        $input['usu_mod_id'] = Auth::user()->id;

        if (isset($input['activo'])) {
            $input['activo'] = 1;
        } else {
            $input['activo'] = 0;
        }

        //create data
        $p = PlanPago::create($input);

        return redirect()->route('planPagos.edit', $p->id)->with('message', 'Registro Creado.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id, PlanPago $planPago)
    {
        $planPago = $planPago->find($id);
        //dd($planPago->lineas->toArray());
        $reglaRecargo = ReglaRecargo::pluck('name', 'id');
        //$reglaRecargosRelacionados= $planPago->planPagoLn->reglaRecargos();
        //dd($reglaRecargo);
        return view('planPagos.show', compact('planPago', 'reglaRecargo'))->with('list', PlanPagoLn::getListFromAllRelationApps());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id, PlanPago $planPago)
    {
        $planPago = $planPago->find($id);
        return view('planPagos.edit', compact('planPago'))
            ->with('list', PlanPago::getListFromAllRelationApps())
            ->with('list2', PlanPagoLn::getListFromAllRelationApps());
    }

    /**
     * Show the form for duplicatting the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function duplicate($id, PlanPago $planPago)
    {
        $planPago = $planPago->find($id);
        return view('planPagos.duplicate', compact('planPago'))
            ->with('list', PlanPago::getListFromAllRelationApps());
    }

    public function fullDuplicate(Request $request)
    {
        $input = $request->except('id_duplicado', 'fecha_pago', 'linea_id');
        $id_duplicado = $request->only('id_duplicado');
        $fecha_pago = $request->only('fecha_pago');
        $linea_tiempo = $request->only('linea_id');
        //dd($linea);
        $input['usu_alta_id'] = Auth::user()->id;
        $input['usu_mod_id'] = Auth::user()->id;

        if (isset($input['activo'])) {
            $input['activo'] = 1;
        } else {
            $input['activo'] = 0;
        }

        //create data
        $plan_nuevo = PlanPago::create($input);
        $plan_base = PlanPago::find($id_duplicado);
        //dd($plan_base);
        $plan_base_lineas = PlanPagoLn::where('plan_pago_id', $id_duplicado)->get();
        //dd($plan_base_lineas->toArray());
        $meses = 0;
        $dia = 0;
        foreach ($plan_base_lineas as $linea) {
            if ($meses == 0) {
                $fecha_nueva = Carbon::createFromFormat('Y-m-d', $fecha_pago['fecha_pago']);
                $fecha_anterior = Carbon::createFromFormat('Y-m-d', $linea->fecha_pago);
                $meses = ($fecha_nueva->diffInMonths($fecha_anterior) * $linea_tiempo['linea_id']);
                $dia = $fecha_nueva->day;
            }
            //dd($meses);
            $input_ln['plan_pago_id'] = $plan_nuevo->id;
            $input_ln['caja_concepto_id'] = $linea->caja_concepto_id;
            $input_ln['cuenta_contable_id'] = $linea->cuenta_contable_id;
            $input_ln['cuenta_recargo_id'] = $linea->cuenta_recargo_id;
            $fecha_p = Carbon::createFromFormat('Y-m-d', $linea->fecha_pago);
            $input_ln['fecha_pago'] = $fecha_p->addMonths($meses)->toDateString();
            $input_ln['monto'] = $linea->monto;
            $input_ln['inicial_bnd'] = $linea->inicial_bnd;
            $input_ln['usu_alta_id'] = Auth::user()->id;
            $input_ln['usu_mod_id'] = Auth::user()->id;

            //dd($input_ln);
            $ln = PlanPagoLn::create($input_ln);

            foreach ($linea->reglaRecargos as $regla) {
                /*$input_regla_nueva['plan_pago_ln_id'] = $ln->id;
                $input_regla_nueva['regla_recargo_id'] = $regla->id;
                $regla_nueva = PlanPagoLnReglaRecargo::create($input_regla_nueva);
                 */
                $ln->reglaRecargos()->attach($regla->id);
            }
            foreach ($linea->promoPlanLns as $promo) {
                $input_promocion['plan_pago_ln_id'] = $ln->id;
                $fec_i = Carbon::createFromFormat('Y-m-d', $promo->fec_inicio);
                $input_promocion['fec_inicio'] = $fec_i->addMonths($meses)->toDateString();
                $fec_f = Carbon::createFromFormat('Y-m-d', $promo->fec_fin);
                $input_promocion['fec_fin'] = $fec_f->addMonths($meses)->toDateString();
                $input_promocion['descuento'] = $promo->descuento;
                $input_promocion['usu_alta_id'] = Auth::user()->id;
                $input_promocion['usu_mod_id'] = Auth::user()->id;
                $promocion = PromoPlanLn::create($input_promocion);
            }
        }

        return redirect()->route('planPagos.show', $plan_nuevo->id)->with('message', 'Registro Creado.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param Request $request
     * @return Response
     */
    public function update($id, PlanPago $planPago, updatePlanPago $request)
    {
        //dd($request->all());
        $input = $request->only('name', 'activo');
        $input['usu_mod_id'] = Auth::user()->id;
        $generar_pagos = $request->only('inscripcion', 'uniforme', 'tramites', 'mensualidad', 'cuantas_mensualidad', 'fecha_pago', 'seguro');
        $lineas = $request->except('name', 'activo', 'inscripcion', 'uniforme', 'tramites', 'mensualidad', 'cuantas_mensualidad', 'fecha_pago', 'seguro');
        //dd($lineas);
        if (isset($input['activo'])) {
            $input['activo'] = 1;
        } else {
            $input['activo'] = 0;
        }
        //update data
        //dd($input);
        $planPago = $planPago->find($id);
        $planPago->update($input);
        //dd($request->all());
        if (
            isset($generar_pagos['inscripcion']) and $generar_pagos['inscripcion'] != null and
            isset($generar_pagos['uniforme']) and $generar_pagos['uniforme'] != null and
            isset($generar_pagos['tramites']) and $generar_pagos['tramites'] != null and
            isset($generar_pagos['mensualidad']) and $generar_pagos['mensualidad'] != null and
            isset($generar_pagos['cuantas_mensualidad']) and $generar_pagos['cuantas_mensualidad'] != null and
            isset($generar_pagos['fecha_pago']) and $generar_pagos['fecha_pago'] != null and
            isset($generar_pagos['seguro']) and $generar_pagos['seguro'] != null
        ) {

            $inscripcion = new PlanPagoLn;
            $inscripcion->plan_pago_id = $planPago->id;
            $inscripcion->caja_concepto_id = 1;
            $inscripcion->cuenta_contable_id = 1;
            $inscripcion->cuenta_recargo_id = 1;
            $inscripcion->fecha_pago = $generar_pagos['fecha_pago'];
            $inscripcion->monto = $generar_pagos['inscripcion'];
            $inscripcion->inicial_bnd = 1;
            $inscripcion->usu_alta_id = Auth::user()->id;
            $inscripcion->usu_mod_id = Auth::user()->id;
            $inscripcion->save();

            //for($i=1;$i<=$generar_pagos['cuantas_seguro'];$i++){
            $seguro = new PlanPagoLn;
            $seguro->plan_pago_id = $planPago->id;
            $seguro->caja_concepto_id = 2;
            $seguro->cuenta_contable_id = 4;
            $seguro->cuenta_recargo_id = 4;
            $seguro->fecha_pago = $generar_pagos['fecha_pago'];
            $seguro->monto = $generar_pagos['seguro'];
            $seguro->inicial_bnd = 1;
            $seguro->usu_alta_id = Auth::user()->id;
            $seguro->usu_mod_id = Auth::user()->id;
            $seguro->save();
            //}

            $uniforme = new PlanPagoLn;
            $uniforme->plan_pago_id = $planPago->id;
            $uniforme->caja_concepto_id = 3;
            $uniforme->cuenta_contable_id = 3;
            $uniforme->cuenta_recargo_id = 3;
            $uniforme->fecha_pago = $generar_pagos['fecha_pago'];
            $uniforme->monto = $generar_pagos['uniforme'];
            $uniforme->inicial_bnd = 1;
            $uniforme->usu_alta_id = Auth::user()->id;
            $uniforme->usu_mod_id = Auth::user()->id;
            $uniforme->save();

            //$fin_contrato=Carbon::createFromFormat('Y-m-d', $e->fin_contrato)->toDateTimeString();

            $mes = Carbon::createFromFormat('Y-m-d', $generar_pagos['fecha_pago'])->month;
            $concepto = 0;
            switch ($mes) {
                case 1:
                    $concepto = 5;
                    break;
                case 2:
                    $concepto = 6;
                    break;
                case 3:
                    $concepto = 7;
                    break;
                case 4:
                    $concepto = 8;
                    break;
                case 5:
                    $concepto = 9;
                    break;
                case 6:
                    $concepto = 10;
                    break;
                case 7:
                    $concepto = 11;
                    break;
                case 8:
                    $concepto = 12;
                    break;
                case 9:
                    $concepto = 13;
                    break;
                case 10:
                    $concepto = 14;
                    break;
                case 11:
                    $concepto = 15;
                    break;
                case 12:
                    $concepto = 16;
                    break;
            }
            $fecha_pago = Carbon::createFromFormat('Y-m-d', $generar_pagos['fecha_pago']);

            for ($i = 1; $i <= $generar_pagos['cuantas_mensualidad']; $i++) {
                $mensualidad = new PlanPagoLn;
                $mensualidad->plan_pago_id = $planPago->id;
                $mensualidad->caja_concepto_id = $concepto;
                $mensualidad->cuenta_contable_id = 2;
                $mensualidad->cuenta_recargo_id = 2;
                $mensualidad->fecha_pago = $fecha_pago->toDateTimeString();
                $mensualidad->monto = $generar_pagos['mensualidad'];
                $mensualidad->inicial_bnd = 0;
                $mensualidad->usu_alta_id = Auth::user()->id;
                $mensualidad->usu_mod_id = Auth::user()->id;
                $mensualidad->save();

                $mensualidad->reglaRecargos()->attach(1);
                $mensualidad->reglaRecargos()->attach(2);

                //identifica la cantidad de meses y recrea conceptos de inscricion
                //y seguro
                if ($i == 12 or $i == 24 or $i == 36) {
                    $inscripcion = new PlanPagoLn;
                    $inscripcion->plan_pago_id = $planPago->id;
                    $inscripcion->caja_concepto_id = 4;
                    $inscripcion->cuenta_contable_id = 1;
                    $inscripcion->cuenta_recargo_id = 1;
                    $inscripcion->fecha_pago = $fecha_pago->toDateTimeString();
                    $inscripcion->monto = $generar_pagos['inscripcion'];
                    $inscripcion->inicial_bnd = 1;
                    $inscripcion->usu_alta_id = Auth::user()->id;
                    $inscripcion->usu_mod_id = Auth::user()->id;
                    $inscripcion->save();
                }

                if ($i == 6 or $i == 12 or $i == 18 or $i == 24 or $i == 30 or $i == 36) {
                    $seguro = new PlanPagoLn;
                    $seguro->plan_pago_id = $planPago->id;
                    $seguro->caja_concepto_id = 2;
                    $seguro->cuenta_contable_id = 4;
                    $seguro->cuenta_recargo_id = 4;
                    $seguro->fecha_pago = $fecha_pago->toDateTimeString();
                    $seguro->monto = $generar_pagos['seguro'];
                    $seguro->inicial_bnd = 1;
                    $seguro->usu_alta_id = Auth::user()->id;
                    $seguro->usu_mod_id = Auth::user()->id;
                    $seguro->save();
                }

                if ($concepto == 16) {
                    $concepto = 5;
                } else {
                    $concepto++;
                }
                $fecha_pago->addMonth();
            }

            $tramites = new PlanPagoLn;
            $tramites->plan_pago_id = $planPago->id;
            $tramites->caja_concepto_id = 17;
            $tramites->cuenta_contable_id = 2;
            $tramites->cuenta_recargo_id = 2;
            $tramites->fecha_pago = $generar_pagos['fecha_pago'];
            $tramites->monto = $generar_pagos['tramites'];
            $tramites->inicial_bnd = 1;
            $tramites->usu_alta_id = Auth::user()->id;
            $tramites->usu_mod_id = Auth::user()->id;
            $tramites->save();
        } else {
            //dd($lineas);
            for ($i = 0; $i < count($lineas['plan_pago_id']); $i++) {
                if ($lineas['plan_pago_id'][$i] > 0 and
                    $lineas['caja_concepto_id'][$i] > 0 and
                    $lineas['cuenta_contable_id'][$i] and
                    $lineas['cuenta_recargo_id'][$i] and
                    $lineas['fecha_p'][$i] != 0 and
                    $lineas['monto'][$i] > 0) {
                    $ln_input['plan_pago_id'] = $lineas['plan_pago_id'][$i];
                    $ln_input['caja_concepto_id'] = $lineas['caja_concepto_id'][$i];
                    $ln_input['cuenta_contable_id'] = $lineas['cuenta_contable_id'][$i];
                    $ln_input['cuenta_recargo_id'] = $lineas['cuenta_recargo_id'][$i];
                    $ln_input['fecha_pago'] = $lineas['fecha_p'][$i];
                    $ln_input['monto'] = $lineas['monto'][$i];
                    $ln_input['inicial_bnd'] = 0;
                    $ln_input['usu_alta_id'] = Auth::user()->id;
                    $ln_input['usu_mod_id'] = Auth::user()->id;
                    $linea = PlanPagoLn::create($ln_input);
                    $concepto = CajaConcepto::find($ln_input['caja_concepto_id']);
                    foreach ($concepto->reglas as $regla) {
                        $linea->reglaRecargos()->attach($regla->id);
                    }
                }
            }

        }

        return redirect()->route('planPagos.show', $planPago->id)->with('message', 'Registro Actualizado.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id, PlanPago $planPago)
    {
        $planPago = $planPago->find($id);
        $planPago->delete();

        return redirect()->route('planPagos.index')->with('message', 'Registro Borrado.');
    }

    public function getPlanPago(Request $request)
    {
        $datos = $request->all();

        $turno = Turno::find($datos['turno']);

        return $turno->plan_pago_id;
    }
}
