<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Materium;
use App\Empleado;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateMaterium;
use App\Http\Requests\createMaterium;
use DB;

class MateriasController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $materias = Materium::getAllData($request);

        return view('materias.index', compact('materias'))
            ->with('list', Materium::getListFromAllRelationApps());;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $list = Materium::where('id', '>', '0')->where('seriada_bnd', '=', '1')->pluck('name', 'id')->toArray();
        $materiales_ls = array_merge(['0' => 'Seleccionar Opción'], $list);
        return view('materias.create', compact('materiales_ls'))
            ->with('list', Materium::getListFromAllRelationApps());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(createMaterium $request)
    {

        $input = $request->all();
        $input['usu_alta_id'] = Auth::user()->id;
        $input['usu_mod_id'] = Auth::user()->id;
        if (!isset($input['seriada_bnd'])) {
            $input['seriada_bnd'] = 0;
        } else {
            $input['seriada_bnd'] = 1;
        }
        if (!isset($input['bnd_oficial'])) {
            $input['bnd_oficial'] = 0;
        }
        //create data
        Materium::create($input);

        return redirect()->route('materias.index')->with('message', 'Registro Creado.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id, Materium $materium)
    {
        $materium = $materium->find($id);
        return view('materias.show', compact('materium'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id, Materium $materium)
    {
        $materium = $materium->find($id);
        $list = Materium::where('id', '>', '0')->where('seriada_bnd', '=', '1')->pluck('name', 'id')->toArray();
        $materiales_ls = array_merge(['0' => 'Seleccionar Opción'], $list);
        //dd($materiales_ls);
        return view('materias.edit', compact('materium', 'materiales_ls'))
            ->with('list', Materium::getListFromAllRelationApps());
    }

    /**
     * Show the form for duplicatting the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function duplicate($id, Materium $materium)
    {
        $materium = $materium->find($id);
        return view('materias.duplicate', compact('materium'))
            ->with('list', Materium::getListFromAllRelationApps());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param Request $request
     * @return Response
     */
    public function update($id, Materium $materium, updateMaterium $request)
    {
        $input = $request->all();
        $input['usu_mod_id'] = Auth::user()->id;
        //update data
        $materium = $materium->find($id);
        if (!isset($input['seriada_bnd'])) {
            $input['seriada_bnd'] = 0;
        } else {
            $input['seriada_bnd'] = 1;
        }
        if (!isset($input['bnd_oficial'])) {
            $input['bnd_oficial'] = 0;
        }
        if (!isset($input['bnd_tiene_nombre_oficial'])) {
            $input['bnd_tiene_nombre_oficial'] = 0;
        }
        $materium->update($input);

        return redirect()->route('materias.index')->with('message', 'Registro Actualizado.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id, Materium $materium)
    {
        $materium = $materium->find($id);
        $materium->delete();

        return redirect()->route('materias.index')->with('message', 'Registro Borrado.');
    }

    public function getCmbMateria(Request $request)
    {
        if ($request->ajax()) {
            //dd($request->all());
            $plantel = $request->get('plantel_id');
            $grupo = $request->get('grupo_id');
            $materia = $request->get('materium_id');
            //dd("FLC:".$materia);
            $final = array();
            $r = DB::table('materia as m')
                ->join('materium_periodos as mp', 'mp.materium_id', '=', 'm.id')
                ->join('periodo_estudios as pe', 'pe.id', '=', 'mp.periodo_estudio_id')
                ->join('grupo_periodo_estudios as gpe', 'gpe.periodo_estudio_id', '=', 'pe.id')
                ->select('m.id', 'm.name')
                ->where('gpe.grupo_id', $grupo)
                ->where('m.plantel_id', '=', $plantel)
                ->where('m.id', '>', '0')
                ->get();

            //dd($r);
            if (isset($materia) and $materia <> 0) {
                foreach ($r as $r1) {
                    if ($r1->id == $materia) {
                        array_push($final, array(
                            'id' => $r1->id,
                            'name' => $r1->id."-".$r1->name,
                            'selectec' => 'Selected'
                        ));
                    } else {
                        array_push($final, array(
                            'id' => $r1->id,
                            'name' => $r1->id."-".$r1->name,
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

    public function getCmbMateria2(Request $request)
    {
        if ($request->ajax()) {
            //dd($request->all());
            $plantel = $request->get('plantel_id');
            $grupo = $request->get('grupo_id');
            $materia = $request->get('materium_id');
            //dd("FLC:".$materia);
            $final = array();
            $r = DB::table('materia as m')
                ->select('m.id', 'm.name')
                ->where('m.plantel_id', '=', $plantel)
                ->where('m.id', '>', '0')
                ->whereNull('deleted_at')
                ->get();

            //dd($r);
            if (isset($materia) and $materia <> 0) {
                foreach ($r as $r1) {
                    if ($r1->id == $materia) {
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

    public function getCmbMateriaXalumno(Request $request)
    {
        if ($request->ajax()) {
            //dd($request->all());
            $cliente_id = $request->get('cliente_id');

            $grado = $request->get('grado_id');
            $materia = $request->get('materia_id');
            //dd("FLC:".$materia);
            $final = array();
            $r = DB::table('materia as m')
                ->join('hacademicas as h', 'h.materium_id', '=', 'm.id')
                ->join('inscripcions as i', 'i.id', '=', 'h.inscripcion_id')
                ->join('clientes as c', 'c.id', '=', 'i.cliente_id')
                ->select('m.id', 'm.name')
                ->whereColumn('m.plantel_id', 'i.plantel_id')
                ->where('c.id', '=', $cliente_id)
                ->where('i.grado_id', '=', $grado)
                ->where('h.deleted_at', '=', null)
                ->get();
            //dd($r);
            if (isset($materia) and $materia <> 0) {
                foreach ($r as $r1) {
                    if ($r1->id == $materia) {
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

    public function getCmbMateriaXalumno2(Request $request)
    {
        if ($request->ajax()) {
            //dd($request->all());
            $alumno_id = $request->get('alumno_id');
            $materia = $request->get('materium_id');
            //dd("FLC:".$materia);
            $e = Empleado::where('user_id', '=', Auth::user()->id)->first();
            //dd($e->id);

            $final = array();

            $filtro = Auth::user()->can('IfiltroCalificacionXProfesor');
            //dd($filtro);
            if ($filtro) {
                $r = DB::table('materia as m')
                    ->join('hacademicas as h', 'h.materium_id', '=', 'm.id')
                    ->join('inscripcions as i', 'i.id', '=', 'h.inscripcion_id')
                    ->join('clientes as c', 'c.id', '=', 'i.cliente_id')
                    ->join('grupos as g', 'g.id', '=', 'i.grupo_id')
                    ->join('asignacion_academicas as aa', 'aa.grupo_id', '=', 'g.id')
                    ->join('empleados as e', 'e.id', 'aa.empleado_id')
                    ->select(distinct('distinctrow(m.id)'), 'm.name')
                    ->whereColumn('m.plantel_id', 'i.plantel_id')
                    ->where('c.id', '=', $alumno_id)
                    ->where('e.id', '=', $e->id)
                    ->where('h.deleted_at', '=', null)
                    ->get();
            } else {
                $r = DB::table('materia as m')
                    ->join('hacademicas as h', 'h.materium_id', '=', 'm.id')
                    ->join('inscripcions as i', 'i.id', '=', 'h.inscripcion_id')
                    ->join('clientes as c', 'c.id', '=', 'i.cliente_id')
                    ->join('grupos as g', 'g.id', '=', 'i.grupo_id')
                    ->join('asignacion_academicas as aa', 'aa.grupo_id', '=', 'g.id')
                    ->join('empleados as e', 'e.id', 'aa.empleado_id')
                    ->select(DB::raw('distinctrow(m.id)'), 'm.name')
                    ->whereColumn('m.plantel_id', 'i.plantel_id')
                    ->where('c.id', '=', $alumno_id)
                    ->where('h.deleted_at', '=', null)
                    ->get();
            }

            //dd($r);
            if (isset($materia) and $materia <> 0) {
                foreach ($r as $r1) {
                    if ($r1->id == $materia) {
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

    public function getCmbMateriaXalumno3(Request $request)
    {
        if ($request->ajax()) {
            //dd($request->all());
            $curp = $request->get('curp');
            $materia = $request->get('materium_id');
            //dd("FLC:".$materia);
            $e = Empleado::where('user_id', '=', Auth::user()->id)->first();
            //dd($e->id);

            $final = array();

            $filtro = Auth::user()->can('IfiltroCalificacionXProfesor');
            //dd($filtro);
            if ($filtro) {
                $r = DB::table('materia as m')
                    ->join('hacademicas as h', 'h.materium_id', '=', 'm.id')
                    ->join('inscripcions as i', 'i.id', '=', 'h.inscripcion_id')
                    ->join('clientes as c', 'c.id', '=', 'i.cliente_id')
                    ->join('grupos as g', 'g.id', '=', 'i.grupo_id')
                    ->join('asignacion_academicas as aa', 'aa.grupo_id', '=', 'g.id')
                    ->join('empleados as e', 'e.id', 'aa.empleado_id')
                    ->select(distinct('distinctrow(m.id)'), 'm.name')
                    ->whereColumn('m.plantel_id', 'i.plantel_id')
                    ->where('c.curp', '=', $curp)
                    ->where('e.id', '=', $e->id)
                    ->where('h.deleted_at', '=', null)
                    ->get();
            } else {
                $r = DB::table('materia as m')
                    ->join('hacademicas as h', 'h.materium_id', '=', 'm.id')
                    ->join('inscripcions as i', 'i.id', '=', 'h.inscripcion_id')
                    ->join('clientes as c', 'c.id', '=', 'i.cliente_id')
                    ->join('grupos as g', 'g.id', '=', 'i.grupo_id')
                    ->join('asignacion_academicas as aa', 'aa.grupo_id', '=', 'g.id')
                    ->join('empleados as e', 'e.id', 'aa.empleado_id')
                    ->select(DB::raw('distinctrow(m.id)'), 'm.name')
                    ->whereColumn('m.plantel_id', 'i.plantel_id')
                    ->where('c.curp', '=', $curp)
                    ->where('h.deleted_at', '=', null)
                    ->get();
            }

            //dd($r);
            if (isset($materia) and $materia <> 0) {
                foreach ($r as $r1) {
                    if ($r1->id == $materia) {
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

    public function getCmbMateriaXAsignacionAcademica(Request $request)
    {
        if ($request->ajax()) {
            //dd($request->all());
            $grupo = $request->get('grupo');
            $lectivo = $request->get('lectivo');
            $plantel = $request->get('plantel');
            $instructor = $request->get('instructor');
            $materia = 0;

            $final = array();

            $r = DB::table('materia as m')
                ->join('asignacion_academicas as aa', 'aa.materium_id', '=', 'm.id')
                ->select('m.id', 'm.name')
                ->where('aa.plantel_id', '=', $plantel)
                ->where('aa.lectivo_id', '=', $lectivo)
                ->where('aa.empleado_id', '=', $instructor)
                ->where('aa.grupo_id', '=', $grupo)
                ->whereNull('aa.deleted_at')
                ->get();

            //dd($r);

            foreach ($r as $r1) {
                if ($r1->id == $materia) {
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
        }
    }

    public function materiasXplantelXasignacion(Request $request)
    {
        if ($request->ajax()) {
            //dd($request->all());
            $plantel = $request->get('plantel_id');
            $lectivo = $request->get('lectivo_id');
            $grupo = $request->get('grupo_id');
            $materia = $request->get('materia_id');

            $final = array();
            $r = DB::table('materia as m')
                ->join('asignacion_academicas as aa', 'aa.materium_id', '=', 'm.id')
                ->join('hacademicas as h', 'h.materium_id', '=', 'aa.materium_id')
                ->whereColumn('h.grupo_id', 'aa.grupo_id')
                ->whereColumn('h.lectivo_id', 'aa.lectivo_id')
                ->join('inscripcions as i', 'i.id', '=', 'h.inscripcion_id')
                ->select('m.id', 'm.name')
                ->where('aa.plantel_id', '=', $plantel)
                ->where('aa.lectivo_id', '=', $lectivo)
                ->where('aa.grupo_id', '=', $grupo)
                ->where('m.id', '>', '0')
                ->whereNull('i.deleted_at')
                ->whereNull('h.deleted_at')
                ->whereNull('aa.deleted_at')
                ->distinct()
                ->get();

            //dd($r);
            if (isset($materia) and $materia != 0) {
                foreach ($r as $r1) {
                    if ($r1->id == $materia) {
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

    public function materiasExtraordinario(Request $request){
        if ($request->ajax()) {
            //dd($request->all());
            $plantel = $request->get('plantel_id');
            $lectivo = $request->get('lectivo_id');

            $final = array();
            $r = DB::table('materia as m')
                ->select('m.id', 'm.name')
                ->join('hacademicas as h','h.materium_id','m.id')
                ->join('calificacions as cali','cali.hacademica_id','=','h.id')
                ->where('h.plantel_id',$plantel)
                ->where('cali.lectivo_id',$lectivo)
                ->where('cali.tpo_examen_id',2)
                ->whereNull('h.deleted_at')
                ->whereNull('cali.deleted_at')
                ->orderBy('m.id')
                ->distinct()
                ->get();

            //dd($r);
            if (isset($materia) and $materia != 0) {
                foreach ($r as $r1) {
                    if ($r1->id == $materia) {
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
}
