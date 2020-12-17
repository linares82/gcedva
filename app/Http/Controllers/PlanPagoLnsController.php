<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\createPlanPagoLn;
use App\Http\Requests\updatePlanPagoLn;
use App\Adeudo;
use App\PlanPagoLn;
use App\ReglaRecargo;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Validator;

class PlanPagoLnsController extends Controller
{
    protected $rules =
        [

    ];
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $planPagoLns = PlanPagoLn::getAllData($request);

        return view('planPagoLns.index', compact('planPagoLns'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('planPagoLns.create')
            ->with('list', PlanPagoLn::getListFromAllRelationApps());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(createPlanPagoLn $request)
    {
        /*$input = $request->all();
        $input['usu_alta_id']=Auth::user()->id;
        $input['usu_mod_id']=Auth::user()->id;
        if(!isset($input['inicial_bnd'])){
        $input['inicial_bnd']=0;
        }else{
        $input['inicial_bnd']=1;
        }

        //create data
        PlanPagoLn::create( $input );

        return redirect()->route('planPagoLns.index')->with('message', 'Registro Creado.');*/
        $validator = Validator::make(Input::all(), $this->rules);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
            $input = $request->all();
            $input['usu_alta_id'] = Auth::user()->id;
            $input['usu_mod_id'] = Auth::user()->id;

            //create data
            $creado = PlanPagoLn::create($input);
            //dd($creado->cuentaRecargo->name);
            $nuevo = PlanPagoLn::find($creado->id);
            $registro['id'] = $nuevo->id;
            $registro['plan_pago_id'] = $nuevo->plan_pago_id;
            $registro['caja_concepto'] = $nuevo->cajaConcepto->name;
            $registro['caja_concepto_id'] = $nuevo->caja_concepto_id;
            $registro['cuenta_contable'] = $nuevo->cuentaContable->name;
            $registro['cuenta_contable_id'] = $nuevo->cuenta_contable_id;
            $registro['cuenta_recargo'] = $nuevo->cuentaRecargo->name;
            $registro['cuenta_recargo_id'] = $nuevo->cuenta_recargo_id;
            $registro['fecha_pago'] = $nuevo->fecha_pago;
            $registro['monto'] = $nuevo->monto;
            $registro['inicial_bnd'] = $nuevo->inicial_bnd;
            return response()->json($registro);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id, PlanPagoLn $planPagoLn)
    {
        $planPagoLn = $planPagoLn->find($id);
        return view('planPagoLns.show', compact('planPagoLn'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id, PlanPagoLn $planPagoLn)
    {
        $planPagoLn = $planPagoLn->find($id);
        return view('planPagoLns.edit', compact('planPagoLn'))
            ->with('list', PlanPagoLn::getListFromAllRelationApps());
    }

    /**
     * Show the form for duplicatting the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function duplicate($id, PlanPagoLn $planPagoLn)
    {
        $planPagoLn = $planPagoLn->find($id);
        return view('planPagoLns.duplicate', compact('planPagoLn'))
            ->with('list', PlanPagoLn::getListFromAllRelationApps());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param Request $request
     * @return Response
     */
    public function update($id, PlanPagoLn $planPagoLn, updatePlanPagoLn $request)
    {
        /*$input = $request->all();
        $input['usu_mod_id']=Auth::user()->id;
        if(!isset($input['inicial_bnd'])){
        $input['inicial_bnd']=0;
        }else{
        $input['inicial_bnd']=1;
        }
        //update data
        $planPagoLn=$planPagoLn->find($id);
        $planPagoLn->update( $input );

        return redirect()->route('planPagoLns.index')->with('message', 'Registro Actualizado.');
         *
         */
        $validator = Validator::make(Input::all(), $this->rules);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
            $planPagoLn = $planPagoLn->find($id);
            $input = $request->all();
            $input['usu_alta_id'] = Auth::user()->id;
            $input['usu_mod_id'] = Auth::user()->id;

            //dd($input);
            $planPagoLn->update($input);
            $nuevo = $planPagoLn->find($id);
            $registro['id'] = $nuevo->id;
            $registro['plan_pago_id'] = $nuevo->plan_pago_id;
            $registro['caja_concepto'] = $nuevo->cajaConcepto->name;
            $registro['caja_concepto_id'] = $nuevo->caja_concepto_id;
            $registro['cuenta_contable'] = $nuevo->cuentaContable->name;
            $registro['cuenta_contable_id'] = $nuevo->cuenta_contable_id;
            $registro['cuenta_recargo'] = $nuevo->cuentaRecargo->name;
            $registro['cuenta_recargo_id'] = $nuevo->cuenta_recargo_id;
            $registro['fecha_pago'] = $nuevo->fecha_pago;
            $registro['monto'] = $nuevo->monto;
            $registro['inicial_bnd'] = $nuevo->inicial_bnd;
            return response()->json($registro);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id, PlanPagoLn $planPagoLn)
    {
        $nuevo = $planPagoLn->find($id);

        $registro['id'] = $nuevo->id;
        $registro['plan_pago_id'] = $nuevo->plan_pago_id;
        $registro['caja_concepto'] = $nuevo->cajaConcepto->name;
        $registro['caja_concepto_id'] = $nuevo->caja_concepto_id;
        $registro['cuenta_contable'] = $nuevo->cuentaContable->name;
        $registro['cuenta_contable_id'] = $nuevo->cuenta_contable_id;
        $registro['cuenta_recargo'] = $nuevo->cuentaRecargo->name;
        $registro['cuenta_recargo_id'] = $nuevo->cuenta_recargo_id;
        $registro['fecha_pago'] = $nuevo->fecha_pago;
        $registro['monto'] = $nuevo->monto;
        $registro['inicial_bnd'] = $nuevo->inicial_bnd;

        $nuevo->delete();
        //dd($registro);
        return response()->json($registro);
        //return redirect()->route('planPagoLns.index')->with('message', 'Registro Borrado.');
    }

    public function addRegla(Request $request)
    {
        if ($request->ajax()) {
            //dd($request->get('regla'));
            $regla = $request->get('regla');
            $linea = $request->get('linea');
            $planPagoLinea = PlanPagoLn::findOrFail($linea);
            $planPagoLinea->reglaRecargos()->attach($regla);
        }
    }

    public function lessRegla(Request $request)
    {
        //dd($request);
        if ($request->ajax()) {
            $regla = $request->get('regla');
            $linea = $request->get('linea');
            $planPagoLinea = PlanPagoLn::findOrFail($linea);
            $planPagoLinea->reglaRecargos()->detach($regla);
        }
    }

    public function getCmbConceptosPlan(Request $request)
    {
        if ($request->ajax()) {
            //dd($request->all());
            $plan = $request->get('plan_f');

            $final = array();
            $r = DB::table('plan_pagos as p')
                ->join('plan_pago_lns as pl', 'pl.plan_pago_id', '=', 'p.id')
                ->join('caja_conceptos as c', 'c.id', '=', 'pl.caja_concepto_id')
                ->select('c.id', 'c.name')
                ->where('p.id', '=', $plan)
                ->where('p.id', '>', '0')
                ->distinct()
                ->get();
            //dd($r);

            foreach ($r as $r1) {

                array_push($final, array('id' => $r1->id,
                    'name' => $r1->name,
                    'selectec' => ''));

            }
            return $final;

        }
    }

    public function extenderEdicion(Request $request){
        $datos=$request->all();
        //dd($datos);
        $linea=PlanPagoLn::find($datos['linea']);
        $adeudos=Adeudo::where('plan_pago_ln_id', $datos['linea'])
        ->where('pagado_bnd','<>',1)
        ->whereNull('deleted_at')
        ->get();
        //dd($adeudos);
        foreach($adeudos as $adeudo){
            $adeudo->monto=$linea->monto;
            $adeudo->save();
        }
        //dd('fil');
        $planPago = $linea->planPago;
        //dd($planPago);
        //dd($planPago->lineas->toArray());
        $reglaRecargo = ReglaRecargo::pluck('name', 'id');
        
        return view('planPagos.show', compact('planPago', 'reglaRecargo'))->with('list', PlanPagoLn::getListFromAllRelationApps());
    }

}
