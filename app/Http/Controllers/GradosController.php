<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Grado;
use App\Modulo;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateGrado;
use App\Http\Requests\createGrado;
use DB;

class GradosController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $grados = Grado::getAllData($request);

        return view('grados.index', compact('grados'))->with('list', Grado::getListFromAllRelationApps());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $modulos = Modulo::pluck('name', 'id');
        return view('grados.create', compact('modulos'))
            ->with('list', Grado::getListFromAllRelationApps());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(createGrado $request)
    {

        $input = $request->all();
        if (isset($input['mexico_bnd'])) {
            $input['mexico_bnd'] = 1;
        } else {
            $input['mexico_bnd'] = 0;
        }
        $input['usu_alta_id'] = Auth::user()->id;
        $input['usu_mod_id'] = Auth::user()->id;

        //create data
        Grado::create($input);

        return redirect()->route('grados.index')->with('message', 'Registro Creado.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id, Grado $grado)
    {
        $grado = $grado->find($id);
        return view('grados.show', compact('grado'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id, Grado $grado)
    {
        $grado = $grado->find($id);
        $modulos = Modulo::pluck('name', 'id');
        return view('grados.edit', compact('grado', 'modulos'))
            ->with('list', Grado::getListFromAllRelationApps());
    }

    /**
     * Show the form for duplicatting the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function duplicate($id, Grado $grado)
    {
        $grado = $grado->find($id);
        return view('grados.duplicate', compact('grado'))
            ->with('list', Grado::getListFromAllRelationApps());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param Request $request
     * @return Response
     */
    public function update($id, Grado $grado, updateGrado $request)
    {
        $input = $request->all();
        //dd($input);
        $input['usu_mod_id'] = Auth::user()->id;
        if (isset($input['mexico_bnd'])) {
            $input['mexico_bnd'] = 1;
        } else {
            $input['mexico_bnd'] = 0;
        }
        //update data
        $grado = $grado->find($id);
        $grado->update($input);

        return redirect()->route('grados.index')->with('message', 'Registro Actualizado.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id, Grado $grado)
    {
        $grado = $grado->find($id);
        $grado->delete();

        return redirect()->route('grados.index')->with('message', 'Registro Borrado.');
    }

    public function getCmbGrados(Request $request)
    {
        if ($request->ajax()) {
            //dd($request->all());
            $plantel = $request->get('plantel_id');
            $especialidad = $request->get('especialidad_id');
            $nivel = $request->get('nivel_id');
            $grado = $request->get('grado_id');
            $final = array();
            $r = DB::table('grados as g')
                ->select('g.id', 'g.name')
                ->where('g.plantel_id', '=', $plantel)
                ->where('g.especialidad_id', '=', $especialidad)
                ->where('g.nivel_id', '=', $nivel)
                ->where('g.id', '>', '0')
                ->whereNull('g.deleted_at')
                ->get();
            //dd($r);
            if (isset($grado) and $grado <> 0) {
                foreach ($r as $r1) {
                    if ($r1->id == $grado) {
                        array_push($final, array(
                            'id' => $r1->id,
                            'name' => $r1->name,
                            'selectec' => 'Selected'
                        ));
                    } else {
                        array_push($final, array(
                            'id' => $r1->id,
                            'name' => $r1->name,
                            'selectec' => ''
                        ));
                    }
                }
                return $final;
            } else {
                return $r;
            }
        }
    }

    public function getCmbGradosXalumno(Request $request)
    {
        if ($request->ajax()) {
            //dd($request->all());
            $cliente = $request->get('cliente_id');
            $grado = $request->get('grado_id');

            $final = array();
            $r = DB::table('grados as g')
                ->join('inscripcions as i', 'i.grado_id', '=', 'g.id')
                ->join('clientes as c', 'i.cliente_id', '=', 'c.id')
                ->select('g.id', 'g.name')
                ->where('c.id', '=', $cliente)
                ->where('g.id', '>', '0')
                ->get();
            //dd($r);
            if (isset($grado) and $grado <> 0) {
                foreach ($r as $r1) {
                    if ($r1->id == $grado) {
                        array_push($final, array(
                            'id' => $r1->id,
                            'name' => $r1->name,
                            'selectec' => 'Selected'
                        ));
                    } else {
                        array_push($final, array(
                            'id' => $r1->id,
                            'name' => $r1->name,
                            'selectec' => ''
                        ));
                    }
                }
                return $final;
            } else {
                return $r;
            }
        }
    }

    public function getCmbGradosXAsignacion(Request $request)
    {
        if ($request->ajax()) {
            //dd($request->all());
            $plantel = $request->get('plantel');
            $lectivo = $request->get('lectivo');
            $grupo = $request->get('grupo');

            $final = array();
            $r = DB::table('grados as g')
                ->join('inscripcions as i', 'i.grado_id', '=', 'g.id')
                ->join('clientes as c', 'i.cliente_id', '=', 'c.id')
                ->select('g.id', 'g.name')
                ->where('i.plantel_id', '=', $plantel)
                ->where('i.lectivo_id', '=', $lectivo)
                ->where('i.grupo_id', '=', $grupo)
                ->where('g.id', '>', '0')
                ->distinct()
                ->get();
            //dd($r);
            if (isset($grado) and $grado <> 0) {
                foreach ($r as $r1) {
                    if ($r1->id == $grado) {
                        array_push($final, array(
                            'id' => $r1->id,
                            'name' => $r1->name,
                            'selectec' => 'Selected'
                        ));
                    } else {
                        array_push($final, array(
                            'id' => $r1->id,
                            'name' => $r1->name,
                            'selectec' => ''
                        ));
                    }
                }
                return $final;
            } else {
                return $r;
            }
        }
    }

    public function listaGrados()
    {
        $grados = Grado::orderBy('plantel_id')->orderBy('especialidad_id')->orderBy('nivel_id')->orderBy('id')->get();
        return view('combinacionClientes.reportes.cargas', compact('grados'));
    }

    public function apiListaXplantelYespecialidadYgrado(Request $request)
    {
        //dd($request);
        $datos = $request->all();
        $lista = Grado::select('id', 'name')
            ->where('plantel_id', $datos['plantel'])
            ->where('especialidad_id', $datos['especialidad'])
            ->where('nivel_id', $datos['nivel'])
            ->get();
        if (count($lista) == 0) {
            return response()->json(['msj' => 'Sin registros'], 500);
        }
        return response()->json(['resultado' => $lista]);
    }
}
