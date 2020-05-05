<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\PeriodoEstudio;
use App\MateriumPeriodo;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updatePeriodoEstudio;
use App\Http\Requests\createPeriodoEstudio;
use DB;
use Cache;

class PeriodoEstudiosController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $periodoEstudios = PeriodoEstudio::getAllData($request);

        return view('periodoEstudios.index', compact('periodoEstudios'))->with('list', PeriodoEstudio::getListFromAllRelationApps());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('periodoEstudios.create')
            ->with('list', PeriodoEstudio::getListFromAllRelationApps());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(createPeriodoEstudio $request)
    {

        $input = $request->all();
        $input['usu_alta_id'] = Auth::user()->id;
        $input['usu_mod_id'] = Auth::user()->id;

        //create data
        $p = PeriodoEstudio::create($input);

        return redirect()->route('periodoEstudios.edit', $p->id)->with('message', 'Registro Creado.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id, PeriodoEstudio $periodoEstudio)
    {
        $periodoEstudio = $periodoEstudio->find($id);
        return view('periodoEstudios.show', compact('periodoEstudio'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id, PeriodoEstudio $periodoEstudio)
    {
        $p = Cache::remember('razon', 30, function () {
            return DB::table('empleados as e')
                ->where('e.user_id', Auth::user()->id)->value('plantel_id');
        });
        $periodoEstudio = $periodoEstudio->find($id);
        //dd($periodoEstudio->materias->toArray());
        $list = DB::table('materia')->where('id', '>', '0')->where('plantel_id', '=', $p)->pluck('name', 'id')->toArray();
        $materias_ls = array_merge(['0' => 'Seleccionar Opción'], $list);
        $materias = MateriumPeriodo::select('materium_periodos.id', 'm.name as materia')
            ->join('materia as m', 'm.id', '=', 'materium_periodos.materium_id')
            ->where('periodo_estudio_id', '=', $id)->get();
        //dd($materias);
        return view('periodoEstudios.edit', compact('periodoEstudio', 'materias_ls', 'materias'))
            ->with('list', PeriodoEstudio::getListFromAllRelationApps());
    }

    /**
     * Show the form for duplicatting the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function duplicate($id, PeriodoEstudio $periodoEstudio)
    {
        $periodoEstudio = $periodoEstudio->find($id);
        return view('periodoEstudios.duplicate', compact('periodoEstudio'))
            ->with('list', PeriodoEstudio::getListFromAllRelationApps());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param Request $request
     * @return Response
     */
    public function update($id, PeriodoEstudio $periodoEstudio, updatePeriodoEstudio $request)
    {
        $input = $request->except('materia_id-field');
        $materias = $request->get('materia_id-field');
        //dd($materias);
        $input['usu_mod_id'] = Auth::user()->id;
        //update data
        $periodoEstudio = $periodoEstudio->find($id);
        $periodoEstudio->update($input);
        if ($request->has('materia_id-field')) {
            foreach ($materias as $m) {
                $periodoEstudio->materias()->attach($m);
            }
        }
        return redirect()->route('periodoEstudios.edit', $id)->with('message', 'Registro Actualizado.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id, PeriodoEstudios $periodoEstudios)
    {
        $periodoEstudios = $periodoEstudios->find($id);
        $periodoEstudios->delete();

        return redirect()->route('periodoEstudios.index')->with('message', 'Registro Borrado.');
    }

    public function destroyMateria($id, MateriumPeriodo $materiumPeriodo)
    {
        $materiumPeriodo = $materiumPeriodo->find($id);
        $p = $materiumPeriodo->periodo_estudio_id;
        $materiumPeriodo->delete();

        return redirect()->route('periodoEstudios.edit', $p)->with('message', 'Registro Borrado.');
    }

    public function getCmbPeriodo(Request $request)
    {
        if ($request->ajax()) {
            //dd($request->get('plantel_id'));
            $plantel = $request->get('plantel_id');
            $periodo = $request->get('periodo_id');

            $final = array();
            $r = DB::table('periodo_estudios as p')
                ->select('p.id', 'p.name')
                ->where('p.plantel_id', '=', $plantel)
                ->where('p.id', '>', '0')
                ->get();
            //dd($r);
            if (isset($periodo) and $periodo <> 0) {
                foreach ($r as $r1) {
                    if ($r1->id == $periodo) {
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

    public function getCmbPeriodoInscripcion(Request $request)
    {
        if ($request->ajax()) {
            //dd($request->get('plantel_id'));
            $grupo = $request->get('grupo_id');
            $periodo = $request->get('periodo_estudio_id');

            $final = array();
            $r = DB::table('periodo_estudios as p')
                ->join('grupo_periodo_estudios as gpe', 'gpe.periodo_estudio_id', '=', 'p.id')
                ->select('p.id', 'p.name')
                ->where('gpe.grupo_id', '=', $grupo)
                ->where('p.id', '>', '0')
                ->get();
            //dd($r);
            if (isset($periodo) and $periodo <> 0) {
                foreach ($r as $r1) {
                    if ($r1->id == $periodo) {
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

    public function planEstudio()
    {
        return view('periodoEstudios.reportes.plan_estudio')->with('list', PeriodoEstudio::getListFromAllRelationApps());
    }

    public function planEstudioR(Request $request)
    {
        $datos = $request->all();
        //dd($datos);
        $registros = PeriodoEstudio::where('plantel_id', $datos['plantel_f'])
            ->where('especialidad_id', $datos['especialidad_f'])
            ->where('nivel_id', $datos['nivel_f'])
            ->where('grado_id', $datos['grado_f'])
            ->orderBy('orden')
            ->with('materias')
            ->get();
        //dd($registros->toArray());
        return view('periodoEstudios.reportes.plan_estudior', compact('registros'))->with('list', PeriodoEstudio::getListFromAllRelationApps());
    }
}
