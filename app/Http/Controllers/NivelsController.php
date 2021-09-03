<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\Nivel;
use App\Plantel;
use Illuminate\Http\Request;
use App\Http\Requests\createNivel;
use App\Http\Requests\updateNivel;
use App\Http\Controllers\Controller;

class NivelsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $nivels = Nivel::getAllData($request);

        return view('nivels.index', compact('nivels'))
            ->with('list', Nivel::getListFromAllRelationApps());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('nivels.create')
            ->with('list', Nivel::getListFromAllRelationApps());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(createNivel $request)
    {

        $input = $request->all();
        $input['usu_alta_id'] = Auth::user()->id;
        $input['usu_mod_id'] = Auth::user()->id;

        //create data
        Nivel::create($input);

        return redirect()->route('nivels.index')->with('message', 'Registro Creado.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id, Nivel $nivel)
    {
        $nivel = $nivel->find($id);
        return view('nivels.show', compact('nivel'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id, Nivel $nivel)
    {
        $nivel = $nivel->find($id);
        return view('nivels.edit', compact('nivel'))
            ->with('list', Nivel::getListFromAllRelationApps());
    }

    /**
     * Show the form for duplicatting the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function duplicate($id, Nivel $nivel)
    {
        $nivel = $nivel->find($id);
        return view('nivels.duplicate', compact('nivel'))
            ->with('list', Nivel::getListFromAllRelationApps());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param Request $request
     * @return Response
     */
    public function update($id, Nivel $nivel, updateNivel $request)
    {
        $input = $request->all();
        $input['usu_mod_id'] = Auth::user()->id;
        //update data
        $nivel = $nivel->find($id);
        $nivel->update($input);

        return redirect()->route('nivels.index')->with('message', 'Registro Actualizado.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id, Nivel $nivel)
    {
        $nivel = $nivel->find($id);
        if($nivel->combinacionClientes->count==0){
            $nivel->delete();
            return redirect()->route('nivels.index')->with('message', 'Registro Borrado.');
        }
        

        return redirect()->route('nivels.index')->with('message', 'Registro en uso, no se pudo Borrar.');
    }

    public function getCmbGrados($id = 0)
    {
        //dd($_REQUEST['estado']);
        $e = $_REQUEST['nivel'];
        $grados = Nivel::find($e)->grados;
        //dd($municipios);
        return $grados->pluck('name', 'id');
    }

    public function getCmbNivels(Request $request)
    {
        if ($request->ajax()) {
            //dd($request->get('plantel_id'));
            $plantel = $request->get('plantel_id');
            $especialidad = $request->get('especialidad_id');
            $nivel = $request->get('nivel_id');
            $final = array();
            $r = DB::table('nivels as n')
                ->select('n.id', 'n.name')
                ->where('n.plantel_id', '=', $plantel)
                ->where('n.especialidad_id', '=', $especialidad)
                ->where('n.id', '>', '0')
                ->whereNull('deleted_at')
                ->get();
            //dd($r);
            if (isset($nivel) and $nivel != 0) {
                foreach ($r as $r1) {
                    if ($r1->id == $nivel) {
                        array_push($final, array(
                            'id' => $r1->id,
                            'name' => $r1->name,
                            'selectec' => 'Selected',
                        ));
                    } else {
                        array_push($final, array(
                            'id' => $r1->id,
                            'name' => $r1->name,
                            'selectec' => '',
                        ));
                    }
                }
                return $final;
            } else {
                return $r;
            }
        }
    }

    public function getCmbNivelsGrupoInscripcion(Request $request)
    {
        if ($request->ajax()) {
            //dd($request->get('plantel_id'));
            $plantel = $request->get('plantel_id');
            $especialidad = $request->get('especialidad_id');
            $nivel = $request->get('nivel_id');
            $grupo = $request->get('grupo_id');

            $final = array();
            $r = DB::table('nivels as n')
                ->join('hacademicas as h','h.nivel_id','=','n.id')
                ->select('n.id', 'n.name')
                ->where('n.plantel_id', '=', $plantel)
                ->where('n.especialidad_id', '=', $especialidad)
                ->where('h.grupo_id', '=', $grupo)
                ->where('n.id', '>', '0')
                ->whereNull('n.deleted_at')
                ->whereNull('h.deleted_at')
                ->distinct()
                ->get();
            /*
            $r = DB::table('nivels as n')
                ->join('inscripcions as i','i.nivel_id','=','n.id')
                ->select('n.id', 'n.name')
                ->where('n.plantel_id', '=', $plantel)
                ->where('n.especialidad_id', '=', $especialidad)
                ->where('i.grupo_id', '=', $grupo)
                ->where('n.id', '>', '0')
                ->whereNull('n.deleted_at')
                ->whereNull('i.deleted_at')
                ->distinct()
                ->get();
                */
            //dd($r);
            if (isset($nivel) and $nivel != 0) {
                foreach ($r as $r1) {
                    if ($r1->id == $nivel) {
                        array_push($final, array(
                            'id' => $r1->id,
                            'name' => $r1->name,
                            'selectec' => 'Selected',
                        ));
                    } else {
                        array_push($final, array(
                            'id' => $r1->id,
                            'name' => $r1->name,
                            'selectec' => '',
                        ));
                    }
                }
                return $final;
            } else {
                return $r;
            }
        }
    }

    public function listaNiveles(Request $request)
    {
        $niveles = Nivel::whereIn('plantel_id',$request->input('plantel'))->orderBy('plantel_id')->orderBy('especialidad_id')->get();
        $plantels=Plantel::pluck('razon','id');
        return view('combinacionClientes.reportes.cargas', compact('niveles','plantels'));
    }

    public function apiListaXplantelYespecialidad(Request $request)
    {
        $datos = $request->all();
        $lista = Nivel::select('id', 'name')
            ->where('plantel_id', $datos['plantel'])
            ->where('especialidad_id', $datos['especialidad'])
            ->get();

        if (count($lista) == 0) {
            return response()->json(['msj' => 'Sin registros'], 500);
        }
        return response()->json(['resultado' => $lista]);
    }
}
