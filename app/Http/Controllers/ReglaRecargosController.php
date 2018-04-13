<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\ReglaRecargo;
use App\PlanPagoLn;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateReglaRecargo;
use App\Http\Requests\createReglaRecargo;

class ReglaRecargosController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request) {
        $reglaRecargos = ReglaRecargo::getAllData($request);

        return view('reglaRecargos.index', compact('reglaRecargos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        return view('reglaRecargos.create')
                        ->with('list', ReglaRecargo::getListFromAllRelationApps());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(createReglaRecargo $request) {

        $input = $request->all();
        $input['usu_alta_id'] = Auth::user()->id;
        $input['usu_mod_id'] = Auth::user()->id;

        //create data
        ReglaRecargo::create($input);

        return redirect()->route('reglaRecargos.index')->with('message', 'Registro Creado.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id, ReglaRecargo $reglaRecargo) {
        $reglaRecargo = $reglaRecargo->find($id);
        return view('reglaRecargos.show', compact('reglaRecargo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id, ReglaRecargo $reglaRecargo) {
        $reglaRecargo = $reglaRecargo->find($id);
        return view('reglaRecargos.edit', compact('reglaRecargo'))
                        ->with('list', ReglaRecargo::getListFromAllRelationApps());
    }

    /**
     * Show the form for duplicatting the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function duplicate($id, ReglaRecargo $reglaRecargo) {
        $reglaRecargo = $reglaRecargo->find($id);
        return view('reglaRecargos.duplicate', compact('reglaRecargo'))
                        ->with('list', ReglaRecargo::getListFromAllRelationApps());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param Request $request
     * @return Response
     */
    public function update($id, ReglaRecargo $reglaRecargo, updateReglaRecargo $request) {
        $input = $request->all();
        $input['usu_mod_id'] = Auth::user()->id;
        //update data
        $reglaRecargo = $reglaRecargo->find($id);
        $reglaRecargo->update($input);

        return redirect()->route('reglaRecargos.index')->with('message', 'Registro Actualizado.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id, ReglaRecargo $reglaRecargo) {
        $reglaRecargo = $reglaRecargo->find($id);
        $reglaRecargo->delete();

        return redirect()->route('reglaRecargos.index')->with('message', 'Registro Borrado.');
    }

    public function getReglasXLinea(Request $request) {
        if ($request->ajax()) {
            $ln=$request->get('linea');
            $planPagoLn= PlanPagoLn::find($ln);
            $resultado=array();
            foreach($planPagoLn->reglaRecargos as $regla){
                array_push($resultado, array('id'=>$regla->id, 'name'=>$regla->name, 'selectec'=>''));
            }
            //dd($planPagoLn->reglaRecargos);
            echo json_encode($resultado);
        }
    }
    
    public function getNoReglasXLinea(Request $request) {
        if ($request->ajax()) {
            $ln=$request->get('linea');
            $planPagoLn= PlanPagoLn::find($ln);
            $resultado=array();
            foreach($planPagoLn->reglaRecargos as $regla){
                array_push($resultado, array('id'=>$regla->id));
            }
            $reglas=ReglaRecargo::whereNotIn('id', $resultado)->get();
            $registros=array();
            foreach($reglas as $regla){
                array_push($registros, array('id'=>$regla->id, 'name'=>$regla->name, 'selectec'=>''));
            }
            //dd($planPagoLn->reglaRecargos);
            echo json_encode($registros);
        }
    }

}
