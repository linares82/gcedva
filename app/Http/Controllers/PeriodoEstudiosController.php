<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Empleado;
use App\ConsultaCalificacion;
use App\Hacademica;
use App\Calificacion;
use App\Inscripcion;
use App\Materia;
use App\PeriodoEstudio;
use App\MateriumPeriodo;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updatePeriodoEstudio;
use App\Http\Requests\createPeriodoEstudio;
use App\Lectivo;
use App\StEmpleado;
use DB;
use Cache;
use Log;

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
        if(isset($input['bnd_carrera_tecnica'])){
            $input['bnd_carrera_tecnica']==1;
        }else{
            $input['bnd_carrera_tecnica']==0;
        }

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
        $materias = MateriumPeriodo::select('materium_periodos.id', 'm.id as materia_id', 'm.codigo', 'm.name as materia')
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
        //dd($input);
        $input['usu_mod_id'] = Auth::user()->id;
        if (!isset($input['bnd_activo'])) {
            $input['bnd_activo'] = 0;
        }
        if(!isset($input['bnd_carrera_tecnica'])){
            $input['bnd_carrera_tecnica']==0;
        }
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
    public function destroy($id, PeriodoEstudio $periodoEstudios)
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
                ->select('p.id', DB::raw('concat(p.id, "-", p.name) as name'))
                ->where('p.plantel_id', '=', $plantel)
                ->where('p.id', '>', '0')
                ->whereNull('p.deleted_at')
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
            ->where('plan_estudio_id', $datos['plan_estudio_f'])
            ->orderBy('orden')
            ->with('materias')
            ->get();
        //dd($registros->toArray());
        return view('periodoEstudios.reportes.plan_estudior', compact('registros'))->with('list', PeriodoEstudio::getListFromAllRelationApps());
    }

    public function cmbPeriodosEstudio(Request $request)
    {
        if ($request->ajax()) {
            //dd($request->all());
            $plantel = $request->get('plantel_id');
            $especialidad = $request->get('especialidad_id');
            $nivel = $request->get('nivel_id');
            $grado = $request->get('grado_id');

            $final = array();
            $r = DB::table('periodo_estudios as pe')
                ->select('pe.id', 'pe.name')
                ->where('pe.plantel_id', '=', $plantel)
                ->where('pe.especialidad_id', '=', $especialidad)
                ->where('pe.nivel_id', '=', $nivel)
                ->where('pe.grado_id', '=', $grado)
                ->where('pe.id', '>', '0')
                ->distinct()
                ->get();

            //dd($r);

            return $r;
        }
    }

    public function sabanaCalificaciones()
    {
        $empleado = Empleado::where('user_id', Auth::user()->id)->first();
        $planteles_validos = $empleado->plantels->pluck('razon', 'id');
        return view("periodoEstudios.reportes.sabanaCalificaciones", compact('planteles_validos'))
            ->with('list', PeriodoEstudio::getListFromAllRelationApps());
    }

    /*public function sabanaCalificacionesR(Request $request)
    {
        $datos = $request->all();

        $periodos_estudio=DB::table('periodo_estudios as pe')
        ->where('pe.plantel_id', '=', $datos['plantel_f'])
        ->where('pe.id', '>', '0')
        ->distinct()
        ->orderBy('pe.id')
        ->pluck('pe.id');


        //dd($datos);
        $cliente_base = Inscripcion::select(
            'inscripcions.plantel_id',
            'p.razon',
            'inscripcions.especialidad_id',
            'esp.name as especialidad',
            'inscripcions.nivel_id',
            'n.name as nivel',
            'inscripcions.grado_id',
            'g.name as grado',
            'inscripcions.grupo_id',
            'gru.name as grupo',
            'inscripcions.lectivo_id',
            'l.name as lectivo'
        )
            ->join('plantels as p', 'p.id', '=', 'inscripcions.plantel_id')
            ->join('especialidads as esp', 'esp.id', '=', 'inscripcions.especialidad_id')
            ->join('nivels as n', 'n.id', '=', 'inscripcions.nivel_id')
            ->join('grados as g', 'g.id', '=', 'inscripcions.grado_id')
            ->join('grupos as gru', 'gru.id', '=', 'inscripcions.grupo_id')
            ->join('lectivos as l', 'l.id', '=', 'inscripcions.lectivo_id')
            ->where('inscripcions.plantel_id', $datos['plantel_f'])
            ->where('inscripcions.especialidad_id', $datos['especialidad_f'])
            ->where('inscripcions.nivel_id', $datos['nivel_f'])
            ->where('inscripcions.grado_id', $datos['grado_f'])
            ->where('inscripcions.lectivo_id', $datos['lectivo_f'])
            ->where('inscripcions.grupo_id', $datos['grupo_f'])
            ->whereNull('inscripcions.deleted_at')
            ->groupBy('inscripcions.plantel_id')
            ->groupBy('p.razon')
            ->groupBy('inscripcions.especialidad_id')
            ->groupBy('esp.name')
            ->groupBy('inscripcions.nivel_id')
            ->groupBy('n.name')
            ->groupBy('inscripcions.grado_id')
            ->groupBy('g.name')
            ->groupBy('inscripcions.grupo_id')
            ->groupBy('gru.name')
            ->groupBy('inscripcions.lectivo_id')
            ->groupBy('l.name')
            ->distinct()
            ->first();
        //dd($cliente_base->toArray());

        $periodos_parametro = DB::table('periodo_estudios as pe')
            ->where('pe.plantel_id', '=', $cliente_base->plantel_id)
            ->where('pe.especialidad_id', '=', $cliente_base->especialidad_id)
            ->where('pe.nivel_id', '=', $cliente_base->nivel_id)
            ->where('pe.grado_id', '=', $cliente_base->grado_id)
            ->where('pe.id', '>', '0')
            ->distinct()
            ->orderBy('pe.id')
            ->pluck('pe.id');
        //dd($periodos_parametro);
        $materias = PeriodoEstudio::select('periodo_estudios.name as periodo', 'm.id', 'm.name as materia', 'm.codigo')
            ->join('materium_periodos as mp', 'mp.periodo_estudio_id', '=', 'periodo_estudios.id')
            ->join('materia as m', 'm.id', '=', 'mp.materium_id')
            ->whereIn('periodo_estudios.id', $periodos_parametro)
            ->orderBy('periodo_estudios.orden')
            ->orderBy('m.id')
            ->get();

        $periodos = PeriodoEstudio::select(
            'periodo_estudios.name as periodo',
            'periodo_estudios.orden',
            'periodo_estudios.id',
            DB::raw('count(m.name) as cantidad_materias')
        )
            ->join('materium_periodos as mp', 'mp.periodo_estudio_id', '=', 'periodo_estudios.id')
            ->join('materia as m', 'm.id', '=', 'mp.materium_id')
            ->whereIn('periodo_estudios.id', $periodos_parametro)
            ->orderBy('periodo_estudios.orden')
            ->groupBy('periodo_estudios.name')
            ->groupBy('mp.periodo_estudio_id')
            ->groupBy('periodo_estudios.id')
            ->with('materias')
            ->get();

        $materias_array = array();
        foreach ($materias as $m) {
            array_push($materias_array, $m->id);
        }
        //dd($materias);

        $clientes = Hacademica::select('c.id', 'c.matricula', 'c.nombre', 'c.nombre2', 'c.ape_paterno', 'c.ape_materno')
            ->join('clientes as c', 'c.id', '=', 'hacademicas.cliente_id')
            ->join('inscripcions as i', 'i.id', '=', 'hacademicas.inscripcion_id')
            ->where('i.plantel_id', $cliente_base->plantel_id)
            ->where('hacademicas.especialidad_id', $cliente_base->especialidad_id)
            ->where('hacademicas.nivel_id', $cliente_base->nivel_id)
            ->where('hacademicas.grado_id', $cliente_base->grado_id)
            ->where('hacademicas.lectivo_id', $cliente_base->lectivo_id)
            ->where('hacademicas.grupo_id', $cliente_base->grupo_id)
            ->whereIn('materium_id', $materias_array)
            ->whereNull('i.deleted_at')
            ->whereNull('hacademicas.deleted_at')
            ->distinct()
            ->orderBy('c.ape_paterno')
            ->orderBy('c.ape_materno')
            ->orderBy('c.nombre')
            ->orderBy('c.nombre2')
            ->get();
        //dd($clientes);
        $registros = array();
        $encabezado = array();
        array_push($encabezado, 'Matricula');
        array_push($encabezado, 'Alumno');
        foreach ($materias as $materia) {
            array_push($encabezado, $materia->codigo);
        }
        array_push($registros, $encabezado);
        foreach ($clientes as $cliente) {
            $registro = array();
            array_push($registro, $cliente->matricula);
            array_push($registro, $cliente->nombre . " " . $cliente->nombre2 . " " . $cliente->ape_paterno . " " . $cliente->ape_materno);
            foreach ($materias as $materia) {
                $calificacion_historico = ConsultaCalificacion::where('matricula', 'like', "%" . $cliente->matricula . "%")
                    ->where('codigo', $materia->codigo)
                    ->first();

                if (is_null($calificacion_historico)) {
                    $calificacion = Hacademica::where('cliente_id', $cliente->id)
                        ->where('materium_id', $materia->id)
                        ->orderBy('id', 'desc')
                        ->whereNull('deleted_at')
                        ->first();
                    if(!is_null($calificacion)){
                        if(!is_null($calificacion->calificaciones)){
                            array_push($registro, optional($calificacion->calificaciones)->max('calificacion'));
                        }
                        
                    }
                    
                } else {
                    array_push($registro, $calificacion_historico->calificacion);
                }

                //dd($cliente->id . "-" . $materia->id);


            }
            array_push($registros, $registro);
        }
        
        //dd($registros);

        return view("periodoEstudios.reportes.sabanaCalificacionesR", compact('registros', 'materias', 'periodos'));
    }
*/

    /*
    public function sabanaCalificacionesR(Request $request)
    {
        $datos = $request->all();


        //dd($datos);
        $cliente_base = Hacademica::select(
            'hacademicas.plantel_id',
            'p.razon',
            'hacademicas.especialidad_id',
            'esp.name as especialidad',
            'hacademicas.nivel_id',
            'n.name as nivel',
            'hacademicas.grado_id',
            'g.name as grado',
            'hacademicas.grupo_id',
            'gru.name as grupo',
            'hacademicas.lectivo_id',
            'l.name as lectivo',
            'cliente_id'
        )
            ->join('plantels as p', 'p.id', '=', 'hacademicas.plantel_id')
            ->join('especialidads as esp', 'esp.id', '=', 'hacademicas.especialidad_id')
            ->join('nivels as n', 'n.id', '=', 'hacademicas.nivel_id')
            ->join('grados as g', 'g.id', '=', 'hacademicas.grado_id')
            ->join('grupos as gru', 'gru.id', '=', 'hacademicas.grupo_id')
            ->join('lectivos as l', 'l.id', '=', 'hacademicas.lectivo_id')
            ->where('hacademicas.plantel_id', $datos['plantel_f'])
            ->where('hacademicas.especialidad_id', $datos['especialidad_f'])
            ->where('hacademicas.nivel_id', $datos['nivel_f'])
            ->where('hacademicas.grado_id', $datos['grado_f'])
            ->where('hacademicas.lectivo_id', $datos['lectivo_f'])
            ->where('hacademicas.grupo_id', $datos['grupo_f'])
            ->whereNull('hacademicas.deleted_at')
            ->orderBy('cliente_id','desc')
            ->groupBy('hacademicas.plantel_id')
            ->groupBy('p.razon')
            ->groupBy('hacademicas.especialidad_id')
            ->groupBy('esp.name')
            ->groupBy('hacademicas.nivel_id')
            ->groupBy('n.name')
            ->groupBy('hacademicas.grado_id')
            ->groupBy('g.name')
            ->groupBy('hacademicas.grupo_id')
            ->groupBy('gru.name')
            ->groupBy('hacademicas.lectivo_id')
            ->groupBy('l.name')
            ->groupBy('cliente_id')
            ->distinct()
            ->first();
        
            //dd($cliente_base);

        $periodos_parametro = Hacademica::select('pe.id', 'pe.name as periodo_estudio')
        ->join('clientes as c', 'c.id', '=', 'hacademicas.cliente_id')
        ->join('materia as m','m.id','hacademicas.materium_id')
        ->join('materium_periodos as mp', 'mp.materium_id', '=', 'm.id')
        ->join('periodo_estudios as pe','pe.id','mp.periodo_estudio_id')
        ->join('grupo_periodo_estudios as gpe','gpe.periodo_estudio_id','pe.id')
        ->join('grupos as g','g.id','gpe.grupo_id')
        ->where('hacademicas.cliente_id', $cliente_base->cliente_id)
        ->whereColumn('g.id','hacademicas.grupo_id')
        ->where('pe.bnd_activo',1)
        ->whereNull('pe.deleted_at')
        ->whereNull('m.deleted_at')
        ->distinct()
        ->pluck('pe.id');
        //->get();
        //dd($periodos_parametro->toArray());

        
        //dd($periodos_parametro->toArray());
        $materias = PeriodoEstudio::select('periodo_estudios.name as periodo', 'm.id', 'm.name as materia', 'm.codigo')
            ->join('materium_periodos as mp', 'mp.periodo_estudio_id', '=', 'periodo_estudios.id')
            ->join('materia as m', 'm.id', '=', 'mp.materium_id')
            ->whereIn('periodo_estudios.id', $periodos_parametro)
            ->where('periodo_estudios.plantel_id', $datos['plantel_f'])
            ->where('periodo_estudios.especialidad_id', $datos['especialidad_f'])
            ->where('periodo_estudios.nivel_id', $datos['nivel_f'])
            ->where('periodo_estudios.grado_id', $datos['grado_f'])
            ->orderBy('periodo_estudios.orden')
            ->orderBy('m.id')
            ->get();

        $periodos = PeriodoEstudio::select(
            'periodo_estudios.name as periodo',
            'periodo_estudios.orden',
            'periodo_estudios.id',
            DB::raw('count(m.name) as cantidad_materias')
        )
            ->join('materium_periodos as mp', 'mp.periodo_estudio_id', '=', 'periodo_estudios.id')
            ->join('materia as m', 'm.id', '=', 'mp.materium_id')
            ->whereIn('periodo_estudios.id', $periodos_parametro)
            ->where('periodo_estudios.plantel_id', $datos['plantel_f'])
            ->where('periodo_estudios.especialidad_id', $datos['especialidad_f'])
            ->where('periodo_estudios.nivel_id', $datos['nivel_f'])
            ->where('periodo_estudios.grado_id', $datos['grado_f'])
            ->orderBy('periodo_estudios.orden')
            ->groupBy('periodo_estudios.name')
            ->groupBy('mp.periodo_estudio_id')
            ->groupBy('periodo_estudios.id')
            ->with('materias')
            ->get();

        $materias_array = array();
        foreach ($materias as $m) {
            array_push($materias_array, $m->id);
        }
        //dd($materias);

        $clientes = Hacademica::select('c.id', 'c.matricula', 'c.nombre', 'c.nombre2', 'c.ape_paterno', 'c.ape_materno')
            ->join('clientes as c', 'c.id', '=', 'hacademicas.cliente_id')
            ->join('inscripcions as i', 'i.id', '=', 'hacademicas.inscripcion_id')
            ->where('i.plantel_id', $cliente_base->plantel_id)
            ->where('hacademicas.especialidad_id', $cliente_base->especialidad_id)
            ->where('hacademicas.nivel_id', $cliente_base->nivel_id)
            ->where('hacademicas.grado_id', $cliente_base->grado_id)
            ->where('hacademicas.lectivo_id', $cliente_base->lectivo_id)
            ->where('hacademicas.grupo_id', $cliente_base->grupo_id)
            ->whereIn('materium_id', $materias_array)
            ->whereNull('i.deleted_at')
            ->whereNull('hacademicas.deleted_at')
            ->distinct()
            ->orderBy('c.ape_paterno')
            ->orderBy('c.ape_materno')
            ->orderBy('c.nombre')
            ->orderBy('c.nombre2')
            ->get();
        //dd($clientes);
        $registros = array();
        $encabezado = array();
        array_push($encabezado, 'Matricula');
        array_push($encabezado, 'Alumno');
        foreach ($materias as $materia) {
            array_push($encabezado, $materia->codigo);
        }
        array_push($registros, $encabezado);
        foreach ($clientes as $cliente) {
            $registro = array();
            array_push($registro, $cliente->matricula);
            array_push($registro, $cliente->nombre . " " . $cliente->nombre2 . " " . $cliente->ape_paterno . " " . $cliente->ape_materno);
            foreach ($materias as $materia) {
                $calificacion_historico = ConsultaCalificacion::where('matricula', 'like', "%" . $cliente->matricula . "%")
                    ->where('codigo', $materia->codigo)
                    ->first();

                if (is_null($calificacion_historico)) {
                    $calificacion = Hacademica::where('cliente_id', $cliente->id)
                        ->where('materium_id', $materia->id)
                        ->orderBy('id', 'desc')
                        ->whereNull('deleted_at')
                        ->first();
                    if (!is_null($calificacion)) {
                        if (!is_null($calificacion->calificaciones)) {
                            array_push($registro, optional($calificacion->calificaciones)->max('calificacion'));
                        }
                    }
                } else {
                    if ($calificacion_historico->calificacion >= 6) {
                        $calificacion = round($calificacion_historico->calificacion, 0);
                    } else {
                        $calificacion = intdiv($calificacion_historico->calificacion, 1);
                    }
                    array_push($registro, $calificacion);
                }

                //dd($cliente->id . "-" . $materia->id);


            }
            array_push($registros, $registro);
        }

        //dd($registros);

        return view("periodoEstudios.reportes.sabanaCalificacionesR", compact('registros', 'materias', 'periodos'));
    }
    */

    public function sabanaCalificacionesR(Request $request)
    {
        $datos = $request->all();

        //dd($datos);
        $cliente_base = Hacademica::select(
            'hacademicas.plantel_id',
            'p.razon',
            'hacademicas.especialidad_id',
            'esp.name as especialidad',
            'hacademicas.nivel_id',
            'n.name as nivel',
            'hacademicas.grado_id',
            'g.name as grado',
            'hacademicas.grupo_id',
            'gru.name as grupo',
            'hacademicas.lectivo_id',
            'l.name as lectivo',
            'cliente_id'
        )
            ->join('plantels as p', 'p.id', '=', 'hacademicas.plantel_id')
            ->join('especialidads as esp', 'esp.id', '=', 'hacademicas.especialidad_id')
            ->join('nivels as n', 'n.id', '=', 'hacademicas.nivel_id')
            ->join('grados as g', 'g.id', '=', 'hacademicas.grado_id')
            ->join('grupos as gru', 'gru.id', '=', 'hacademicas.grupo_id')
            ->join('lectivos as l', 'l.id', '=', 'hacademicas.lectivo_id')
            ->where('hacademicas.plantel_id', $datos['plantel_f'])
            ->where('hacademicas.especialidad_id', $datos['especialidad_f'])
            ->where('hacademicas.nivel_id', $datos['nivel_f'])
            ->where('hacademicas.grado_id', $datos['grado_f'])
            ->where('hacademicas.lectivo_id', $datos['lectivo_f'])
            ->where('hacademicas.grupo_id', $datos['grupo_f'])
            ->whereNull('hacademicas.deleted_at')
            ->orderBy('cliente_id', 'desc')
            ->groupBy('hacademicas.plantel_id')
            ->groupBy('p.razon')
            ->groupBy('hacademicas.especialidad_id')
            ->groupBy('esp.name')
            ->groupBy('hacademicas.nivel_id')
            ->groupBy('n.name')
            ->groupBy('hacademicas.grado_id')
            ->groupBy('g.name')
            ->groupBy('hacademicas.grupo_id')
            ->groupBy('gru.name')
            ->groupBy('hacademicas.lectivo_id')
            ->groupBy('l.name')
            ->groupBy('cliente_id')
            ->distinct()
            ->first();

        //dd($cliente_base);

        $periodo_base = Hacademica::select('pe.*')
            ->join('clientes as c', 'c.id', '=', 'hacademicas.cliente_id')
            ->join('materia as m', 'm.id', 'hacademicas.materium_id')
            ->join('materium_periodos as mp', 'mp.materium_id', '=', 'm.id')
            ->join('periodo_estudios as pe', 'pe.id', 'mp.periodo_estudio_id')
            ->join('grupo_periodo_estudios as gpe', 'gpe.periodo_estudio_id', 'pe.id')
            ->join('grupos as g', 'g.id', 'gpe.grupo_id')
            ->where('hacademicas.cliente_id', $cliente_base->cliente_id)
            ->whereColumn('g.id', 'hacademicas.grupo_id')
            ->where('pe.bnd_activo', 1)
            ->whereNull('pe.deleted_at')
            ->whereNull('m.deleted_at')
            ->distinct()
            ->first();
        //dd($periodo_base->toArray());

        $periodos_parametro = PeriodoEstudio::select('id', 'name as periodo_estudio', 'orden')
            ->where('plan_estudio_id', $periodo_base->plan_estudio_id)
            ->where('bnd_activo', 1)
            ->whereNull('deleted_at')
            ->orderBy('orden')
            ->distinct()
            ->pluck('pe.id');
        //->get();
        //dd($periodos_parametro->toArray());




        //dd($periodos_parametro->toArray());
        $materias = PeriodoEstudio::select('periodo_estudios.name as periodo', 'm.id', 'm.name as materia', 'm.codigo')
            ->join('materium_periodos as mp', 'mp.periodo_estudio_id', '=', 'periodo_estudios.id')
            ->join('materia as m', 'm.id', '=', 'mp.materium_id')
            ->whereIn('periodo_estudios.id', $periodos_parametro)
            ->where('periodo_estudios.plantel_id', $datos['plantel_f'])
            ->where('periodo_estudios.especialidad_id', $datos['especialidad_f'])
            ->where('periodo_estudios.nivel_id', $datos['nivel_f'])
            ->where('periodo_estudios.grado_id', $datos['grado_f'])
            ->orderBy('periodo_estudios.orden')
            ->orderBy('m.id')
            ->get();

        $periodos = PeriodoEstudio::select(
            'periodo_estudios.name as periodo',
            'periodo_estudios.orden',
            'periodo_estudios.id',
            DB::raw('count(m.name) as cantidad_materias')
        )
            ->join('materium_periodos as mp', 'mp.periodo_estudio_id', '=', 'periodo_estudios.id')
            ->join('materia as m', 'm.id', '=', 'mp.materium_id')
            ->whereIn('periodo_estudios.id', $periodos_parametro)
            ->where('periodo_estudios.plantel_id', $datos['plantel_f'])
            ->where('periodo_estudios.especialidad_id', $datos['especialidad_f'])
            ->where('periodo_estudios.nivel_id', $datos['nivel_f'])
            ->where('periodo_estudios.grado_id', $datos['grado_f'])
            ->orderBy('periodo_estudios.orden')
            ->groupBy('periodo_estudios.name')
            ->groupBy('mp.periodo_estudio_id')
            ->groupBy('periodo_estudios.id')
            ->with('materias')
            ->get();

        $materias_array = array();
        foreach ($materias as $m) {
            array_push($materias_array, $m->id);
        }
        //dd($materias);

        $clientes = Hacademica::select('c.id', 'c.matricula', 'c.nombre', 'c.nombre2', 'c.ape_paterno', 'c.ape_materno')
            ->join('clientes as c', 'c.id', '=', 'hacademicas.cliente_id')
            ->join('inscripcions as i', 'i.id', '=', 'hacademicas.inscripcion_id')
            ->where('i.plantel_id', $cliente_base->plantel_id)
            ->where('hacademicas.especialidad_id', $cliente_base->especialidad_id)
            ->where('hacademicas.nivel_id', $cliente_base->nivel_id)
            ->where('hacademicas.grado_id', $cliente_base->grado_id)
            ->where('hacademicas.lectivo_id', $cliente_base->lectivo_id)
            ->where('hacademicas.grupo_id', $cliente_base->grupo_id)
            ->whereIn('materium_id', $materias_array)
            ->whereNull('i.deleted_at')
            ->whereNull('hacademicas.deleted_at')
            ->distinct()
            ->orderBy('c.ape_paterno')
            ->orderBy('c.ape_materno')
            ->orderBy('c.nombre')
            ->orderBy('c.nombre2')
            ->get();
        //dd($clientes);
        $registros = array();
        $encabezado = array();
        array_push($encabezado, 'Matricula');
        array_push($encabezado, 'Alumno');
        foreach ($materias as $materia) {
            array_push($encabezado, $materia->codigo);
        }
        array_push($registros, $encabezado);
        foreach ($clientes as $cliente) {
            $registro = array();
            array_push($registro, $cliente->matricula);
            array_push($registro, $cliente->nombre . " " . $cliente->nombre2 . " " . $cliente->ape_paterno . " " . $cliente->ape_materno);
            foreach ($materias as $materia) {
                $calificacion_historico = ConsultaCalificacion::where('matricula', 'like', "%" . $cliente->matricula . "%")
                    ->where('codigo', $materia->codigo)
                    ->first();

                if (is_null($calificacion_historico)) {
                    $calificacion = Hacademica::where('cliente_id', $cliente->id)
                        ->where('materium_id', $materia->id)
                        ->orderBy('id', 'desc')
                        ->whereNull('deleted_at')
                        ->first();
                    if (!is_null($calificacion)) {
                        if (!is_null($calificacion->calificaciones)) {
                            array_push($registro, optional($calificacion->calificaciones)->max('calificacion'));
                        }
                    } else {
                        array_push($registro, 'N/A');
                    }
                } else {
                    if ($calificacion_historico->calificacion >= 6) {
                        $calificacion = round($calificacion_historico->calificacion, 0);
                    } else {
                        $calificacion = intdiv($calificacion_historico->calificacion, 1);
                    }
                    array_push($registro, $calificacion);
                }

                //dd($cliente->id . "-" . $materia->id);


            }
            array_push($registros, $registro);
        }

        //dd($registros);

        return view("periodoEstudios.reportes.sabanaCalificacionesR", compact('registros', 'materias', 'periodos'));
    }


    public function concentradoParciales()
    {
        $empleado = Empleado::where('user_id', Auth::user()->id)->first();
        $planteles_validos = $empleado->plantels->pluck('razon', 'id');
        return view("periodoEstudios.reportes.concentradoParciales", compact('planteles_validos'))
            ->with('list', PeriodoEstudio::getListFromAllRelationApps());
    }


    public function concentradoParcialesR(Request $request)
    {
        $datos = $request->all();



        $periodosEstudio = Hacademica::select('pe.id', 'pe.name as periodo')
            ->join('clientes as c', 'c.id', '=', 'hacademicas.cliente_id')
            ->join('inscripcions as i', 'i.id', '=', 'hacademicas.inscripcion_id')
            ->join('materia as m', 'm.id', 'hacademicas.materium_id')
            ->join('materium_periodos as mp', 'mp.materium_id', 'm.id')
            ->join('periodo_estudios as pe', 'pe.id', 'mp.periodo_estudio_id')
            ->where('i.plantel_id', $datos['plantel_f'])
            //->where('hacademicas.especialidad_id', $datos['especialidad_f'])
            //->where('hacademicas.nivel_id', $datos['nivel_f'])
            //->where('hacademicas.grado_id', $datos['grado_f'])
            ->where('hacademicas.lectivo_id', $datos['lectivo_f'])
            ->where('hacademicas.grupo_id', $datos['grupo_f'])
            ->whereColumn('hacademicas.periodo_estudio_id','pe.id')
            //->whereIn('pe.id', array(592, 593))
            ->whereNull('i.deleted_at')
            ->whereNull('hacademicas.deleted_at')
            ->distinct()
            ->get();

        //dd($periodosEstudio->toArray());



        $resultado = array();
        foreach ($periodosEstudio as $periodoEstudio) {
            /*$clientes = Hacademica::select(
                'c.id',
                'c.matricula',
                'c.nombre',
                'c.nombre2',
                'c.ape_paterno',
                'c.ape_materno'
            )
                ->join('clientes as c', 'c.id', '=', 'hacademicas.cliente_id')
                ->join('inscripcions as i', 'i.id', '=', 'hacademicas.inscripcion_id')
                ->join('materia as m','m.id','hacademicas.materium_id')
                ->join('materium_periodos as mp','mp.materium_id','m.id')
                //->join('periodo_estudios as pe','pe.id','mp.periodo_estudio_id')
                ->where('i.plantel_id', $datos['plantel_f'])
                //->where('hacademicas.especialidad_id', $datos['especialidad_f'])
                //->where('hacademicas.nivel_id', $datos['nivel_f'])
                //->where('hacademicas.grado_id', $datos['grado_f'])
                ->where('hacademicas.lectivo_id', $datos['lectivo_f'])
                ->where('hacademicas.grupo_id', $datos['grupo_f'])
                ->where('i.periodo_estudio_id', $periodoEstudio->id)
                ->whereNull('i.deleted_at')
                ->whereNull('hacademicas.deleted_at')
                ->distinct()
                ->orderBy('c.ape_paterno')
                ->orderBy('c.ape_materno')
                ->orderBy('c.nombre')
                ->orderBy('c.nombre2')
                ->get();
                */
            $clientes = Hacademica::select(
                'c.id',
                'c.matricula',
                'c.nombre',
                'c.nombre2',
                'c.ape_paterno',
                'c.ape_materno'
            )
                ->join('clientes as c', 'c.id', '=', 'hacademicas.cliente_id')
                //->join('inscripcions as i', 'i.id', '=', 'hacademicas.inscripcion_id')
                ->join('grupos as g', 'g.id', '=', 'hacademicas.grupo_id')
                ->join('grupo_periodo_estudios as gpe', 'gpe.grupo_id', '=', 'g.id')
                ->join('materia as m', 'm.id', 'hacademicas.materium_id')
                ->join('materium_periodos as mp', 'mp.materium_id', 'm.id')
                //->join('periodo_estudios as pe','pe.id','mp.periodo_estudio_id')
                ->where('hacademicas.plantel_id', $datos['plantel_f'])
                //->where('hacademicas.especialidad_id', $datos['especialidad_f'])
                //->where('hacademicas.nivel_id', $datos['nivel_f'])
                //->where('hacademicas.grado_id', $datos['grado_f'])
                ->where('hacademicas.lectivo_id', $datos['lectivo_f'])
                ->where('hacademicas.grupo_id', $datos['grupo_f'])
                ->where('gpe.periodo_estudio_id', $periodoEstudio->id)
                //->whereNull('i.deleted_at')
                ->whereNull('hacademicas.deleted_at')
                ->distinct()
                ->orderBy('c.ape_paterno')
                ->orderBy('c.ape_materno')
                ->orderBy('c.nombre')
                ->orderBy('c.nombre2')
                ->get();
            $registros = $this->armaTabla($clientes, $periodoEstudio);
            //dd($registros);
            if (count($registros) > 2) {
                array_push($resultado, $registros);
            }

            //break;
            //dd($registros);
        }
        //dd($resultado);


        return view("periodoEstudios.reportes.concentradoParcialesR", compact('resultado'));
    }

    public function armaTabla($clientes, $periodoEstudio)
    {
        //array_push($registros, $periodoEstudio);
        $materias = PeriodoEstudio::select('m.id', 'm.name as materia', 'm.codigo', DB::raw('count(cp.name) as total_ponderaciones'))
            ->join('materium_periodos as mp', 'mp.periodo_estudio_id', '=', 'periodo_estudios.id')
            ->join('materia as m', 'm.id', '=', 'mp.materium_id')
            ->join('carga_ponderacions as cp', 'cp.ponderacion_id', '=', 'm.ponderacion_id')
            ->where('cp.bnd_activo', 1)
            ->where('mp.periodo_estudio_id', $periodoEstudio->id)
            ->whereNull('m.deleted_at')
            ->whereNull('cp.deleted_at')
            ->orderBy('m.codigo')
            ->groupBy('m.codigo')
            ->groupBy('m.name')
            ->groupBy('m.id')
            ->get();
        //dd($materias->toArray());
        $ponderaciones = PeriodoEstudio::select('m.name as materia', 'm.codigo', 'm.id as materia_id', 'cp.id as carga_ponderacion_id', 'cp.name as nombre_ponderacion')
            ->join('materium_periodos as mp', 'mp.periodo_estudio_id', '=', 'periodo_estudios.id')
            ->join('materia as m', 'm.id', '=', 'mp.materium_id')
            ->join('carga_ponderacions as cp', 'cp.ponderacion_id', '=', 'm.ponderacion_id')
            ->where('cp.bnd_activo', 1)
            ->where('mp.periodo_estudio_id', $periodoEstudio->id)
            ->whereNull('m.deleted_at')
            ->whereNull('cp.deleted_at')
            ->orderBy('m.codigo')
            ->orderBy('cp.id')
            ->get();
        //dd($ponderaciones);

        /*
    $materias = PeriodoEstudio::select('m.id', 'm.name as materia', 'm.codigo', DB::raw('count(cp.name) as total_ponderaciones'))
        ->join('materium_periodos as mp', 'mp.periodo_estudio_id', '=', 'periodo_estudios.id')
        ->join('materia as m', 'm.id', '=', 'mp.materium_id')
        ->join('carga_ponderacions as cp', 'cp.ponderacion_id', '=', 'm.ponderacion_id')
        ->where('cp.bnd_activo', 1)
        ->where('mp.periodo_estudio_id', $datos['periodos_estudio'])
        ->whereNull('m.deleted_at')
        ->whereNull('cp.deleted_at')
        ->orderBy('m.codigo')
        ->groupBy('m.codigo')
        ->groupBy('m.name')
        ->groupBy('m.id')
        ->get();

    $ponderaciones = PeriodoEstudio::select('m.name as materia', 'm.codigo', 'm.id as materia_id', 'cp.id as carga_ponderacion_id', 'cp.name as nombre_ponderacion')
        ->join('materium_periodos as mp', 'mp.periodo_estudio_id', '=', 'periodo_estudios.id')
        ->join('materia as m', 'm.id', '=', 'mp.materium_id')
        ->join('carga_ponderacions as cp', 'cp.ponderacion_id', '=', 'm.ponderacion_id')
        ->where('cp.bnd_activo', 1)
        ->where('mp.periodo_estudio_id', $datos['periodos_estudio'])
        ->whereNull('m.deleted_at')
        ->whereNull('cp.deleted_at')
        ->orderBy('m.codigo')
        ->orderBy('cp.id')
        ->get();
    
    

    $clientes = Hacademica::select('c.id', 'c.matricula', 'c.nombre', 'c.nombre2', 'c.ape_paterno', 'c.ape_materno')
        ->join('clientes as c', 'c.id', '=', 'hacademicas.cliente_id')
        ->join('inscripcions as i', 'i.id', '=', 'hacademicas.inscripcion_id')
        ->where('i.plantel_id', $datos['plantel_f'])
        ->where('hacademicas.especialidad_id', $datos['especialidad_f'])
        ->where('hacademicas.nivel_id', $datos['nivel_f'])
        ->where('hacademicas.grado_id', $datos['grado_f'])
        ->where('hacademicas.lectivo_id', $datos['lectivo_f'])
        ->where('hacademicas.grupo_id', $datos['grupo_f'])
        ->whereNull('i.deleted_at')
        ->whereNull('hacademicas.deleted_at')
        ->distinct()
        ->orderBy('c.ape_paterno')
        ->orderBy('c.ape_materno')
        ->orderBy('c.nombre')
        ->orderBy('c.nombre2')
        ->get();
        */
        //dd($clientes->ToArray());

        $registros = array();
        $encabezado0 = array();
        array_push($encabezado0, 'encabezado0');
        foreach ($materias as $m) {
            array_push($encabezado0, $m->codigo);
            array_push($encabezado0, $m->materia);
            array_push($encabezado0, $m->total_ponderaciones);
        }
        array_push($registros, $encabezado0);


        $encabezado = array();
        array_push($encabezado, 'Periodo Estudio');
        array_push($encabezado, 'Matricula');
        array_push($encabezado, 'Alumno');
        foreach ($ponderaciones as $ponderacion) {
            array_push($encabezado, $ponderacion->nombre_ponderacion);
        }
        array_push($registros, $encabezado);
        //dd($registros);
        foreach ($clientes as $cliente) {
            $registro = array();
            array_push($registro, $periodoEstudio->periodo);
            array_push($registro, $cliente->matricula);
            array_push($registro, $cliente->nombre . " " . $cliente->nombre2 . " " . $cliente->ape_paterno . " " . $cliente->ape_materno);

            $sumatoria_cali = 0;
            $cantidad_cali = 0;

            $contador = 0;
            //dd($ponderaciones);
            foreach ($ponderaciones as $ponderacion) {
                //Obtener calificacion por parcial
                $calificacion = Hacademica::select('cc.calificacion_parcial')
                    ->join('calificacions as c', 'c.hacademica_id', '=', 'hacademicas.id')
                    ->join('calificacion_ponderacions as cc', 'cc.calificacion_id', '=', 'c.id')
                    ->where('cliente_id', $cliente->id)
                    ->where('materium_id', $ponderacion->materia_id)
                    ->where('cc.carga_ponderacion_id', $ponderacion->carga_ponderacion_id)
                    //->whereIn('hacademicas.materium_id', $materias_array)
                    ->orderBy('c.calificacion', 'desc')
                    ->whereNull('hacademicas.deleted_at')
                    ->whereNull('c.deleted_at')
                    ->whereNull('cc.deleted_at')
                    ->first();
                //dd($calificacion->toArray());

                if (is_null($calificacion)) {
                    //dd($registros);
                    array_push($registro, 0);
                    //array_push($registro, 0);
                } else {
                    array_push($registro, $calificacion->calificacion_parcial);
                    //dd($registro);

                    if ($calificacion->calificacion_parcial > 0) {
                        $sumatoria_cali = $sumatoria_cali + $calificacion->calificacion_parcial;
                        $cantidad_cali++;
                    }
                    //
                }

                //dd($cliente->id . "-" . $materia->id);
            }
            //dd($sumatoria_cali ."/". $cantidad_cali);
            if ($cantidad_cali > 0) {
                //dd($sumatoria_cali ."/". $cantidad_cali);
                array_push($registro, round($sumatoria_cali / $cantidad_cali, 1));
            } else {
                array_push($registro, 0);
            }
            //dd($registro);


            //array_push($registro, $cantidad_calificaciones);
            array_push($registros, $registro);
            //dd($registros);
        }
        //dd($registros);
        $suma_calificaciones = array();
        $cantidad = array();
        $promedios = array();
        $i = 0;

        foreach ($registros as $registro) {
            $j = 0;
            //dd($registro);
            foreach ($registro as $celda) {
                //dd($registro);
                if (!is_string($celda)) {
                    //dd($celda);
                    if (!array_key_exists($j, $suma_calificaciones)) {
                        $suma_calificaciones[$j] = 0;
                    }
                    $suma_calificaciones[$j] = $suma_calificaciones[$j] + floatval($celda);
                    if (!array_key_exists($j, $cantidad)) {
                        $cantidad[$j] = 0;
                    }
                    $cantidad[$j]++;
                    $j++;
                }
            }
            $i++;
        }
        $i = 0;
        foreach ($suma_calificaciones as $suma) {
            $promedios[$i] = round($suma / $cantidad[$i], 1);
            $i++;
        }

        //dd($registros);

        return $registros;
    }

    public function gruposOrdinarios()
    {
        $empleado = Empleado::where('user_id', Auth::user()->id)->first();
        $planteles_validos = $empleado->plantels->pluck('razon', 'id');
        $lectivos = Lectivo::pluck('name', 'id');
        $stEmpleados = StEmpleado::pluck('name', 'id');
        return view('periodoEstudios.reportes.gruposOrdinarios', compact('planteles_validos', 'lectivos', 'stEmpleados'))
            ->with('list', PeriodoEstudio::getListFromAllRelationApps());
    }

    public function gruposOrdinariosR(Request $request)
    {
        $datos = $request->all();
        //dd($datos);

        $registros = Empleado::select(
            'g.rvoe',
            'l.ciclo_escolar',
            'l.periodo_escolar',
            'gru.name as grupo',
            DB::raw('SUBSTR(gru.name,-1) as grupo_letra, SUBSTR(gru.name,1,1) as grupo_numero'),
            'm.orden as orden_materia',
            //'pe.orden as orden_periodo_estudios',
            'j.name as jornada',
            'm.codigo as clave',
            'g.id_mapa',
            'empleados.curp'
            //'pe.id as periodo_estudio',
            //'m.id as materia_id'
        )
            ->leftJoin('asignacion_academicas as aa', 'aa.docente_oficial_id', '=', 'empleados.id')
            ->leftJoin('lectivos as l', 'l.id', '=', 'aa.lectivo_id')
            ->leftJoin('materia as m', 'm.id', '=', 'aa.materium_id')
            ->leftJoin('hacademicas as h', 'h.materium_id', '=', 'm.id')
            ->leftJoin('clientes as cli', 'cli.id', '=', 'h.cliente_id')
            ->leftJoin('grupos as gru', 'gru.id', '=', 'h.grupo_id')
            ->leftJoin('jornadas as j', 'j.id', '=', 'gru.jornada_id')
            ->leftJoin('inscripcions as i', 'i.id', '=', 'h.inscripcion_id')
            ->leftJoin('periodo_estudios as pe', 'pe.id', '=', 'i.periodo_estudio_id')
            ->whereColumn('h.lectivo_id', 'aa.lectivo_id')
            ->whereColumn('h.grupo_id', 'aa.grupo_id')
            ->whereColumn('h.plantel_id', 'aa.plantel_id')
            ->leftJoin('grados as g', 'g.id', '=', 'h.grado_id')
            ->where('aa.lectivo_id', $datos['lectivo_f'])
            ->where('aa.plantel_id', $datos['plantel_f'])
            ->where('m.bnd_oficial', 1)
            //->whereNotIn('cli.st_cliente_id', array(3,26))
            //->whereIn('empleados.st_empleado_id', $datos['estatus_f'])
            //->where('empleados.puesto_id', 3)
            ->WhereNull('empleados.deleted_at')
            ->WhereNull('i.deleted_at')
            ->WhereNull('h.deleted_at')
            ->WhereNull('aa.deleted_at')
            ->WhereNull('m.deleted_at')
            ->WhereNull('pe.deleted_at')
            ->WhereNull('g.deleted_at')
            ->orderBy('grupo_numero')
            ->orderBy('grupo_letra')
            ->orderBy('m.orden')
            ->distinct()
            ->get();
        //dd($registros);

        return view('periodoEstudios.reportes.gruposOrdinariosR', compact('registros'));
    }
}
