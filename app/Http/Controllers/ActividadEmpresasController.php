<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\ActividadEmpresa;
use App\Especialidad;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\Http\Requests\updateActividadEmpresa;
use App\Http\Requests\createActividadEmpresa;

class ActividadEmpresasController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request) {
        $actividadEmpresas = ActividadEmpresa::getAllData($request);

        return view('actividadEmpresas.index', compact('actividadEmpresas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $p = DB::table('plantels as p')
                        ->join('empleados as e', 'e.plantel_id', '=', 'p.id')
                        ->where('e.user_id', Auth::user()->id)->value('p.id');
        $especialidadList = Especialidad::where('plantel_id', '=', $p)->pluck('name', 'id');
        //dd($especialidadList);
        return view('actividadEmpresas.create', compact('especialidadList'))
                        ->with('list', ActividadEmpresa::getListFromAllRelationApps());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(createActividadEmpresa $request) {

        $input = $request->all();
        $input['usu_alta_id'] = Auth::user()->id;
        $input['usu_mod_id'] = Auth::user()->id;
        $input['plantel_id'] = DB::table('plantels as p')
                        ->join('empleados as e', 'e.plantel_id', '=', 'p.id')
                        ->where('e.user_id', Auth::user()->id)->value('p.id');

        //create data
        ActividadEmpresa::create($input);

        return redirect()->route('actividadEmpresas.index')->with('message', 'Registro Creado.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id, ActividadEmpresa $actividadEmpresa) {
        $actividadEmpresa = $actividadEmpresa->find($id);
        return view('actividadEmpresas.show', compact('actividadEmpresa'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id, ActividadEmpresa $actividadEmpresa) {
        $p = DB::table('plantels as p')
                        ->join('empleados as e', 'e.plantel_id', '=', 'p.id')
                        ->where('e.user_id', Auth::user()->id)->value('p.id');
        $especialidadList = Especialidad::where('plantel_id', '=', $p)->pluck('name', 'id');
        $actividadEmpresa = $actividadEmpresa->find($id);
        return view('actividadEmpresas.edit', compact('actividadEmpresa', 'especialidadList'))
                        ->with('list', ActividadEmpresa::getListFromAllRelationApps());
    }

    /**
     * Show the form for duplicatting the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function duplicate($id, ActividadEmpresa $actividadEmpresa) {
        $actividadEmpresa = $actividadEmpresa->find($id);
        return view('actividadEmpresas.duplicate', compact('actividadEmpresa'))
                        ->with('list', ActividadEmpresa::getListFromAllRelationApps());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param Request $request
     * @return Response
     */
    public function update($id, ActividadEmpresa $actividadEmpresa, updateActividadEmpresa $request) {
        $input = $request->all();
        $input['usu_mod_id'] = Auth::user()->id;
        $input['plantel_id'] = DB::table('plantels as p')
                        ->join('empleados as e', 'e.plantel_id', '=', 'p.id')
                        ->where('e.user_id', Auth::user()->id)->value('p.id');
        //update data
        $actividadEmpresa = $actividadEmpresa->find($id);
        $actividadEmpresa->update($input);

        return redirect()->route('actividadEmpresas.index')->with('message', 'Registro Actualizado.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id, ActividadEmpresa $actividadEmpresa) {
        $actividadEmpresa = $actividadEmpresa->find($id);
        $actividadEmpresa->delete();

        return redirect()->route('actividadEmpresas.index')->with('message', 'Registro Borrado.');
    }

    public function getCmbActividad(Request $request) {
        if ($request->ajax()) {
            //dd($request->get('plantel_id'));
            $plantel = $request->get('plantel_id');
            $especialidad = $request->get('especialidad_id');
            $actividad = $request->get('nivel_id');
            $final = array();
            $r = DB::table('actividad_empresas as n')
                    ->select('n.id', 'n.name')
                    ->where('n.plantel_id', '=', $plantel)
                    ->where('n.especialidad_id', '=', $especialidad)
                    ->where('n.id', '>', '0')
                    ->get();
            //dd($r);
            if (isset($nivel) and $nivel <> 0) {
                foreach ($r as $r1) {
                    if ($r1->id == $nivel) {
                        array_push($final, array('id' => $r1->id,
                            'name' => $r1->name,
                            'selectec' => 'Selected'));
                    } else {
                        array_push($final, array('id' => $r1->id,
                            'name' => $r1->name,
                            'selectec' => ''));
                    }
                }
                return $final;
            } else {
                return $r;
            }
        }
    }
}
