<?php

namespace App\Http\Controllers;

use App\AsignacionAcademica;
use App\AsistenciaR;
use App\Calificacion;
use App\CalificacionPonderacion;
use App\CargaPonderacion;
use App\Cliente;
use App\DiaNoHabil;
use App\Empleado;
use App\Especialidad;
use App\Grado;
use App\Grupo;
use App\Hacademica;
use App\Http\Controllers\Controller;
use App\Http\Requests\createInscripcion;
use App\Http\Requests\updateInscripcion;
use App\ImpresionListaAsisten;
use App\Inscripcion;
use App\Lectivo;
use App\Materium;
use App\Mese;
use App\PeriodoEstudio;
use App\Plantel;
use App\Ponderacion;
use App\StCliente;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Log;

class InscripcionsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $inscripcions = Inscripcion::getAllData($request);

        return view('inscripcions.index', compact('inscripcions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('inscripcions.create')
            ->with('list', Inscripcion::getListFromAllRelationApps());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(createInscripcion $request)
    {

        $input = $request->all();
        //dd($input);

        $input['usu_alta_id'] = Auth::user()->id;
        $input['usu_mod_id'] = Auth::user()->id;
        $input['st_inscripcion_id'] = 1;

        $plantel = Plantel::find($input['plantel_id']);
        $input['control'] =

            //create data
            $i = Inscripcion::create($input);

        $lectivo = Lectivo::find($i->lectivo_id);
        $fecha = Carbon::createFromFormat('Y-m-d', $lectivo->inicio)->format('y-m-d');
        $especialidad = Especialidad::find($i->especialidad_id);
        //dd($especialidad);
        $relleno = "0000000";
        $consecutivo = substr($relleno, 0, 7 - strlen($i->cliente_id)) . $i->cliente_id;
        //dd($consecutivo);
        if ($especialidad->abreviatura != "") {
            $entrada['matricula'] = date('m', strtotime($fecha)) . date('y', strtotime($fecha)) . $especialidad->abreviatura . $consecutivo;
            //$i->update($entrada);
            $cliente = Cliente::where('id', $i->cliente_id)->first();
            if ($cliente->matricula == "") {
                $cliente->matricula = $entrada['matricula'];
            }
            $cliente->save();
        }

        $combinacion = \App\CombinacionCliente::find($i->combinacion_cliente_id);
        if (count($combinacion) > 0) {
            $combinacion->plantel_id = $i->plantel_id;
            if ($combinacion->plantel_id != $i->plantel_id) {
                $cliente = Cliente::find($combinacion->cliente_id);
                $cliente->plantel_id = $inscripcion->plantel_id;
                $cliente->save();
                $combinacion->especialidad_id = $i->especialidad_id;
                $combinacion->nivel_id = $i->nivel_id;
                $combinacion->grado_id = $i->grado_id;
                $combinacion->save();
            }
        }

        //dd($i);

        return redirect()->route('inscripcions.index')->with('message', 'Registro Creado.');
    }

    public function registrarMaterias($id)
    {
        $i = Inscripcion::find($id);
        //dd($i);
        $materias = PeriodoEstudio::find($i->periodo_estudio_id)->materias;
        $materias_array = array();
        foreach ($materias as $m) {
            array_push($materias_array, $m->id);
        }
        //dd($materias);
        $materias_validar = Hacademica::where('hacademicas.grupo_id', '=', $i->grupo_id)
            ->join('inscripcions as i', 'i.id', '=', 'hacademicas.inscripcion_id')
            ->whereNull('i.deleted_at')
            ->where('hacademicas.cliente_id', '=', $i->cliente_id)
            ->where('hacademicas.grado_id', '=', $i->grado_id)
            ->where('hacademicas.lectivo_id', '=', $i->lectivo_id)
            ->whereIn('hacademicas.materium_id', $materias_array)
            ->where('hacademicas.inscripcion_id', $i->id)
            ->whereNull('i.deleted_at')
            ->whereNull('hacademicas.deleted_at')
            ->get();
        //dd($materias_validar);
        /*$materias_validar=Hacademica::where('inscripcion_id', '=', $i->id)
        ->whereNull('deleted_at')
        ->get();*/
        //dd($materias_validar->count());
        if ($materias_validar->count() == 0) {
            foreach ($materias as $m) {
                //dd($materias->toArray());
                $h['inscripcion_id'] = $i->id;
                $h['cliente_id'] = $i->cliente_id;
                $h['plantel_id'] = $i->plantel_id;
                $h['especialidad_id'] = $i->especialidad_id;
                $h['nivel_id'] = $i->nivel_id;
                $h['grado_id'] = $i->grado_id;
                $h['grupo_id'] = $i->grupo_id;
                $h['materium_id'] = $m->id;
                $h['st_materium_id'] = 0;
                $h['lectivo_id'] = $i->lectivo_id;
                $h['usu_alta_id'] = Auth::user()->id;
                $h['usu_mod_id'] = Auth::user()->id;
                $ha = Hacademica::create($h);
                //$h=new Hacademica;
                //$h->save($h);
                $c['hacademica_id'] = $ha->id;
                $c['tpo_examen_id'] = 1;
                $c['calificacion'] = 0;
                $c['fecha'] = date('Y-m-d');
                $c['reporte_bnd'] = 0;
                $c['usu_alta_id'] = Auth::user()->id;
                $c['usu_mod_id'] = Auth::user()->id;
                $calif = Calificacion::create($c);

                $ponderaciones = CargaPonderacion::where('ponderacion_id', '=', $m->ponderacion_id)
                    ->where('bnd_activo', 1)
                    ->get();

                foreach ($ponderaciones as $p) {
                    $ponde['calificacion_id'] = $calif->id;
                    $ponde['carga_ponderacion_id'] = $p->id;
                    $ponde['calificacion_parcial'] = 0;
                    $ponde['ponderacion'] = $p->porcentaje;
                    $ponde['usu_alta_id'] = Auth::user()->id;
                    $ponde['usu_mod_id'] = Auth::user()->id;
                    $ponde['tiene_detalle'] = $p->tiene_detalle;
                    $ponde['padre_id'] = $p->padre_id;
                    CalificacionPonderacion::create($ponde);
                }
            }
        } else {
            foreach ($materias as $m) {
                $existe_materia = 0;
                foreach ($materias_validar as $mv) {
                    if ($mv->materium_id == $m->id) {
                        $existe_materia = 1;
                    }
                }
                //dd($existe_materia);
                if ($existe_materia == 0) {
                    $h['inscripcion_id'] = $i->id;
                    $h['cliente_id'] = $i->cliente_id;
                    $h['plantel_id'] = $i->plantel_id;
                    $h['especialidad_id'] = $i->especialidad_id;
                    $h['nivel_id'] = $i->nivel_id;
                    $h['grado_id'] = $i->grado_id;
                    $h['grupo_id'] = $i->grupo_id;
                    $h['materium_id'] = $m->id;
                    $h['st_materium_id'] = 0;
                    $h['lectivo_id'] = $i->lectivo_id;
                    $h['usu_alta_id'] = Auth::user()->id;
                    $h['usu_mod_id'] = Auth::user()->id;
                    $ha = Hacademica::create($h);
                    //$h=new Hacademica;
                    //$h->save($h);
                    $c['hacademica_id'] = $ha->id;
                    $c['tpo_examen_id'] = 1;
                    $c['calificacion'] = 0;
                    $c['fecha'] = date('Y-m-d');
                    $c['reporte_bnd'] = 0;
                    $c['usu_alta_id'] = Auth::user()->id;
                    $c['usu_mod_id'] = Auth::user()->id;
                    $calif = Calificacion::create($c);

                    $ponderaciones = CargaPonderacion::where('ponderacion_id', '=', $m->ponderacion_id)
                        ->where('bnd_activo', 1)
                        ->get();

                    foreach ($ponderaciones as $p) {
                        $ponde['calificacion_id'] = $calif->id;
                        $ponde['carga_ponderacion_id'] = $p->id;
                        $ponde['calificacion_parcial'] = 0;
                        $ponde['ponderacion'] = $p->porcentaje;
                        $ponde['usu_alta_id'] = Auth::user()->id;
                        $ponde['usu_mod_id'] = Auth::user()->id;
                        $ponde['tiene_detalle'] = $p->tiene_detalle;
                        $ponde['padre_id'] = $p->padre_id;
                        CalificacionPonderacion::create($ponde);
                    }
                }
            }
        }

        return redirect()->route('clientes.edit', $i->cliente_id)->with('message', 'Registro Actualizado.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id, Inscripcion $inscripcion)
    {
        $inscripcion = $inscripcion->find($id);
        return view('inscripcions.show', compact('inscripcion'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id, Inscripcion $inscripcion)
    {
        $inscripcion = $inscripcion->find($id);

        return view('inscripcions.edit', compact('inscripcion'))
            ->with('list', Inscripcion::getListFromAllRelationApps());
    }

    /**
     * Show the form for duplicatting the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function duplicate($id, Inscripcion $inscripcion)
    {
        $inscripcion = $inscripcion->find($id);
        return view('inscripcions.duplicate', compact('inscripcion'))
            ->with('list', Inscripcion::getListFromAllRelationApps());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param Request $request
     * @return Response
     */
    public function update($id, Inscripcion $inscripcion, updateInscripcion $request)
    {
        $input = $request->all();
        $input['usu_mod_id'] = Auth::user()->id;
        //update data
        $inscripcion = $inscripcion->find($id);
        $inscripcion->update($input);

        $lectivo = Lectivo::find($inscripcion->lectivo_id);
        $fecha = Carbon::createFromFormat('Y-m-d', $lectivo->inicio)->format('y-m-d');
        $especialidad = Especialidad::find($inscripcion->especialidad_id);
        //dd($especialidad);
        $relleno = "0000000";
        $consecutivo = substr($relleno, 0, 7 - strlen($inscripcion->cliente_id)) . $inscripcion->cliente_id;
        //dd($consecutivo);
        if ($especialidad->abreviatura != "") {
            $entrada['matricula'] = date('m', strtotime($fecha)) . date('y', strtotime($fecha)) . $especialidad->abreviatura . $consecutivo;
            $inscripcion->update($entrada);
        }

        if ($inscripcion->combinacion_cliente_id != 0) {
            $combinacion = \App\CombinacionCliente::find($inscripcion->combinacion_cliente_id);
            if ($combinacion->plantel_id != $inscripcion->plantel_id) {
                $cliente = Cliente::find($combinacion->cliente_id);
                $cliente->plantel_id = $inscripcion->plantel_id;
                $cliente->save();
            }
            if (count($combinacion) > 0) {
                $combinacion->plantel_id = $inscripcion->plantel_id;
                $combinacion->especialidad_id = $inscripcion->especialidad_id;
                $combinacion->nivel_id = $inscripcion->nivel_id;
                $combinacion->grado_id = $inscripcion->grado_id;
                $combinacion->save();
            }
        }

        return redirect()->route('inscripcions.index')->with('message', 'Registro Actualizado.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id, Inscripcion $inscripcion)
    {
        $inscripcion = $inscripcion->find($id);
        $inscripcion->delete();

        return redirect()->route('inscripcions.index')->with('message', 'Registro Borrado.');
    }

    public function destroyCli($id, Inscripcion $inscripcion)
    {
        $inscripcion = $inscripcion->find($id);
        //dd($id);
        $i = $inscripcion->id;
        $cli = $inscripcion->cliente_id;
        $inscripcion->delete();
        $hacademicas = Hacademica::where('inscripcion_id', $i)->get();
        if ($hacademicas->count() > 0) {
            foreach ($hacademicas as $h) {
                $h->delete();
            }
        }
        //$hacademica->delete();

        return redirect()->route('clientes.edit', $cli)->with('message', 'Registro Borrado.');
    }

    public function getReinscripcion()
    {
        return view('inscripcions.reinscripcion')
            ->with('list', Inscripcion::getListFromAllRelationApps());
    }

    public function postReinscripcion(Request $request)
    {
        $input = $request->all();

        //dd($input);
        if (isset($input['id']) and isset($input['grupo_to']) and isset($input['lectivo_to'])) {

            foreach ($input['id'] as $key => $value) {
                $id = $value;
                $posicion = $key;
                $i = Inscripcion::find($id);
                if (
                    isset($input['activar-field']) and
                    isset($input['especialidad_to']) and
                    isset($input['nivel_to']) and
                    isset($input['grado_to'])
                ) {
                    $i->especialidad = $input['especialidad_to'];
                    $i->nivel = $input['nivel_to'];
                    $i->grado = $input['grado_to'];
                }
                //if($i->grupo_id<>$input['grupo_to'] and $i->lectivo_id<>$input['lectivo_to'] and $i->periodo_estudio_id<>$input['periodo_estudios_to']){
                $i->grupo_id = $input['grupo_to'];
                $i->lectivo_id = $input['lectivo_to'];
                $i->periodo_estudio_id = $input['periodo_estudios_to'];
                $i->save();
                if (isset($input['registrar_materias'])) {
                    $this->registrarMaterias($id);
                }
                //}
            }
        }
        if (isset($input['plantel_id']) and isset($input['lectivo_id']) and isset($input['grupo_id'])) {
            $clientes = Cliente::join('inscripcions as i', 'i.cliente_id', '=', 'clientes.id')
                ->join('hacademicas as h', 'h.inscripcion_id', 'i.id')
                ->join('periodo_estudios as p', 'p.id', '=', 'i.periodo_estudio_id')
                ->select(
                    'i.id',
                    'clientes.id as cliente',
                    'p.name as periodo_estudio',
                    'st_cliente_id',
                    DB::raw('concat(clientes.nombre," ",clientes.nombre2," ",clientes.ape_paterno," ",clientes.ape_materno) as nombre')
                )
                //->whereColumn('h.lectivo_id','i.lectivo_id')
                ->where('i.plantel_id', '=', $input['plantel_id'])
                ->where('i.especialidad_id', '=', $input['especialidad_id'])
                ->where('i.nivel_id', '=', $input['nivel_id'])
                ->where('i.grupo_id', '=', $input['grupo_id'])
                ->where('i.lectivo_id', '=', $input['lectivo_id'])
                ->where('h.lectivo_id', '=', $input['lectivo_id'])
                ->where('i.plantel_id', '=', $input['plantel_id'])
                ->where('clientes.st_cliente_id', '<>', 3)
                ->whereNull('i.deleted_at')
                ->distinct()
                ->get();
            //dd($clientes);
            $resultado = collect();
            $resultados = collect();
            foreach ($clientes as $c) {

                $aprobadas = Cliente::join('inscripcions as i', 'i.cliente_id', '=', 'clientes.id')
                    ->join('periodo_estudios as p', 'p.id', '=', 'i.periodo_estudio_id')
                    ->join('hacademicas as h', 'h.inscripcion_id', 'i.id')
                    ->select(DB::raw('count(h.materium_id) as aprobadas'))
                    //->whereColumn('h.lectivo_id','i.lectivo_id')
                    ->where('i.plantel_id', '=', $input['plantel_id'])
                    ->where('i.especialidad_id', '=', $input['especialidad_id'])
                    ->where('i.nivel_id', '=', $input['nivel_id'])
                    ->where('i.grupo_id', '=', $input['grupo_id'])
                    ->where('i.lectivo_id', '=', $input['lectivo_id'])
                    ->where('i.plantel_id', '=', $input['plantel_id'])
                    ->where('clientes.id', '=', $c->cliente)
                    ->where('h.st_materium_id', '=', 1)
                    ->whereNull('h.deleted_at')
                    ->first('aprobadas');

                $aprobadas_modulo = Cliente::join('inscripcions as i', 'i.cliente_id', '=', 'clientes.id')
                    ->join('periodo_estudios as p', 'p.id', '=', 'i.periodo_estudio_id')
                    ->join('hacademicas as h', 'h.inscripcion_id', 'i.id')
                    ->join('materia as m', 'm.id', '=', 'h.materium_id')
                    ->select('m.id', 'm.name as materia', 'm.modulo_id', 'm.seriada_bnd')
                    //->whereColumn('h.lectivo_id','i.lectivo_id')
                    ->where('i.plantel_id', '=', $input['plantel_id'])
                    ->where('i.especialidad_id', '=', $input['especialidad_id'])
                    ->where('i.nivel_id', '=', $input['nivel_id'])
                    ->where('i.grupo_id', '=', $input['grupo_id'])
                    ->where('i.lectivo_id', '=', $input['lectivo_id'])
                    ->where('i.plantel_id', '=', $input['plantel_id'])
                    ->where('clientes.id', '=', $c->cliente)
                    ->where('h.st_materium_id', '=', 1)
                    ->whereNull('h.deleted_at')
                    ->get();
                //dd($aprobadas_modulo);

                /*$no_aprobadas=Cliente::join('inscripcions as i', 'i.cliente_id', '=', 'clientes.id')
                ->join('periodo_estudios as p','p.id','=','i.periodo_estudio_id')
                ->join('hacademicas as h', 'h.inscripcion_id', 'i.id')
                ->select(DB::raw('count(h.materium_id) as no_aprobadas'))
                //->whereColumn('h.lectivo_id','i.lectivo_id')
                ->where('i.plantel_id', '=', $input['plantel_id'])
                ->where('i.especialidad_id', '=', $input['especialidad_id'])
                ->where('i.nivel_id', '=', $input['nivel_id'])
                ->where('i.grupo_id', '=', $input['grupo_id'])
                ->where('i.lectivo_id', '=', $input['lectivo_id'])
                ->where('i.plantel_id', '=', $input['plantel_id'])
                ->where('clientes.id', '=', $c->cliente)
                ->where('h.st_materium_id', '<>', 1)
                ->whereNull('h.deleted_at')
                ->first('no_aprobadas');
                 */

                $no_aprobadas_modulo = Cliente::join('inscripcions as i', 'i.cliente_id', '=', 'clientes.id')
                    ->join('periodo_estudios as p', 'p.id', '=', 'i.periodo_estudio_id')
                    ->join('hacademicas as h', 'h.inscripcion_id', 'i.id')
                    ->join('materia as m', 'm.id', '=', 'h.materium_id')
                    ->select('m.id', 'm.name as materia', 'm.modulo_id', 'm.seriada_bnd')
                    //->whereColumn('h.lectivo_id','i.lectivo_id')
                    ->where('i.plantel_id', '=', $input['plantel_id'])
                    ->where('i.especialidad_id', '=', $input['especialidad_id'])
                    ->where('i.nivel_id', '=', $input['nivel_id'])
                    ->where('i.grupo_id', '=', $input['grupo_id'])
                    ->where('i.lectivo_id', '=', $input['lectivo_id'])
                    ->where('i.plantel_id', '=', $input['plantel_id'])
                    ->where('clientes.id', '=', $c->cliente)
                    ->where('h.st_materium_id', '<>', 1)
                    ->whereNull('h.deleted_at')
                    ->get();
                //                        $resultado->put('id',$c->id);
                //                        $resultado->put('nombre',$c->nombre);
                //                        $resultado->put('periodo_estudio',$c->periodo_estudio);
                //                        $resultado->put('aprobadas',$aprobadas->aprobadas);
                //                        $resultado->put('no_aprobadas',$no_aprobadas->no_aprobadas);
                $contar_materias_no_aprobadas = 0;
                foreach ($no_aprobadas_modulo as $no_aprobada) {
                    if ($no_aprobada->seriada_bnd == 1) {
                        $marcador = 0;
                        foreach ($aprobadas_modulo as $aprobada) {
                            if ($aprobada->seriada_bnd == 1 and $aprobada->modulo_id == $no_aprobada->modulo_id) {
                                $marcador = 1;
                            } else {
                                //$contar_materias++;
                            }
                        }
                        if ($marcador == 0) {
                            $contar_materias_no_aprobadas++;
                        }
                    } else {
                        $contar_materias_no_aprobadas++;
                    }
                }
                //dd($aprobadas_modulo->toArray());

                //dd($contar_materias);
                $st = StCliente::find($c->st_cliente_id);
                $resultados->push([
                    'id' => $c->id,
                    'nombre' => $c->nombre,
                    'cliente' => $c->cliente,
                    'st_cliente' => $st->name,
                    'periodo_estudio' => $c->periodo_estudio,
                    'aprobadas' => $aprobadas->aprobadas,
                    'no_aprobadas' => $contar_materias_no_aprobadas,
                    'aprobadas_modulo' => $aprobadas_modulo,
                    'no_aprobadas_modulo' => $no_aprobadas_modulo,
                ]);
            }
        }

        //dd($clientes->toArray());
        //dd($resultados);
        return view('inscripcions.reinscripcion', compact('resultados', 'input'))
            ->with('list', Hacademica::getListFromAllRelationApps());

        /*return redirect('/inscripcions/reinscripcion', compact('resultados'))
    ->with('list', Hacademica::getListFromAllRelationApps())->withInput();
     */
    }

    public function lista(Request $request)
    {
        $datos = $request->all();
        $asignacion = AsignacionAcademica::find($datos['asignacion']);
        //dd($asignacion->toArray());
        $meses = Mese::pluck('name', 'id');
        $materias = Materium::pluck('name', 'id');
        $instructores = Empleado::where('puesto_id', 3)->pluck('nombre', 'id');
        return view('inscripcions.reportes.lista_alumnos', compact('meses', 'materias', 'instructores', 'asignacion'))
            ->with('list', Inscripcion::getListFromAllRelationApps());
    }

    public function listar(Request $request)
    {
        $data = $request->all();

        $registros = Hacademica::select(
            'hacademicas.grupo_id',
            'hacademicas.grado_id',
            'hacademicas.lectivo_id',
            'hacademicas.plantel_id',
            'c.nombre',
            'c.nombre2',
            'c.ape_paterno',
            'c.ape_materno',
            'g.name as grupo',
            'l.name as lectivo',
            'mat.name as materia',
            DB::raw('concat(e.nombre," ",e.ape_paterno," ",e.ape_materno) as maestro'),
            'gra.name as grado',
            'gra.denominacion',
            'p.razon as plantel',
            'esp.imagen as logo',
            'aa.id as asignacion',
            'c.id as cliente',
            'p.id as p_id',
            'c.tel_fijo'
        )
            ->join('inscripcions as i', 'i.id', '=', 'hacademicas.inscripcion_id')
            ->join('materia as mat', 'mat.id', '=', 'hacademicas.materium_id')
            ->join('clientes as c', 'c.id', '=', 'hacademicas.cliente_id')
            ->join('grupos as g', 'g.id', '=', 'hacademicas.grupo_id')
            ->join('lectivos as l', 'l.id', '=', 'hacademicas.lectivo_id')
            ->join('asignacion_academicas as aa', 'aa.grupo_id', '=', 'g.id')
            //->join('asistencia_rs as asis', 'asis.asignacion_academica_id','=','aa.id')
            ->join('empleados as e', 'e.id', '=', 'aa.empleado_id')
            ->join('grados as gra', 'gra.id', '=', 'hacademicas.grado_id')
            ->join('plantels as p', 'p.id', '=', 'c.plantel_id')
            ->join('especialidads as esp', 'esp.id', '=', 'hacademicas.especialidad_id')
            ->where('c.st_cliente_id', '<>', 3)
            ->where('c.st_cliente_id', '<>', 1)
            ->where('aa.id', $data['asignacion'])
            ->where('hacademicas.plantel_id', $data['plantel_f'])
            ->where('hacademicas.lectivo_id', $data['lectivo_f'])
            ->where('hacademicas.grupo_id', $data['grupo_f'])
            //->where('inscripcions.grado_id',$data['grado_f'])
            ->where('aa.plantel_id', $data['plantel_f'])
            ->where('aa.lectivo_id', $data['lectivo_f'])
            ->where('aa.grupo_id', $data['grupo_f'])
            ->where('aa.empleado_id', $data['instructor_f'])
            ->where('aa.materium_id', $data['materia_f'])
            ->where('hacademicas.materium_id', $data['materia_f'])
            ->whereNull('hacademicas.deleted_at')
            ->whereNull('aa.deleted_at')
            ->whereNull('i.deleted_at')
            ->orderBy('hacademicas.plantel_id')
            ->orderBy('hacademicas.lectivo_id')
            ->orderBy('hacademicas.grupo_id')
            //->orderBy('hacademicas.grado_id')
            ->orderBy('c.ape_paterno')
            ->orderBy('c.ape_materno')

            ->distinct()
            ->get();

        $total_alumnos = 0;
        foreach ($registros as $r) {
            $total_alumnos++;
        }

        //dd($registros->toArray());

        //Agregar fechas
        $asignacion = AsignacionAcademica::find($data['asignacion']);

        $dias = array();
        //dd($asignacion);
        foreach ($asignacion->horarios as $horario) {
            array_push($dias, $horario->dia->name);
        }
        //dd($dias);

        $fechas = array();
        $lectivo = Lectivo::find($data['lectivo_f']);
        //dd($lectivo);
        $data['fecha_f'] = $lectivo->inicio;
        $data['fecha_t'] = $lectivo->fin;
        $diasNoHabiles = DiaNoHabil::distinct()
            ->where('fecha', '>=', $lectivo->inicio)
            ->where('fecha', '<=', $lectivo->fin)
            ->get();

        $no_habiles = array();
        foreach ($diasNoHabiles as $no_habil) {
            array_push($no_habiles, Carbon::createFromFormat('Y-m-d', $no_habil->fecha));
        }
        //dd($no_habiles);
        $pinicio = Carbon::createFromFormat('Y-m-d', $asignacion->fec_inicio);
        $pfin = Carbon::createFromFormat('Y-m-d', $asignacion->fec_fin);

        $total_asistencias = 0;
        while ($pfin->greaterThanOrEqualTo($pinicio)) {

            if (in_array('Lunes', $dias)) {
                //dd("hay lunes");
                if ($pinicio->isMonday() and !in_array($pinicio, $no_habiles)) {
                    array_push($fechas, $pinicio->toDateString());
                    $total_asistencias++;
                }
                //dd($fechas);
            }
            if (in_array('Martes', $dias)) {
                //dd("hay martes");
                if ($pinicio->isTuesday() and !in_array($pinicio, $no_habiles)) {
                    array_push($fechas, $pinicio->toDateString());
                    $total_asistencias++;
                }
            }
            if (in_array('Miercoles', $dias)) {
                //dd("hay miercoles");
                if ($pinicio->isWednesday() and !in_array($pinicio, $no_habiles)) {
                    array_push($fechas, $pinicio->toDateString());
                    $total_asistencias++;
                }
            }
            if (in_array('Jueves', $dias)) {
                //dd("hay jueves");
                if ($pinicio->isThursday() and !in_array($pinicio, $no_habiles)) {
                    array_push($fechas, $pinicio->toDateString());
                    $total_asistencias++;
                }
            }
            if (in_array('Viernes', $dias)) {
                //dd("hay viernes");
                if ($pinicio->isFriday() and !in_array($pinicio, $no_habiles)) {
                    array_push($fechas, $pinicio->toDateString());
                    $total_asistencias++;
                }
            }
            if (in_array('Sabado', $dias)) {

                if ($pinicio->isSaturday() and !in_array($pinicio, $no_habiles)) {
                    array_push($fechas, $pinicio->toDateString());
                    $total_asistencias++;
                }
            }
            $pinicio->addDay();
            //dd($fechas);
        }

        $contador = 0;
        foreach ($fechas as $fecha) {
            $contador++;
        }

        $impresion = array();
        $impresion['asignacion_id'] = $asignacion->id;
        $impresion['inscritos'] = $total_alumnos;
        $impresion['fecha_f'] = $asignacion->fec_inicio;
        $impresion['fecha_t'] = $asignacion->fec_fin;
        $impresion['token'] = uniqid(base64_encode(str_random(6)));
        $impresion['usu_alta_id'] = Auth::user()->id;
        $impresion['usu_mod_id'] = Auth::user()->id;
        ImpresionListaAsisten::create($impresion);

        //dd($fechas);
        //dd($registros->grupo);

        /*return view('inscripcions.reportes.lista_alumnosr',compact('registros'))
        ->with( 'list', Inscripcion::getListFromAllRelationApps() );
         * */

        /*                PDF::setOptions(['defaultFont' => 'arial']);

        $pdf = PDF::loadView('inscripcions.reportes.lista_alumnosr', array('registros'=>$registros,'fechas_enc'=>$fechas))
        ->setPaper('legal', 'landscape');
        return $pdf->download('reporte.pdf');
         */

        return view('inscripcions.reportes.lista_alumnosr', array(
            'registros' => $registros,
            'fechas_enc' => $fechas,
            'asignacion' => $asignacion,
            'total_asistencias' => $total_asistencias,
            'contador' => $contador,
            'total_alumnos' => $total_alumnos,
            'data' => $data,
            'token' => $impresion['token'],
        ));
    }

    public function listaCalificaciones(Request $request)
    {
        $datos = $request->all();
        $asignacion = AsignacionAcademica::find($datos['asignacion']);
        $materias = Materium::pluck('name', 'id');
        $instructores = Empleado::where('puesto_id', 3)->pluck('nombre', 'id');
        return view('inscripcions.reportes.lista_calificaciones', compact('materias', 'instructores', 'asignacion'))
            ->with('list', Inscripcion::getListFromAllRelationApps());
    }

    public function listarCalificaciones(Request $request)
    {
        $data = $request->all();
        //dd($data);

        $registros = Hacademica::select(
            'c.id as cliente_id',
            'c.nombre',
            'c.nombre2',
            'c.ape_paterno',
            'c.ape_materno',
            'g.name as grupo',
            'l.name as lectivo',
            DB::raw('concat(e.nombre," ",e.ape_paterno," ",e.ape_materno) as maestro'),
            'gra.name as grado',
            'gra.denominacion',
            'p.razon as plantel',
            'esp.imagen as logo',
            'aa.id as asignacion',
            'c.id as cliente',
            'mate.name as materia',
            'mate.ponderacion_id as ponderacion',
            'hacademicas.id as hacademica',
            'p.id as p_id',
            'c.matricula',
            'hacademicas.plantel_id',
            'hacademicas.lectivo_id',
            'hacademicas.grupo_id',
            'hacademicas.grado_id',
            'p.id as plantel_id'
        )
            ->join('inscripcions as i', 'i.id', '=', 'hacademicas.inscripcion_id')
            ->join('clientes as c', 'c.id', '=', 'hacademicas.cliente_id')
            //->join('hacademicas as h','h.inscripcion_id','=','inscripcions.id')
            ->join('seguimientos as s', 's.cliente_id', '=', 'c.id')
            ->join('grupos as g', 'g.id', '=', 'hacademicas.grupo_id')
            ->join('lectivos as l', 'l.id', '=', 'hacademicas.lectivo_id')
            ->join('asignacion_academicas as aa', 'hacademicas.grupo_id', '=', 'g.id')
            ->join('materia as mate', 'mate.id', '=', 'hacademicas.materium_id')
            ->join('empleados as e', 'e.id', '=', 'aa.empleado_id')
            ->join('grados as gra', 'gra.id', '=', 'hacademicas.grado_id')
            ->join('plantels as p', 'p.id', '=', 'c.plantel_id')
            ->join('especialidads as esp', 'esp.id', '=', 'hacademicas.especialidad_id')
            ->where('aa.id', $data['asignacion'])
            ->where('hacademicas.plantel_id', $data['plantel_f'])
            ->where('hacademicas.lectivo_id', $data['lectivo_f'])
            ->where('hacademicas.grupo_id', $data['grupo_f'])
            ->where('hacademicas.materium_id', $data['materia_f'])
            ->where('aa.plantel_id', $data['plantel_f'])
            ->where('aa.lectivo_id', $data['lectivo_f'])
            ->where('aa.grupo_id', $data['grupo_f'])
            ->where('aa.empleado_id', $data['instructor_f'])
            ->where('aa.materium_id', $data['materia_f'])
            ->whereIn('s.st_seguimiento_id', array(2, 5, 7))
            ->whereIn('c.st_cliente_id', array(4, 25, 20))
            ->whereNull('hacademicas.deleted_at')
            ->whereNull('aa.deleted_at')
            ->whereNull('i.deleted_at')
            //->where('inscripcions.grado_id',$data['grado_f'])
            ->orderBy('hacademicas.plantel_id')
            ->orderBy('hacademicas.lectivo_id')
            ->orderBy('hacademicas.grupo_id')
            //->orderBy('hacademicas.grado_id')
            ->orderBy('c.ape_paterno')
            ->orderBy('c.ape_materno')

            ->distinct()
            ->get();
        //Agregar fechas
        //dd($registros->toArray());
        $carga_ponderacion = collect();
        $asignacion = AsignacionAcademica::find($data['asignacion']);
        //                $asignacion=collect();
        foreach ($registros as $registro) {
            //$carga_ponderacion = CargaPonderacion::where('ponderacion_id', $registro->ponderacion)->get();
            $hacademica = Hacademica::find($registro->hacademica);
            //Log::info("hacademicas-" . $hacademica->id);
            $calificacion_ordinaria = Calificacion::where('hacademica_id', $hacademica->id)
                ->where('tpo_examen_id', 1)
                ->first();

            foreach ($calificacion_ordinaria->calificacionPonderacions as $calificacionPonderacion) {
                $carga_ponderacion->push($calificacionPonderacion->cargaPonderacion);
            }
            //dd($carga_ponderacion);
            break;
        }
        //dd($asignacion);
        $contador = 0;
        foreach ($carga_ponderacion as $carga) {
            $contador++;
        }

        //dd($carga_ponderacion->toArray());
        /*
        PDF::setOptions(['defaultFont' => 'arial']);

        $pdf = PDF::loadView('inscripcions.reportes.lista_calificacionesr', array('registros'=>$registros,'carga_ponderacions_enc'=>$carga_ponderacion))
        ->setPaper('legal', 'landscape');
        return $pdf->download('reporte.pdf');
         */
        $total_alumnos = 0;
        foreach ($registros as $registro) {
            $total_alumnos++;
        }
        return view('inscripcions.reportes.lista_calificacionesr', array(
            'registros' => $registros,
            'carga_ponderacions_enc' => $carga_ponderacion,
            'asignacion' => $asignacion,
            'contador' => $contador,
            'data' => $data,
            'total_alumnos' => $total_alumnos,
        ));
    }

    public function boletas()
    {
        $materias = Materium::pluck('name', 'id');
        $instructores = Empleado::where('puesto_id', 3)->pluck('nombre', 'id');
        return view('inscripcions.reportes.boletas', compact('materias', 'instructores'))
            ->with('list', Inscripcion::getListFromAllRelationApps());
    }

    public function boletasr(Request $request)
    {
        $data = $request->all();
        //dd($data);
        $registros = Inscripcion::select(
            'c.nombre',
            'c.nombre2',
            'c.ape_paterno',
            'c.ape_materno',
            'g.name as grupo',
            'l.name as lectivo',
            DB::raw('concat(e.nombre," ",e.ape_paterno," ",e.ape_materno) as maestro'),
            'gra.name as grado',
            'p.razon as plantel',
            'p.logo',
            'aa.id as asignacion',
            'c.id as cliente',
            'mate.name as materia',
            'mate.ponderacion_id as ponderacion',
            'h.id as hacademica',
            'p.id as p_id',
            'c.matricula'
        )
            ->join('clientes as c', 'c.id', '=', 'inscripcions.cliente_id')
            ->join('grupos as g', 'g.id', '=', 'inscripcions.grupo_id')
            ->join('lectivos as l', 'l.id', '=', 'inscripcions.lectivo_id')
            ->join('asignacion_academicas as aa', 'aa.grupo_id', '=', 'g.id')
            ->join('materia as mate', 'mate.id', '=', 'aa.materium_id')
            ->join('empleados as e', 'e.id', '=', 'aa.empleado_id')
            ->join('grados as gra', 'gra.id', '=', 'inscripcions.grado_id')
            ->join('plantels as p', 'p.id', '=', 'c.plantel_id')
            ->join('hacademicas as h', 'h.inscripcion_id', '=', 'inscripcions.id')
            ->where('inscripcions.plantel_id', $data['plantel_f'])
            ->where('inscripcions.lectivo_id', $data['lectivo_f'])
            ->where('aa.plantel_id', $data['plantel_f'])
            ->where('aa.lectivo_id', $data['lectivo_f'])
            ->where('aa.grupo_id', $data['grupo_f'])
            ->where('aa.empleado_id', $data['instructor_f'])
            //->where('inscripcions.grado_id',$data['grado_f'])
            ->orderBy('inscripcions.plantel_id')
            ->orderBy('inscripcions.lectivo_id')
            ->orderBy('inscripcions.grupo_id')
            ->orderBy('inscripcions.grado_id')
            ->orderBy('inscripcions.cliente_id')
            ->get();
        //Agregar fechas
        //dd($registros->toArray());
        $carga_ponderacion = collect();
        $asignacion = collect();
        foreach ($registros as $registro) {
            $carga_ponderacion = CargaPonderacion::where('ponderacion_id', $registro->ponderacion)->get();
            $asignacion = AsignacionAcademica::find($registro->asignacion);
            break;
        }

        $contador = 0;
        foreach ($carga_ponderacion as $carga) {
            $contador++;
        }

        //dd($carga_ponderacion->toArray());
        /*
        PDF::setOptions(['defaultFont' => 'arial']);

        $pdf = PDF::loadView('inscripcions.reportes.lista_calificacionesr', array('registros'=>$registros,'carga_ponderacions_enc'=>$carga_ponderacion))
        ->setPaper('legal', 'landscape');
        return $pdf->download('reporte.pdf');
         */
        return view('inscripcions.reportes.boletasr', array(
            'registros' => $registros,
            'carga_ponderacions_enc' => $carga_ponderacion,
            'asignacion' => $asignacion,
            'contador' => $contador,
            'data' => $data,
        ));
    }

    public function InscritosUnPago()
    {

        return view('inscripcions.reportes.inscritosUnPago')
            ->with('list', Inscripcion::getListFromAllRelationApps());
    }

    public function InscritosUnPagoR(Request $request)
    {
        $data = $request->all();
        $plantel = Plantel::find($data['plantel_f']);
        //dd($data);
        $registros = Inscripcion::select('c.id', DB::raw('concat(e.nombre, " ",e.ape_paterno, " ",e.ape_materno) as colaborador, '
            . 'concat(c.nombre," ",c.nombre2," ",c.ape_paterno," ",c.ape_materno) as cliente, caj.id as caja, p.fecha, m.name as medio, '
            . 'c.beca_bnd, esp.name as especialidad'))
            ->join('clientes as c', 'c.id', '=', 'inscripcions.cliente_id')
            ->join('medios as m', 'm.id', '=', 'c.medio_id')
            ->join('especialidads as esp', 'esp.id', '=', 'inscripcions.especialidad_id')
            ->join('empleados as e', 'e.id', '=', 'c.empleado_id')
            ->join('cajas as caj', 'caj.cliente_id', '=', 'c.id')
            ->join('caja_lns as clns', 'clns.caja_id', '=', 'caj.id')
            ->join('caja_conceptos as cc', 'cc.id', '=', 'clns.caja_concepto_id')
            ->join('pagos as p', 'p.caja_id', '=', 'caj.id')
            ->where('inscripcions.plantel_id', '>=', $data['plantel_f'])
            ->where('inscripcions.plantel_id', '<=', $data['plantel_t'])
            ->where('p.fecha', '>=', $data['fecha_f'])
            ->where('p.fecha', '<=', $data['fecha_t'])
            //->where('c.empleado_id', $data['empleado_f'])
            ->whereIn('caj.st_caja_id', [1, 3])
            ->where(function ($query) {
                $query->orWhere('cc.name', 'LIKE', 'INSCRIP%')
                    ->orWhere('cc.name', 'LIKE', 'SEGUR%')
                    ->orWhere('cc.name', 'LIKE', 'UNIFORM%');
            })
            ->orderBy('colaborador')
            ->distinct()
            ->get();
        //dd($registros->toArray());

        /*
        PDF::setOptions(['defaultFont' => 'arial']);

        $pdf = PDF::loadView('inscripcions.reportes.lista_calificacionesr', array('registros'=>$registros,'carga_ponderacions_enc'=>$carga_ponderacion))
        ->setPaper('legal', 'landscape');
        return $pdf->download('reporte.pdf');
         */
        return view('inscripcions.reportes.inscritosUnPagoR', array(
            'registros' => $registros,
            'plantel' => $plantel,
            'data' => $data,
        ));
    }

    public function InscritosLectivo()
    {

        return view('inscripcions.reportes.inscritosLectivo')
            ->with('list', Inscripcion::getListFromAllRelationApps());
    }

    public function InscritosLectivoR(Request $request)
    {
        $data = $request->all();
        //dd($data);
        $plantel = Plantel::find($data['plantel_f']);
        //dd($data);
        //$lectivo = Lectivo::find($data['lectivo_f']);
        /*
        $registros = Inscripcion::select('c.id', DB::raw('concat(e.nombre, " ",e.ape_paterno, " ",e.ape_materno) as instructor, '
        . 'concat(c.nombre," ",c.nombre2," ",c.ape_paterno," ",c.ape_materno) as cliente,'
        . 'c.beca_bnd, esp.name as especialidad, inscripcions.fec_inscripcion, aa.id as asignacion,'
        . 'gru.name as grupo, gru.id as gru, mat.name as materi, stc.name as estatus_cliente'))
        ->join('clientes as c', 'c.id', '=', 'inscripcions.cliente_id')
        ->join('st_clientes as stc', 'stc.id', '=', 'c.st_cliente_id')
        ->join('medios as m', 'm.id', '=', 'c.medio_id')
        ->join('especialidads as esp', 'esp.id', '=', 'inscripcions.especialidad_id')
        ->join('grupos as gru', 'gru.id', '=', 'inscripcions.grupo_id')
        ->join('hacademicas as h', 'h.inscripcion_id', '=', 'inscripcions.id')
        ->join('materia as mat', 'mat.id', '=', 'h.materium_id')
        ->join('asignacion_academicas as aa', 'aa.materium_id', '=', 'h.materium_id')
        ->whereColumn('aa.grupo_id', 'h.grupo_id')
        ->whereColumn('aa.plantel_id', 'inscripcions.plantel_id')
        ->whereColumn('aa.lectivo_id', 'inscripcions.lectivo_id')
        ->join('empleados as e', 'e.id', '=', 'aa.empleado_id')
        ->where('inscripcions.plantel_id', $data['plantel_f'])
        ->where('inscripcions.lectivo_id', $data['lectivo_f'])
        ->where('h.lectivo_id', $data['lectivo_f'])
        ->whereNull('inscripcions.deleted_at')
        ->whereNull('h.deleted_at')
        ->whereNull('aa.deleted_at')
        ->orderBy('aa.id', 'esp.name', 'gru.id')
        ->distinct()
        ->get();
         */
        try {
            $registros = Hacademica::select('c.id', DB::raw('concat(e.nombre, " ",e.ape_paterno, " ",e.ape_materno) as instructor, '
                . 'concat(c.nombre," ",c.nombre2," ",c.ape_paterno," ",c.ape_materno) as cliente,'
                . 'c.beca_bnd, esp.name as especialidad, i.fec_inscripcion, aa.id as asignacion,'
                . 'gru.name as grupo, gru.id as gru, mat.name as materi, stc.id as estatus_cliente_id,  stc.name as estatus_cliente, l.name as lectivo'))
                ->join('clientes as c', 'c.id', '=', 'hacademicas.cliente_id')
                ->join('st_clientes as stc', 'stc.id', '=', 'c.st_cliente_id')
                ->join('medios as m', 'm.id', '=', 'c.medio_id')
                ->join('especialidads as esp', 'esp.id', '=', 'hacademicas.especialidad_id')
                ->join('grupos as gru', 'gru.id', '=', 'hacademicas.grupo_id')
                ->join('inscripcions as i', 'i.id', '=', 'hacademicas.inscripcion_id')
                ->join('lectivos as l', 'l.id', '=', 'hacademicas.lectivo_id')
                ->join('materia as mat', 'mat.id', '=', 'hacademicas.materium_id')
                ->join('asignacion_academicas as aa', 'aa.materium_id', '=', 'hacademicas.materium_id')
                ->whereColumn('aa.grupo_id', 'hacademicas.grupo_id')
                ->whereColumn('aa.plantel_id', 'hacademicas.plantel_id')
                ->whereColumn('aa.lectivo_id', 'hacademicas.lectivo_id')
                ->join('empleados as e', 'e.id', '=', 'aa.empleado_id')
                ->where('hacademicas.plantel_id', $data['plantel_f'])
                ->whereIn('hacademicas.lectivo_id', $data['lectivo_f'])
                ->whereNull('hacademicas.deleted_at')
                ->whereNull('i.deleted_at')
                ->whereNull('hacademicas.deleted_at')
                ->whereNull('aa.deleted_at')
                ->orderBy('aa.id', 'asc')
                ->orderBy('esp.name', 'asc')
                ->orderBy('gru.id', 'asc')
                ->distinct()
                ->get();
        } catch (Exception $e) {
            dd($e);
        }

        //dd($registros->toArray());

        /*
        PDF::setOptions(['defaultFont' => 'arial']);

        $pdf = PDF::loadView('inscripcions.reportes.lista_calificacionesr', array('registros'=>$registros,'carga_ponderacions_enc'=>$carga_ponderacion))
        ->setPaper('legal', 'landscape');
        return $pdf->download('reporte.pdf');
         */
        $estatus_revisados = array();
        $i = 1;
        foreach ($registros as $registro) {
            //dd($registro);
            if (!array_has($estatus_revisados, $registro->estatus_cliente_id)) {
                $estatus_revisados[$registro->estatus_cliente_id] = $registro->estatus_cliente;
                //array_push($estatus, array($registro->estatus_cliente, 0));
            }
        }

        return view('inscripcions.reportes.inscritosLectivoR', array(
            'registros' => $registros,
            'plantel' => $plantel,
            'estatus_revisados' => $estatus_revisados,
        ));
    }

    public function InscritosLectivosCalif()
    {

        return view('inscripcions.reportes.inscritosLectivosCalif')
            ->with('list', Inscripcion::getListFromAllRelationApps());
    }

    public function InscritosLectivosCalifR(Request $request)
    {
        $data = $request->all();
        $plantel = Plantel::find($data['plantel_f']);
        //dd($data);
        $lectivo = Lectivo::find($data['lectivo_f']);
        /*$registros = Inscripcion::select('c.id', DB::raw('concat(e.nombre, " ",e.ape_paterno, " ",e.ape_materno) as instructor, '
        . 'concat(c.nombre," ",c.nombre2," ",c.ape_paterno," ",c.ape_materno) as cliente,'
        . 'c.beca_bnd, esp.name as especialidad, inscripcions.fec_inscripcion, aa.id as asignacion,'
        . 'gru.name as grupo, gru.id as gru, mat.name as materi, stc.name as estatus_cliente, h.id as hacademica'))
        ->join('clientes as c', 'c.id', '=', 'inscripcions.cliente_id')
        ->join('st_clientes as stc', 'stc.id', '=', 'c.st_cliente_id')
        ->join('medios as m', 'm.id', '=', 'c.medio_id')
        ->join('especialidads as esp', 'esp.id', '=', 'inscripcions.especialidad_id')
        ->join('grupos as gru', 'gru.id', '=', 'inscripcions.grupo_id')
        ->join('hacademicas as h', 'h.inscripcion_id', '=', 'inscripcions.id')
        ->join('materia as mat', 'mat.id', '=', 'h.materium_id')
        ->join('asignacion_academicas as aa', 'aa.materium_id', '=', 'hacademicas.materium_id')
        ->whereColumn('aa.grupo_id', 'h.grupo_id')
        ->whereColumn('aa.plantel_id', 'inscripcions.plantel_id')
        ->whereColumn('aa.lectivo_id', 'inscripcions.lectivo_id')
        ->join('empleados as e', 'e.id', '=', 'aa.empleado_id')
        ->where('inscripcions.plantel_id', $data['plantel_f'])
        ->where('inscripcions.lectivo_id', $data['lectivo_f'])
        ->where('h.lectivo_id', $data['lectivo_f'])
        ->whereNull('inscripcions.deleted_at')
        ->whereNull('h.deleted_at')
        ->whereNull('aa.deleted_at')
        ->orderBy('aa.id', 'esp.name', 'gru.id')
        ->distinct()
        ->get();
         */
        $registros = Hacademica::select('c.id', DB::raw('concat(e.nombre, " ",e.ape_paterno, " ",e.ape_materno) as instructor, '
            . 'concat(c.nombre," ",c.nombre2," ",c.ape_paterno," ",c.ape_materno) as cliente,'
            . 'c.beca_bnd, esp.name as especialidad, i.fec_inscripcion, aa.id as asignacion,'
            . 'gru.name as grupo, gru.id as gru, mat.name as materi, stc.name as estatus_cliente, hacademicas.id as hacademica'))
            ->join('clientes as c', 'c.id', '=', 'hacademicas.cliente_id')
            ->join('st_clientes as stc', 'stc.id', '=', 'c.st_cliente_id')
            ->join('medios as m', 'm.id', '=', 'c.medio_id')
            ->join('especialidads as esp', 'esp.id', '=', 'hacademicas.especialidad_id')
            ->join('grupos as gru', 'gru.id', '=', 'hacademicas.grupo_id')
            ->join('inscripcions as i', 'i.id', '=', 'hacademicas.inscripcion_id')
            ->join('materia as mat', 'mat.id', '=', 'hacademicas.materium_id')
            ->join('asignacion_academicas as aa', 'aa.materium_id', '=', 'hacademicas.materium_id')
            ->whereColumn('aa.grupo_id', 'hacademicas.grupo_id')
            ->whereColumn('aa.plantel_id', 'hacademicas.plantel_id')
            ->whereColumn('aa.lectivo_id', 'hacademicas.lectivo_id')
            ->join('empleados as e', 'e.id', '=', 'aa.empleado_id')
            ->where('hacademicas.plantel_id', $data['plantel_f'])
            ->where('hacademicas.lectivo_id', $data['lectivo_f'])
            ->where('hacademicas.lectivo_id', $data['lectivo_f'])
            ->whereNull('hacademicas.deleted_at')
            ->whereNull('i.deleted_at')
            ->whereNull('aa.deleted_at')
            ->orderBy('aa.id', 'asc')
            ->orderBy('esp.name', 'asc')
            ->orderBy('gru.id', 'asc')
            ->distinct()
            ->get();
        //dd($registros->toArray());

        /*
        PDF::setOptions(['defaultFont' => 'arial']);

        $pdf = PDF::loadView('inscripcions.reportes.lista_calificacionesr', array('registros'=>$registros,'carga_ponderacions_enc'=>$carga_ponderacion))
        ->setPaper('legal', 'landscape');
        return $pdf->download('reporte.pdf');
         */
        return view('inscripcions.reportes.inscritosLectivosCalifR', array(
            'registros' => $registros,
            'plantel' => $plantel,
            'lectivo' => $lectivo,
        ));
    }

    public function InscritosLectivosAsistencias()
    {

        return view('inscripcions.reportes.inscritosLectivosAsistencias')
            ->with('list', Inscripcion::getListFromAllRelationApps());
    }

    public function InscritosLectivosAsistenciasR(Request $request)
    {
        $data = $request->all();
        $plantel = Plantel::find($data['plantel_f']);
        //dd($data);
        $lectivo = Lectivo::find($data['lectivo_f']);
        $registros = Hacademica::select('c.id', DB::raw('concat(e.nombre, " ",e.ape_paterno, " ",e.ape_materno) as instructor, '
            . 'concat(c.nombre," ",c.nombre2," ",c.ape_paterno," ",c.ape_materno) as cliente,'
            . 'c.beca_bnd, esp.name as especialidad, i.fec_inscripcion, aa.id as asignacion,'
            . 'gru.name as grupo, gru.id as gru, mat.name as materi, stc.name as estatus_cliente, c.id as cliente_id'))
            ->join('clientes as c', 'c.id', '=', 'hacademicas.cliente_id')
            ->join('st_clientes as stc', 'stc.id', '=', 'c.st_cliente_id')
            ->join('medios as m', 'm.id', '=', 'c.medio_id')
            ->join('especialidads as esp', 'esp.id', '=', 'hacademicas.especialidad_id')
            ->join('grupos as gru', 'gru.id', '=', 'hacademicas.grupo_id')
            ->join('inscripcions as i', 'i.id', '=', 'hacademicas.inscripcion_id')
            ->join('materia as mat', 'mat.id', '=', 'hacademicas.materium_id')
            ->join('asignacion_academicas as aa', 'aa.materium_id', '=', 'hacademicas.materium_id')
            ->whereColumn('aa.grupo_id', 'hacademicas.grupo_id')
            ->whereColumn('aa.plantel_id', 'hacademicas.plantel_id')
            ->whereColumn('aa.lectivo_id', 'hacademicas.lectivo_id')
            ->join('empleados as e', 'e.id', '=', 'aa.empleado_id')
            ->where('hacademicas.plantel_id', $data['plantel_f'])
            ->where('hacademicas.lectivo_id', $data['lectivo_f'])
            ->where('hacademicas.lectivo_id', $data['lectivo_f'])
            ->whereNull('hacademicas.deleted_at')
            ->whereNull('i.deleted_at')
            ->whereNull('aa.deleted_at')
            ->orderBy('aa.id', 'asc')
            ->orderBy('esp.name', 'asc')
            ->orderBy('gru.id', 'asc')
            ->distinct()
            ->get();
        //dd($registros->toArray());

        /*
        PDF::setOptions(['defaultFont' => 'arial']);

        $pdf = PDF::loadView('inscripcions.reportes.lista_calificacionesr', array('registros'=>$registros,'carga_ponderacions_enc'=>$carga_ponderacion))
        ->setPaper('legal', 'landscape');
        return $pdf->download('reporte.pdf');
         */
        return view('inscripcions.reportes.inscritosLectivosAsistenciasR', array(
            'registros' => $registros,
            'plantel' => $plantel,
            'lectivo' => $lectivo,
            'data' => $data,
        ));
    }

    public function listaMes(Request $request)
    {
        $datos = $request->all();
        $asignacion = AsignacionAcademica::find($datos['asignacion']);
        $meses = Mese::pluck('name', 'id');
        $pinicio = Carbon::createFromFormat('Y-m-d', $asignacion->fec_inicio);
        $pfin = Carbon::createFromFormat('Y-m-d', $asignacion->fec_fin);
        //dd($meses);
        /*$i=1;
        foreach($meses as $mes){
        //dd($meses[$i]);
        if($i>=$pinicio->month and $i<=$pfin->month){

        }else{
        $meses->forget($i);
        }
        $i++;
        }*/
        //dd($meses);

        $materias = Materium::pluck('name', 'id');
        $instructores = Empleado::where('puesto_id', 3)->pluck('nombre', 'id');
        return view('inscripcions.reportes.lista_mes', compact('meses', 'materias', 'instructores', 'asignacion'))
            ->with('list', Inscripcion::getListFromAllRelationApps());
    }

    public function listaMesR(Request $request)
    {
        $data = $request->all();

        $registros = Hacademica::select(
            'hacademicas.grupo_id',
            'hacademicas.grado_id',
            'hacademicas.lectivo_id',
            'hacademicas.plantel_id',
            'c.nombre',
            'c.nombre2',
            'c.ape_paterno',
            'c.ape_materno',
            'g.name as grupo',
            'l.name as lectivo',
            'mat.name as materia',
            DB::raw('concat(e.nombre," ",e.ape_paterno," ",e.ape_materno) as maestro'),
            'gra.name as grado',
            'p.razon as plantel',
            'esp.imagen as logo',
            'aa.id as asignacion',
            'c.id as cliente',
            'p.id as p_id',
            'c.tel_fijo'
        )
            ->join('inscripcions as i', 'i.id', '=', 'hacademicas.inscripcion_id')
            ->join('materia as mat', 'mat.id', '=', 'hacademicas.materium_id')
            ->join('clientes as c', 'c.id', '=', 'hacademicas.cliente_id')
            ->join('grupos as g', 'g.id', '=', 'hacademicas.grupo_id')
            ->join('lectivos as l', 'l.id', '=', 'hacademicas.lectivo_id')
            ->join('asignacion_academicas as aa', 'aa.grupo_id', '=', 'g.id')
            ->join('especialidads as esp', 'esp.id', '=', 'hacademicas.especialidad_id')
            //->join('asistencia_rs as asis', 'asis.asignacion_academica_id','=','aa.id')
            ->join('empleados as e', 'e.id', '=', 'aa.empleado_id')
            ->join('grados as gra', 'gra.id', '=', 'hacademicas.grado_id')
            ->join('plantels as p', 'p.id', '=', 'c.plantel_id')
            ->where('c.st_cliente_id', '<>', 3)
            ->where('c.st_cliente_id', '<>', 1)
            ->where('aa.id', $data['asignacion'])
            ->where('hacademicas.plantel_id', $data['plantel_f'])
            ->where('hacademicas.lectivo_id', $data['lectivo_f'])
            ->where('hacademicas.grupo_id', $data['grupo_f'])
            //->where('inscripcions.grado_id',$data['grado_f'])
            ->where('aa.plantel_id', $data['plantel_f'])
            ->where('aa.lectivo_id', $data['lectivo_f'])
            ->where('aa.grupo_id', $data['grupo_f'])
            ->where('aa.empleado_id', $data['instructor_f'])
            ->where('aa.materium_id', $data['materia_f'])
            ->where('hacademicas.materium_id', $data['materia_f'])
            ->whereNull('hacademicas.deleted_at')
            ->whereNull('aa.deleted_at')
            ->whereNull('i.deleted_at')
            ->orderBy('hacademicas.plantel_id')
            ->orderBy('hacademicas.lectivo_id')
            ->orderBy('hacademicas.grupo_id')
            ->orderBy('hacademicas.grado_id')
            ->distinct()
            ->get();
        $total_alumnos = 0;
        foreach ($registros as $r) {
            $total_alumnos++;
        }
        //dd($registros->toArray());

        //Agregar fechas
        $asignacion = AsignacionAcademica::find($data['asignacion']);
        /*foreach($registros as $registro){
        $asignacion= AsignacionAcademica::find($registro->asignacion);
        break;
        }*/

        $dias = array();
        //dd($asignacion);
        foreach ($asignacion->horarios as $horario) {
            array_push($dias, $horario->dia->name);
        }
        //dd($dias);

        $fechas = array();
        $lectivo = Lectivo::find($data['lectivo_f']);
        //dd($lectivo);
        $no_habiles = array();
        $diasNoHabiles = DiaNoHabil::distinct()
            ->where('fecha', '>=', $lectivo->inicio)
            ->where('fecha', '<=', $lectivo->fin)
            ->get();
        foreach ($diasNoHabiles as $no_habil) {
            array_push($no_habiles, Carbon::createFromFormat('Y-m-d', $no_habil->fecha));
        }
        //dd($no_habiles);
        //$inicio=Carbon::createFromFormat('Y-m-d', $lectivo->inicio);
        //$fin=Carbon::createFromFormat('Y-m-d', $lectivo->fin);
        $pinicio = Carbon::createFromFormat('Y-m-d', $data['fecha_f']);
        $pfin = Carbon::createFromFormat('Y-m-d', $data['fecha_t']);
        //dd($pfin->toDateString());
        //array_push($fechas,$pinicio);
        //$fecha=Carbon::createFromFormat('Y-m-d', $lectivo->inicio);
        $total_asistencias = 0;
        while ($pfin->greaterThanOrEqualTo($pinicio)) {

            if (in_array('Lunes', $dias)) {
                //dd("hay lunes");
                if ($pinicio->isMonday() and !in_array($pinicio, $no_habiles)) {
                    array_push($fechas, $pinicio->toDateString());
                    $total_asistencias++;
                }
                //dd($fechas);
            }
            if (in_array('Martes', $dias)) {
                //dd("hay martes");
                if ($pinicio->isTuesday() and !in_array($pinicio, $no_habiles)) {
                    array_push($fechas, $pinicio->toDateString());
                    $total_asistencias++;
                }
            }
            if (in_array('Miercoles', $dias)) {
                //dd("hay miercoles");
                if ($pinicio->isWednesday() and !in_array($pinicio, $no_habiles)) {
                    array_push($fechas, $pinicio->toDateString());
                    $total_asistencias++;
                }
            }
            if (in_array('Jueves', $dias)) {
                //dd("hay jueves");
                if ($pinicio->isThursday() and !in_array($pinicio, $no_habiles)) {
                    array_push($fechas, $pinicio->toDateString());
                    $total_asistencias++;
                }
            }
            if (in_array('Viernes', $dias)) {
                //dd("hay viernes");
                if ($pinicio->isFriday() and !in_array($pinicio, $no_habiles)) {
                    array_push($fechas, $pinicio->toDateString());
                    $total_asistencias++;
                }
            }
            if (in_array('Sabado', $dias)) {

                //if ($pinicio->isSaturday()  and !in_array($pinicio, $no_habiles) and $pinicio->month == $data['mes']) {
                if ($pinicio->isSaturday() and !in_array($pinicio, $no_habiles)) {
                    array_push($fechas, $pinicio->toDateString());
                    $total_asistencias++;
                }
            }
            $pinicio->addDay();
            //dd($fechas);
        }

        $contador = 0;
        foreach ($fechas as $fecha) {
            $contador++;
        }

        $impresion = array();
        $impresion['asignacion_id'] = $asignacion->id;
        $impresion['inscritos'] = $total_alumnos;
        $impresion['fecha_f'] = $data['fecha_f'];
        $impresion['fecha_t'] = $data['fecha_t'];
        $impresion['token'] = uniqid(base64_encode(str_random(6)));
        $impresion['usu_alta_id'] = Auth::user()->id;
        $impresion['usu_mod_id'] = Auth::user()->id;
        ImpresionListaAsisten::create($impresion);

        //$mes = Mese::find($data['mes']);
        //dd($fechas);
        //dd($registros->grupo);

        /*return view('inscripcions.reportes.lista_alumnosr',compact('registros'))
        ->with( 'list', Inscripcion::getListFromAllRelationApps() );
         * */

        /*                PDF::setOptions(['defaultFont' => 'arial']);

        $pdf = PDF::loadView('inscripcions.reportes.lista_alumnosr', array('registros'=>$registros,'fechas_enc'=>$fechas))
        ->setPaper('legal', 'landscape');
        return $pdf->download('reporte.pdf');
         */
        return view('inscripcions.reportes.lista_mesr', array(
            'registros' => $registros,
            'fechas_enc' => $fechas,
            'asignacion' => $asignacion,
            'total_asistencias' => $total_asistencias,
            'contador' => $contador,
            'data' => $data,
            'total_alumnos' => $total_alumnos,
            'token' => $impresion['token'],
        ));
    }

    public function historial(Request $request)
    {
        $datos = $request->all();
        $inscripcion = Inscripcion::find($datos['inscripcion']);
        //dd($inscripcion);
        /*return view('inscripcions.reportes.lista_alumnosr',compact('registros'))
        ->with( 'list', Inscripcion::getListFromAllRelationApps() );
         * */

        /*                PDF::setOptions(['defaultFont' => 'arial']);

        $pdf = PDF::loadView('inscripcions.reportes.lista_alumnosr', array('registros'=>$registros,'fechas_enc'=>$fechas))
        ->setPaper('legal', 'landscape');
        return $pdf->download('reporte.pdf');
         */
        return view('inscripcions.reportes.historial', array('inscripcion' => $inscripcion));
    }

    public function sepICP08Boletas()
    {
        return view('inscripcions.reportes.sepICP08Boletas')
            ->with('list', Inscripcion::getListFromAllRelationApps());
    }

    public function sepICP08BoletasR(Request $request)
    {
        $data = $request->all();
        //dd($data);
        $plantel = Plantel::find($data['plantel_f']);
        $egresados = Cliente::select('clientes.id')
            ->join('inscripcions as i', 'i.cliente_id', '=', 'clientes.id')
            ->join('hacademicas as h', 'h.inscripcion_id', '=', 'i.id')
            ->join('materia as m', 'm.id', '=', 'h.materium_id')
            ->join('grados as g', 'g.id', '=', 'i.grado_id')
            ->whereColumn('g.modulo_final_id', 'm.modulo_id')
            ->where('h.lectivo_id', $data['lectivo_f'])
            ->where('i.plantel_id', $data['plantel_f'])
            ->where('i.especialidad_id', $data['especialidad_f'])
            ->where('i.nivel_id', $data['nivel_f'])
            ->where('g.id', $data['grado_f'])
            ->where('h.st_materium_id', 1)
            ->distinct()
            ->orderBy('i.created_at')
            ->get();
        //dd($egresados->toArray());
        $arreglo_egresados = array();
        foreach ($egresados as $egresado) {
            array_push($arreglo_egresados, $egresado->id);
        }
        //dd($arreglo_egresados);
        $registros = Inscripcion::select(
            'c.id as cliente_id',
            'c.nombre',
            'c.nombre2',
            'c.ape_paterno',
            'c.ape_materno',
            'l.name as lectivo',
            'gra.name as grado',
            'c.curp',
            'p.razon as plantel',
            'e.name as especialidad',
            'e.ccte',
            'p.logo',
            'c.id as cliente',
            'p.id as p_id',
            'c.matricula',
            'inscripcions.plantel_id',
            'inscripcions.lectivo_id',
            'inscripcions.grupo_id',
            'inscripcions.grado_id'
        )
            ->join('clientes as c', 'c.id', '=', 'inscripcions.cliente_id')
            ->join('seguimientos as s', 's.cliente_id', '=', 'c.id')
            ->join('grupos as g', 'g.id', '=', 'inscripcions.grupo_id')
            ->join('lectivos as l', 'l.id', '=', 'inscripcions.lectivo_id')
            ->join('grados as gra', 'gra.id', '=', 'inscripcions.grado_id')
            ->join('plantels as p', 'p.id', '=', 'c.plantel_id')
            ->join('especialidads as e', 'e.id', '=', 'inscripcions.especialidad_id')
            ->whereIn('c.id', $arreglo_egresados)
            ->whereNull('inscripcions.deleted_at')
            //->where('inscripcions.grado_id',$data['grado_f'])
            ->orderBy('inscripcions.plantel_id', 'asc')
            ->orderBy('inscripcions.lectivo_id', 'asc')
            ->orderBy('inscripcions.grupo_id', 'asc')
            ->orderBy('inscripcions.grado_id', 'asc')
            ->distinct()
            ->get();

        //Agregar fechas
        //dd($registros->toArray());

        $asignacion = collect();
        foreach ($registros as $registro) {

            $asignacion = AsignacionAcademica::find($registro->asignacion);
            break;
        }

        //dd($carga_ponderacion->toArray());
        /*
        PDF::setOptions(['defaultFont' => 'arial']);

        $pdf = PDF::loadView('inscripcions.reportes.lista_calificacionesr', array('registros'=>$registros,'carga_ponderacions_enc'=>$carga_ponderacion))
        ->setPaper('legal', 'landscape');
        return $pdf->download('reporte.pdf');
         */
        return view('inscripcions.reportes.sepICP08BoletasR', array(
            'registros' => $registros,
            'asignacion' => $asignacion,
            'plantel' => $plantel,
            'data' => $data,
        ));
    }

    public function sepEstadistico()
    {
        return view('inscripcions.reportes.sepEstadistico')
            ->with('list', Inscripcion::getListFromAllRelationApps());
    }

    public function sepEstadisticoR(Request $request)
    {
        $data = $request->all();
        //            dd($data);
        $plantel = Plantel::find($data['plantel_f']);
        $especialidad = Especialidad::find($data['especialidad_f']);
        $grado = Grado::find($data['grado_f']);
        $egresados = Cliente::select('clientes.id', 'g.nombre2 as grado', 'e.ccte')
            ->join('inscripcions as i', 'i.cliente_id', '=', 'clientes.id')
            ->join('hacademicas as h', 'h.inscripcion_id', '=', 'i.id')
            ->join('materia as m', 'm.id', '=', 'h.materium_id')
            ->join('grados as g', 'g.id', '=', 'i.grado_id')
            ->join('especialidads as e', 'e.id', '=', 'i.especialidad_id')
            ->whereColumn('g.modulo_final_id', 'm.modulo_id')
            ->where('h.lectivo_id', $data['lectivo_f'])
            ->where('i.plantel_id', $data['plantel_f'])
            ->where('i.especialidad_id', $data['especialidad_f'])
            ->where('i.nivel_id', $data['nivel_f'])
            ->where('g.id', $data['grado_f'])
            ->where('h.st_materium_id', 1)
            ->distinct()
            ->orderBy('i.created_at')
            ->get();
        //dd($egresados->toArray());
        $arreglo_egresados = array();
        foreach ($egresados as $egresado) {
            array_push($arreglo_egresados, $egresado->id);
        }
        $registros = Inscripcion::select(
            'inscripcions.plantel_id',
            'inscripcions.lectivo_id',
            'inscripcions.grupo_id',
            'inscripcions.grado_id',
            'c.id as cliente',
            'g.nombre2 as grado',
            'c.nombre',
            'c.nombre2',
            'c.ape_paterno',
            'c.ape_materno',
            'inscripcions.control',
            'c.fec_nacimiento',
            'c.genero',
            'c.escolaridad_id'
        )
            ->join('clientes as c', 'c.id', '=', 'inscripcions.cliente_id')
            ->join('grados as g', 'g.id', '=', 'inscripcions.grado_id')
            ->whereIn('c.id', $arreglo_egresados)
            ->whereNull('inscripcions.deleted_at')
            //->where('inscripcions.grado_id',$data['grado_f'])
            ->orderBy('inscripcions.plantel_id', 'asc')
            ->orderBy('inscripcions.lectivo_id', 'asc')
            ->orderBy('inscripcions.grupo_id', 'asc')
            ->orderBy('inscripcions.grado_id', 'asc')
            ->distinct()
            ->get();

        //Agregar fechas
        //dd($registros->toArray());

        //dd($carga_ponderacion->toArray());
        /*
        PDF::setOptions(['defaultFont' => 'arial']);

        $pdf = PDF::loadView('inscripcions.reportes.lista_calificacionesr', array('registros'=>$registros,'carga_ponderacions_enc'=>$carga_ponderacion))
        ->setPaper('legal', 'landscape');
        return $pdf->download('reporte.pdf');
         */
        return view('inscripcions.reportes.sepEstadisticoR', array(
            'registros' => $registros,
            'plantel' => $plantel,
            'data' => $data,
            'especialidad' => $especialidad,
            'grado' => $grado,
        ));
    }

    public function porcentajeAsistencia()
    {

        return view('inscripcions.reportes.porcentajeAsistencia')
            ->with('list', Inscripcion::getListFromAllRelationApps());
    }

    public function porcentajeAsistenciaR(Request $request)
    {
        $data = $request->all();

        $asignaciones = AsignacionAcademica::whereIn('plantel_id', $data['plantel_f'])
            ->where('lectivo_id', $data['lectivo_f'])
            //->where('id',1037)
            ->orderBy('plantel_id')
            ->orderBy('lectivo_id')
            ->orderBy('materium_id')
            ->get();
        $contador_clientes = 0;
        $sumatoria_promedio_clientes = 0;
        $resumen = array();
        //dd($asignaciones->toArray());
        foreach ($asignaciones as $asignacion) {
            $contador_clientes_asignacion = 0;
            $sumatoria_promedio_clientes_asignacion = 0;
            $registros = Hacademica::select(
                'hacademicas.grupo_id',
                'hacademicas.grado_id',
                'hacademicas.lectivo_id',
                'hacademicas.plantel_id',
                'c.nombre',
                'c.nombre2',
                'c.ape_paterno',
                'c.ape_materno',
                'g.name as grupo',
                'l.name as lectivo',
                'mat.name as materia',
                DB::raw('concat(e.nombre," ",e.ape_paterno," ",e.ape_materno) as maestro'),
                'gra.name as grado',
                'p.razon as plantel',
                'p.logo',
                'aa.id as asignacion',
                'c.id as cliente',
                'p.id as p_id',
                'c.tel_fijo'
            )
                ->join('inscripcions as i', 'i.id', '=', 'hacademicas.inscripcion_id')
                ->join('materia as mat', 'mat.id', '=', 'hacademicas.materium_id')
                ->join('clientes as c', 'c.id', '=', 'hacademicas.cliente_id')
                ->join('grupos as g', 'g.id', '=', 'hacademicas.grupo_id')
                ->join('lectivos as l', 'l.id', '=', 'hacademicas.lectivo_id')
                ->join('asignacion_academicas as aa', 'aa.grupo_id', '=', 'g.id')
                //->join('asistencia_rs as asis', 'asis.asignacion_academica_id','=','aa.id')
                ->join('empleados as e', 'e.id', '=', 'aa.empleado_id')
                ->join('grados as gra', 'gra.id', '=', 'hacademicas.grado_id')
                ->join('plantels as p', 'p.id', '=', 'c.plantel_id')
                ->where('c.st_cliente_id', '<>', 3)
                ->where('c.st_cliente_id', '<>', 1)
                ->where('aa.id', $asignacion->id)
                ->where('hacademicas.plantel_id', $asignacion->plantel_id)
                ->where('hacademicas.lectivo_id', $asignacion->lectivo_id)
                ->where('hacademicas.grupo_id', $asignacion->grupo_id)
                //->where('inscripcions.grado_id ',$asignacion->grado_id)
                ->where('aa.plantel_id', $asignacion->plantel_id)
                ->where('aa.lectivo_id', $asignacion->lectivo_id)
                ->where('aa.grupo_id', $asignacion->grupo_id)
                ->where('aa.empleado_id', $asignacion->empleado_id)
                ->where('aa.materium_id', $asignacion->materium_id)
                ->where('hacademicas.materium_id', $asignacion->materium_id)
                ->whereNull('hacademicas.deleted_at')
                ->whereNull('aa.deleted_at')
                ->whereNull('i.deleted_at')
                ->orderBy('hacademicas.plantel_id')
                ->orderBy('hacademicas.lectivo_id')
                ->orderBy('hacademicas.grupo_id')
                ->orderBy('hacademicas.grado_id')
                ->distinct()
                ->get();

            $total_alumnos = 0;
            foreach ($registros as $r) {
                $total_alumnos++;
            }

            //Log::info("FIL-".$asignacion->id."-".$total_alumnos);

            //dd($registros->toArray());

            //Agregar fechas
            //$asignacion = AsignacionAcademica::find($data['asignacion']);

            $dias = array();
            //dd($asignacion);
            foreach ($asignacion->horarios as $horario) {
                array_push($dias, $horario->dia->name);
            }
            //dd($dias);

            $fechas = array();
            $lectivo = Lectivo::find($data['lectivo_f']);
            //dd($lectivo);
            $no_habiles = array();
            $diasNoHabiles = DiaNoHabil::distinct()
                ->where('fecha', '>=', $lectivo->inicio)
                ->where('fecha', '<=', $lectivo->fin)
                ->get();
            if (count($diasNoHabiles) > 0) {
                foreach ($diasNoHabiles as $no_habil) {
                    array_push($no_habiles, Carbon::createFromFormat('Y-m-d', $no_habil->fecha));
                }
            }

            //dd($no_habiles);
            $pinicio = Carbon::createFromFormat('Y-m-d', $data['fecha_f']);
            $pfin = Carbon::createFromFormat('Y-m-d', $data['fecha_t']);

            $total_asistencias = 0;
            while ($pfin->greaterThanOrEqualTo($pinicio)) {

                if (in_array('Lunes', $dias)) {
                    //dd("hay lunes");
                    if ($pinicio->isMonday() and !in_array($pinicio, $no_habiles)) {
                        array_push($fechas, $pinicio->toDateString());
                        $total_asistencias++;
                    }
                    //dd($fechas);
                }
                if (in_array('Martes', $dias)) {
                    //dd("hay martes");
                    if ($pinicio->isTuesday() and !in_array($pinicio, $no_habiles)) {
                        array_push($fechas, $pinicio->toDateString());
                        $total_asistencias++;
                    }
                }
                if (in_array('Miercoles', $dias)) {
                    //dd("hay miercoles");
                    if ($pinicio->isWednesday() and !in_array($pinicio, $no_habiles)) {
                        array_push($fechas, $pinicio->toDateString());
                        $total_asistencias++;
                    }
                }
                if (in_array('Jueves', $dias)) {
                    //dd("hay jueves");
                    if ($pinicio->isThursday() and !in_array($pinicio, $no_habiles)) {
                        array_push($fechas, $pinicio->toDateString());
                        $total_asistencias++;
                    }
                }
                if (in_array('Viernes', $dias)) {
                    //dd("hay viernes");
                    if ($pinicio->isFriday() and !in_array($pinicio, $no_habiles)) {
                        array_push($fechas, $pinicio->toDateString());
                        $total_asistencias++;
                    }
                }
                if (in_array('Sabado', $dias)) {

                    if ($pinicio->isSaturday() and !in_array($pinicio, $no_habiles)) {
                        array_push($fechas, $pinicio->toDateString());
                        $total_asistencias++;
                    }
                }
                $pinicio->addDay();
                //dd($fechas);
            }
            //dd($fechas);
            $asistencias_planeadas = 0;
            foreach ($fechas as $fecha) {
                $asistencias_planeadas++;
            }

            foreach ($registros as $r) {
                /*if($loop==1){
                Log::info("FLC-" . $asignacion->id . "-" . $total_alumnos);
                }*/
                $asistencias_reales = \App\AsistenciaR::where('asignacion_academica_id', $asignacion->id)
                    ->where('cliente_id', $r->cliente)
                    ->whereIn('est_asistencia_id', array(1, 4))
                    ->whereNotIn('cliente_id', [0, 2])
                    ->where('fecha', '>=', $data['fecha_f'])
                    ->where('fecha', '<=', $data['fecha_t'])
                    ->count();
                //->get();

                //dd($asistencias_planeadas ." - ".$asistencias_reales);
                $promedio_cliente = ($asistencias_reales * 100) / $asistencias_planeadas;
                //Log::info('Promedio-'.$promedio_cliente);
                $contador_clientes++;
                $contador_clientes_asignacion++;
                $sumatoria_promedio_clientes_asignacion = $sumatoria_promedio_clientes_asignacion + $promedio_cliente;
                $sumatoria_promedio_clientes = $sumatoria_promedio_clientes + $promedio_cliente;
            }
            if ($contador_clientes_asignacion > 0) {
                $resul = $sumatoria_promedio_clientes_asignacion / $contador_clientes_asignacion;
            } else {
                $resul = "Sin clientes";
            }

            array_push($resumen, array(
                'asignacion' => $asignacion->id,
                'plantel' => $asignacion->plantel->razon,
                'instructor' => $asignacion->empleado->nombre . ' ' . $asignacion->empleado->ape_paterno . ' ' . $asignacion->empleado->ape_materno,
                'materia' => $asignacion->materia->name,
                'grupo' => $asignacion->grupo->name,
                'lectivo' => $asignacion->lectivo->name,
                'total_alumnos' => $total_alumnos,
                'promedio_asistencia' => $resul,
            ));
        }
        //dd($resumen);
        //dd($sumatoria_promedio_clientes.'-'.$contador_clientes);
        //dd($fechas);
        //dd($registros->grupo);

        /*return view('inscripcions.reportes.lista_alumnosr',compact('registros'))
        ->with( 'list', Inscripcion::getListFromAllRelationApps() );
         * */

        /*                PDF::setOptions(['defaultFont' => 'arial']);

        $pdf = PDF::loadView('inscripcions.reportes.lista_alumnosr', array('registros'=>$registros,'fechas_enc'=>$fechas))
        ->setPaper('legal', 'landscape');
        return $pdf->download('reporte.pdf');
         */
        return view('inscripcions.reportes.porcentajeAsistenciaR', array(
            'resumen' => $resumen,
            'datos' => $data,
        ));
    }

    public function widgetPorcentajeAsistencia(Request $request)
    {
        $data = $request->all();
        //dd($data);

        //$fecha_hoy = date('2019-12-17');
        $fecha_hoy = date('Y-m-d');

        $lectivos = Lectivo::whereDate('inicio', '<=', $fecha_hoy)
            ->whereDate('fin', '>=', $fecha_hoy)
            ->get();

        $lectivos_array = array();
        $posicion = 0;
        foreach ($lectivos as $lectivo) {
            $lectivos_array[$posicion] = $lectivo->id;
            $posicion++;
        }
        //dd($lectivos_array);
        $asignaciones = AsignacionAcademica::where('plantel_id', $data['plantel'])
            ->whereIn('lectivo_id', $lectivos_array)
            //->where('lectivo_id', $data['lectivo_f'])
            //->where('id',1037)
            ->orderBy('plantel_id')
            ->orderBy('lectivo_id')
            ->orderBy('materium_id')
            ->get();
        $contador_clientes = 0;
        $sumatoria_promedio_clientes = 0;
        $resumen = array();
        //dd($asignaciones->toArray());
        foreach ($asignaciones as $asignacion) {
            $contador_clientes_asignacion = 0;
            $sumatoria_promedio_clientes_asignacion = 0;
            $registros = Hacademica::select(
                'hacademicas.grupo_id',
                'hacademicas.grado_id',
                'hacademicas.lectivo_id',
                'hacademicas.plantel_id',
                'c.nombre',
                'c.nombre2',
                'c.ape_paterno',
                'c.ape_materno',
                'g.name as grupo',
                'l.name as lectivo',
                'mat.name as materia',
                DB::raw('concat(e.nombre," ",e.ape_paterno," ",e.ape_materno) as maestro'),
                'gra.name as grado',
                'p.razon as plantel',
                'p.logo',
                'aa.id as asignacion',
                'c.id as cliente',
                'p.id as p_id',
                'c.tel_fijo'
            )
                ->join('inscripcions as i', 'i.id', '=', 'hacademicas.inscripcion_id')
                ->join('materia as mat', 'mat.id', '=', 'hacademicas.materium_id')
                ->join('clientes as c', 'c.id', '=', 'hacademicas.cliente_id')
                ->join('grupos as g', 'g.id', '=', 'hacademicas.grupo_id')
                ->join('lectivos as l', 'l.id', '=', 'hacademicas.lectivo_id')
                ->join('asignacion_academicas as aa', 'aa.grupo_id', '=', 'g.id')
                //->join('asistencia_rs as asis', 'asis.asignacion_academica_id','=','aa.id')
                ->join('empleados as e', 'e.id', '=', 'aa.empleado_id')
                ->join('grados as gra', 'gra.id', '=', 'hacademicas.grado_id')
                ->join('plantels as p', 'p.id', '=', 'c.plantel_id')
                ->where('c.st_cliente_id', '<>', 3)
                ->where('c.st_cliente_id', '<>', 1)
                ->where('aa.id', $asignacion->id)
                ->where('hacademicas.plantel_id', $asignacion->plantel_id)
                ->where('hacademicas.lectivo_id', $asignacion->lectivo_id)
                ->where('hacademicas.grupo_id', $asignacion->grupo_id)
                //->where('inscripcions.grado_id ',$asignacion->grado_id)
                ->where('aa.plantel_id', $asignacion->plantel_id)
                ->where('aa.lectivo_id', $asignacion->lectivo_id)
                ->where('aa.grupo_id', $asignacion->grupo_id)
                ->where('aa.empleado_id', $asignacion->empleado_id)
                ->where('aa.materium_id', $asignacion->materium_id)
                ->where('hacademicas.materium_id', $asignacion->materium_id)
                ->whereNull('hacademicas.deleted_at')
                ->whereNull('aa.deleted_at')
                ->whereNull('i.deleted_at')
                ->orderBy('hacademicas.plantel_id')
                ->orderBy('hacademicas.lectivo_id')
                ->orderBy('hacademicas.grupo_id')
                ->orderBy('hacademicas.grado_id')
                ->distinct()
                ->get();

            $total_alumnos = 0;
            foreach ($registros as $r) {
                $total_alumnos++;
            }

            //AsignacionAcademica::find($data['asignacion']);

            $dias = array();
            //dd($asignacion);
            foreach ($asignacion->horarios as $horario) {
                array_push($dias, $horario->dia->name);
            }
            //dd($dias);

            $fechas = array();
            $lectivo = Lectivo::find($asignacion->lectivo_id);
            //dd(count($lectivo->diasNoHabiles));
            $no_habiles = array();
            $diasNoHabiles = DiaNoHabil::distinct()
                ->where('fecha', '>=', $lectivo->inicio)
                ->where('fecha', '<=', $lectivo->fin)
                ->get();
            if (count($diasNoHabiles) > 0) {
                foreach ($diasNoHabiles as $no_habil) {
                    array_push($no_habiles, Carbon::createFromFormat('Y-m-d', $no_habil->fecha));
                }
            }

            //dd($no_habiles);
            //$pinicio = Carbon::createFromFormat('Y-m-d', $data['fecha_f']);
            $pinicio = Carbon::createFromFormat('Y-m-d', $fecha_hoy)
                ->startOfWeek(Carbon::MONDAY)
                ->subWeek()
                ->startOfWeek();
            $vinicio = Carbon::createFromFormat('Y-m-d', $fecha_hoy)
                ->startOfWeek(Carbon::MONDAY)
                ->subWeek()
                ->startOfWeek();

            $pfin = Carbon::createFromFormat('Y-m-d', $fecha_hoy)
                ->startOfWeek(Carbon::MONDAY)
                ->subWeek()
                ->endOfWeek();

            $total_asistencias = 0;
            while ($pfin->greaterThanOrEqualTo($pinicio)) {

                if (in_array('Lunes', $dias)) {
                    //dd("hay lunes");
                    if ($pinicio->isMonday() and !in_array($pinicio, $no_habiles)) {
                        array_push($fechas, $pinicio->toDateString());
                        $total_asistencias++;
                    }
                    //dd($fechas);
                }
                if (in_array('Martes', $dias)) {
                    //dd("hay martes");
                    if ($pinicio->isTuesday() and !in_array($pinicio, $no_habiles)) {
                        array_push($fechas, $pinicio->toDateString());
                        $total_asistencias++;
                    }
                }
                if (in_array('Miercoles', $dias)) {
                    //dd("hay miercoles");
                    if ($pinicio->isWednesday() and !in_array($pinicio, $no_habiles)) {
                        array_push($fechas, $pinicio->toDateString());
                        $total_asistencias++;
                    }
                }
                if (in_array('Jueves', $dias)) {
                    //dd("hay jueves");
                    if ($pinicio->isThursday() and !in_array($pinicio, $no_habiles)) {
                        array_push($fechas, $pinicio->toDateString());
                        $total_asistencias++;
                    }
                }
                if (in_array('Viernes', $dias)) {
                    //dd("hay viernes");
                    if ($pinicio->isFriday() and !in_array($pinicio, $no_habiles)) {
                        array_push($fechas, $pinicio->toDateString());
                        $total_asistencias++;
                    }
                }
                if (in_array('Sabado', $dias)) {

                    if ($pinicio->isSaturday() and !in_array($pinicio, $no_habiles)) {
                        array_push($fechas, $pinicio->toDateString());
                        $total_asistencias++;
                    }
                }
                $pinicio->addDay();
                //dd($fechas);
            }
            //dd($fechas);
            $asistencias_planeadas = 0;
            foreach ($fechas as $fecha) {
                $asistencias_planeadas++;
            }

            foreach ($registros as $r) {
                /*if($loop==1){
                Log::info("FLC-" . $asignacion->id . "-" . $total_alumnos);
                }*/

                $asistencias_reales = \App\AsistenciaR::where('asignacion_academica_id', $asignacion->id)
                    ->where('cliente_id', $r->cliente)
                    ->whereIn('est_asistencia_id', array(1, 4))
                    ->whereNotIn('cliente_id', [0, 2])
                    ->whereDate('fecha', '>=', $vinicio->format('Y-m-d'))
                    ->whereDate('fecha', '<=', $pfin->format('Y-m-d'))
                    ->whereIn('fecha', $fechas)
                    ->count();
                //->get();

                //dd($asistencias_planeadas ." - ".$asistencias_reales);
                if ($asistencias_planeadas == 0) {
                    $promedio_cliente = 0;
                } else {
                    $promedio_cliente = ($asistencias_reales * 100) / $asistencias_planeadas;
                }

                //Log::info('Promedio-'.$promedio_cliente);
                $contador_clientes++;
                $contador_clientes_asignacion++;
                $sumatoria_promedio_clientes_asignacion = $sumatoria_promedio_clientes_asignacion + $promedio_cliente;
                $sumatoria_promedio_clientes = $sumatoria_promedio_clientes + $promedio_cliente;
            }
            if ($contador_clientes_asignacion > 0) {
                $resul = $sumatoria_promedio_clientes_asignacion / $contador_clientes_asignacion;
            } else {
                $resul = 0;
            }

            array_push($resumen, array(
                'asignacion' => $asignacion->id,
                'plantel' => $asignacion->plantel->razon,
                'instructor' => $asignacion->empleado->nombre . ' ' . $asignacion->empleado->ape_paterno . ' ' . $asignacion->empleado->ape_materno,
                'materia' => $asignacion->materia->name,
                'grupo' => $asignacion->grupo->name,
                'lectivo' => $asignacion->lectivo->name,
                'total_alumnos' => $total_alumnos,
                'promedio_asistencia' => $resul,
            ));
        }

        $cuenta_calificaciones = 0;
        $suma_calificaciones = 0;
        foreach ($resumen as $cali) {
            if (!is_nan($cali['promedio_asistencia'])) {
                $suma_calificaciones = $suma_calificaciones + $cali['promedio_asistencia'];
                $cuenta_calificaciones++;
            }
        }
        //dd($suma_calificaciones . " " . $cuenta_calificaciones);
        if ($suma_calificaciones == 0) {
            return 0;
        }
        if ($cuenta_calificaciones > 0) {
            $promedio = round(($suma_calificaciones / $cuenta_calificaciones), 2);
        } else {
            $promedio = 0;
        }
        return $promedio;
    }

    public function widgetPorcentajeAsistenciaDetalle(Request $request)
    {
        $data = $request->all();
        //dd($data);

        //$fecha_hoy = date('2019-12-17');
        $fecha_hoy = date('Y-m-d');

        $lectivos = Lectivo::whereDate('inicio', '<=', $fecha_hoy)
            ->whereDate('fin', '>=', $fecha_hoy)
            ->get();

        $lectivos_array = array();
        $posicion = 0;
        foreach ($lectivos as $lectivo) {
            $lectivos_array[$posicion] = $lectivo->id;
            $posicion++;
        }
        //dd($lectivos_array);
        $asignaciones = AsignacionAcademica::where('plantel_id', $data['plantel'])
            ->whereIn('lectivo_id', $lectivos_array)
            //->where('lectivo_id', $data['lectivo_f'])
            //->where('id', 1508)
            ->orderBy('plantel_id')
            ->orderBy('lectivo_id')
            ->orderBy('materium_id')
            ->get();
        //dd($asignaciones->toArray());
        $contador_clientes = 0;
        $sumatoria_promedio_clientes = 0;
        $resumen = array();
        //dd($asignaciones->toArray());
        foreach ($asignaciones as $asignacion) {
            $contador_clientes_asignacion = 0;
            $sumatoria_promedio_clientes_asignacion = 0;
            $registros = Hacademica::select(
                'hacademicas.grupo_id',
                'hacademicas.grado_id',
                'hacademicas.lectivo_id',
                'hacademicas.plantel_id',
                'c.nombre',
                'c.nombre2',
                'c.ape_paterno',
                'c.ape_materno',
                'g.name as grupo',
                'l.name as lectivo',
                'mat.name as materia',
                DB::raw('concat(e.nombre," ",e.ape_paterno," ",e.ape_materno) as maestro'),
                'gra.name as grado',
                'p.razon as plantel',
                'p.logo',
                'aa.id as asignacion',
                'c.id as cliente',
                'p.id as p_id',
                'c.tel_fijo'
            )
                ->join('inscripcions as i', 'i.id', '=', 'hacademicas.inscripcion_id')
                ->join('materia as mat', 'mat.id', '=', 'hacademicas.materium_id')
                ->join('clientes as c', 'c.id', '=', 'hacademicas.cliente_id')
                ->join('grupos as g', 'g.id', '=', 'hacademicas.grupo_id')
                ->join('lectivos as l', 'l.id', '=', 'hacademicas.lectivo_id')
                ->join('asignacion_academicas as aa', 'aa.grupo_id', '=', 'g.id')
                //->join('asistencia_rs as asis', 'asis.asignacion_academica_id','=','aa.id')
                ->join('empleados as e', 'e.id', '=', 'aa.empleado_id')
                ->join('grados as gra', 'gra.id', '=', 'hacademicas.grado_id')
                ->join('plantels as p', 'p.id', '=', 'c.plantel_id')
                ->where('c.st_cliente_id', '<>', 3)
                ->where('c.st_cliente_id', '<>', 1)
                ->where('aa.id', $asignacion->id)
                //->where('aa.id', 1508)
                ->where('hacademicas.plantel_id', $asignacion->plantel_id)
                ->where('hacademicas.lectivo_id', $asignacion->lectivo_id)
                ->where('hacademicas.grupo_id', $asignacion->grupo_id)
                //->where('inscripcions.grado_id ',$asignacion->grado_id)
                ->where('aa.plantel_id', $asignacion->plantel_id)
                ->where('aa.lectivo_id', $asignacion->lectivo_id)
                ->where('aa.grupo_id', $asignacion->grupo_id)
                ->where('aa.empleado_id', $asignacion->empleado_id)
                ->where('aa.materium_id', $asignacion->materium_id)
                ->where('hacademicas.materium_id', $asignacion->materium_id)
                ->whereNull('hacademicas.deleted_at')
                ->whereNull('aa.deleted_at')
                ->whereNull('i.deleted_at')
                ->orderBy('hacademicas.plantel_id')
                ->orderBy('hacademicas.lectivo_id')
                ->orderBy('hacademicas.grupo_id')
                ->orderBy('hacademicas.grado_id')
                ->distinct()
                ->get();

            $total_alumnos = 0;
            foreach ($registros as $r) {
                $total_alumnos++;
            }

            //AsignacionAcademica::find($data['asignacion']);

            $dias = array();
            //dd($asignacion->horarios->toArray());
            foreach ($asignacion->horarios as $horario) {
                array_push($dias, $horario->dia->name);
            }
            //dd($dias);

            $fechas = array();
            $lectivo = Lectivo::find($asignacion->lectivo_id);
            //dd(count($lectivo->diasNoHabiles));
            $no_habiles = array();
            $diasNoHabiles = DiaNoHabil::distinct()
                ->where('fecha', '>=', $lectivo->inicio)
                ->where('fecha', '<=', $lectivo->fin)
                ->get();
            if (count($diasNoHabiles) > 0) {
                foreach ($diasNoHabiles as $no_habil) {
                    array_push($no_habiles, Carbon::createFromFormat('Y-m-d', $no_habil->fecha));
                }
            }

            //dd($no_habiles);
            //$pinicio = Carbon::createFromFormat('Y-m-d', $data['fecha_f']);
            $pinicio = Carbon::createFromFormat('Y-m-d', $fecha_hoy)
                ->startOfWeek(Carbon::MONDAY)
                ->subWeek()
                ->startOfWeek();
            $vinicio = Carbon::createFromFormat('Y-m-d', $fecha_hoy)
                ->startOfWeek(Carbon::MONDAY)
                ->subWeek()
                ->startOfWeek();

            $pfin = Carbon::createFromFormat('Y-m-d', $fecha_hoy)
                ->startOfWeek(Carbon::MONDAY)
                ->subWeek()
                ->endOfWeek();

            $total_asistencias = 0;
            while ($pfin->greaterThanOrEqualTo($pinicio)) {

                if (in_array('Lunes', $dias)) {
                    //dd("hay lunes");
                    if ($pinicio->isMonday() and !in_array($pinicio, $no_habiles)) {
                        array_push($fechas, $pinicio->toDateString());
                        $total_asistencias++;
                    }
                    //dd($fechas);
                }
                if (in_array('Martes', $dias)) {
                    //dd("hay martes");
                    if ($pinicio->isTuesday() and !in_array($pinicio, $no_habiles)) {
                        array_push($fechas, $pinicio->toDateString());
                        $total_asistencias++;
                    }
                }
                if (in_array('Miercoles', $dias)) {
                    //dd("hay miercoles");
                    if ($pinicio->isWednesday() and !in_array($pinicio, $no_habiles)) {
                        array_push($fechas, $pinicio->toDateString());
                        $total_asistencias++;
                    }
                }
                if (in_array('Jueves', $dias)) {
                    //dd("hay jueves");
                    if ($pinicio->isThursday() and !in_array($pinicio, $no_habiles)) {
                        array_push($fechas, $pinicio->toDateString());
                        $total_asistencias++;
                    }
                }
                if (in_array('Viernes', $dias)) {
                    //dd("hay viernes");
                    if ($pinicio->isFriday() and !in_array($pinicio, $no_habiles)) {
                        array_push($fechas, $pinicio->toDateString());
                        $total_asistencias++;
                    }
                }
                if (in_array('Sabado', $dias)) {

                    if ($pinicio->isSaturday() and !in_array($pinicio, $no_habiles)) {
                        array_push($fechas, $pinicio->toDateString());
                        $total_asistencias++;
                    }
                }
                $pinicio->addDay();
                //dd($fechas);
            }
            //dd($fechas);
            $asistencias_planeadas = 0;
            foreach ($fechas as $fecha) {
                $asistencias_planeadas++;
            }

            foreach ($registros as $r) {
                /*if($loop==1){
                Log::info("FLC-" . $asignacion->id . "-" . $total_alumnos);
                }*/

                $asistencias_reales = \App\AsistenciaR::where('asignacion_academica_id', $asignacion->id)
                    ->where('cliente_id', $r->cliente)
                    ->whereIn('est_asistencia_id', array(1, 4))
                    ->whereNotIn('cliente_id', [0, 2])
                    ->whereDate('fecha', '>=', $vinicio->format('Y-m-d'))
                    ->whereDate('fecha', '<=', $pfin->format('Y-m-d'))
                    ->whereIn('fecha', $fechas)
                    ->count();
                //->get();
                //dd($asistencias_reales->toArray());

                //dd($asistencias_planeadas ." - ".$asistencias_reales);

                if ($asistencias_planeadas == 0) {
                    $promedio_cliente = 0;
                } else {
                    $promedio_cliente = ($asistencias_reales * 100) / $asistencias_planeadas;
                }
                //Log::info($r->cliente . 'Promedio-' . $asistencias_reales);
                $contador_clientes++;
                $contador_clientes_asignacion++;
                $sumatoria_promedio_clientes_asignacion = $sumatoria_promedio_clientes_asignacion + $promedio_cliente;
                $sumatoria_promedio_clientes = $sumatoria_promedio_clientes + $promedio_cliente;
            }
            if ($contador_clientes_asignacion > 0) {
                $resul = $sumatoria_promedio_clientes_asignacion / $contador_clientes_asignacion;
            } else {
                $resul = 0;
            }

            array_push($resumen, array(
                'asignacion' => $asignacion->id,
                'plantel' => $asignacion->plantel->razon,
                'instructor' => $asignacion->empleado->nombre . ' ' . $asignacion->empleado->ape_paterno . ' ' . $asignacion->empleado->ape_materno,
                'materia' => $asignacion->materia->name,
                'grupo' => $asignacion->grupo->name,
                'lectivo' => $asignacion->lectivo->name,
                'total_alumnos' => $total_alumnos,
                'promedio_asistencia' => $resul,
            ));
        }
        //dd($resumen);

        return view('inscripcions.reportes.widgetPorcentajeAsistenciaDetalle', compact('resumen'));
    }

    public function wCalificacion(Request $request)
    {
        return view('inscripcions.reportes.wCalificacion')
            ->with('list', Inscripcion::getListFromAllRelationApps());
    }

    public function wCalificacionR(Request $request)
    {
        $datos = $request->all();
        $registros = Hacademica::select(
            'c.id',
            'stc.name as estatus',
            'e.name as especialidad',
            'n.name as nivel',
            'g.name as grado',
            'm.name as materia',
            'te.name as tipo_examen',
            'cpo.name as carga_ponderacion',
            'cp.calificacion_parcial as calificacion',
            'cp.updated_at as fecha'
        )
            ->join('especialidads as e', 'e.id', '=', 'hacademicas.especialidad_id')
            ->join('nivels as n', 'n.id', '=', 'hacademicas.nivel_id')
            ->join('grados as g', 'g.id', '=', 'hacademicas.grado_id')
            ->join('materia as m', 'm.id', '=', 'hacademicas.materium_id')
            ->join('clientes as c', 'c.id', '=', 'hacademicas.cliente_id')
            ->join('st_clientes as stc', 'stc.id', '=', 'c.st_cliente_id')
            ->join('calificacions as calif', 'calif.hacademica_id', '=', 'hacademicas.id')
            ->join('tpo_examens as te', 'te.id', '=', 'calif.tpo_examen_id')
            ->join('calificacion_ponderacions as cp', 'cp.calificacion_id', '=', 'calif.id')
            ->join('carga_ponderacions as cpo', 'cpo.id', '=', 'cp.carga_ponderacion_id')
            ->where('hacademicas.plantel_id', $datos['plantel'])
            ->where('c.st_cliente_id', $datos['st_cliente'])
            ->whereRaw('DATE_FORMAT(cp.updated_at, "%Y-%m-%d")>=?', [$datos['fecha_f']])
            ->whereRaw('DATE_FORMAT(cp.updated_at, "%Y-%m-%d")<=?', [$datos['fecha_t']])
            ->where('cp.padre_id', 0)
            ->where('cp.tiene_detalle', 0)
            ->whereNull('hacademicas.deleted_at')
            ->whereNull('calif.deleted_at')
            ->whereNull('cpo.deleted_at')
            ->orderBy('c.id')
            ->orderBy('cp.updated_at')
            ->get();

        return view('inscripcions.reportes.wCalificacionR')
            ->with('list', Inscripcion::getListFromAllRelationApps());
    }

    public function wdCalificacionR(Request $request)
    {
        $datos = $request->all();
        //dd($datos);

        $fecha = Carbon::createFromFormat('Y-m-d', Date('Y-m-d'));
        $mes = 0;
        $anio = 0;
        if ($fecha->month == 1) {
            $mes = 12;
            $anio = $fecha->year - 1;
        } else {
            $mes = $fecha->month;
            $anio = $fecha->year;
        }

        //dd($fecha);
        $registros = Hacademica::select(
            'c.id',
            'stc.name as estatus',
            'e.name as especialidad',
            'n.name as nivel',
            'g.name as grado',
            'm.name as materia',
            'te.name as tipo_examen',
            'cpo.name as carga_ponderacion',
            'cp.calificacion_parcial as calificacion',
            'cp.updated_at as fecha',
            'gru.name as grupo'
        )
            ->join('especialidads as e', 'e.id', '=', 'hacademicas.especialidad_id')
            ->join('nivels as n', 'n.id', '=', 'hacademicas.nivel_id')
            ->join('grados as g', 'g.id', '=', 'hacademicas.grado_id')
            ->join('materia as m', 'm.id', '=', 'hacademicas.materium_id')
            ->join('grupos as gru', 'gru.id', '=', 'hacademicas.grupo_id')
            ->join('clientes as c', 'c.id', '=', 'hacademicas.cliente_id')
            ->join('st_clientes as stc', 'stc.id', '=', 'c.st_cliente_id')
            ->join('calificacions as calif', 'calif.hacademica_id', '=', 'hacademicas.id')
            ->join('tpo_examens as te', 'te.id', '=', 'calif.tpo_examen_id')
            ->join('calificacion_ponderacions as cp', 'cp.calificacion_id', '=', 'calif.id')
            ->join('carga_ponderacions as cpo', 'cpo.id', '=', 'cp.carga_ponderacion_id')
            ->where('hacademicas.plantel_id', $datos['plantel'])
            ->where('c.st_cliente_id', 4)
            ->whereMonth('cp.updated_at', $mes)
            ->whereYear('cp.updated_at', $anio)
            ->where('cp.padre_id', 0)
            ->where('cp.tiene_detalle', 0)
            ->whereNull('hacademicas.deleted_at')
            ->whereNull('calif.deleted_at')
            ->whereNull('cpo.deleted_at')
            ->orderBy('e.id')
            ->orderBy('n.id')
            ->orderBy('g.id')
            ->orderBy('gru.id')
            ->orderBy('cp.updated_at')
            ->get();
        //dd($registros->toArray());
        $total = count($registros);
        //dd($total);
        $suma = 0;
        $cuenta = 0;
        foreach ($registros as $registro) {
            $suma = $suma + $registro->calificacion;
            $cuenta++;
        }
        //dd($cuenta);
        if ($total == 0) {
            return response()->json(['promedio' => 0]);
        }
        $promedio = round($suma / $total, 2) * 10;
        return response()->json(['promedio' => $promedio]);
    }

    public function wdCalificacionRDetalle(Request $request)
    {
        $datos = $request->all();
        //dd($datos);

        $fecha = Carbon::createFromFormat('Y-m-d', Date('Y-m-d'));
        $mes = 0;
        $anio = 0;

        //$mes_desc=$fecha->
        if ($fecha->month == 1) {
            $mes = 12;
            $anio = $fecha->year - 1;
        } else {
            $mes = $fecha->month;
            $anio = $fecha->year;
        }
        $mese = Mese::find($mes);

        //dd($fecha);
        $registros = Hacademica::select(
            'c.id',
            'stc.name as estatus',
            'e.name as especialidad',
            'n.name as nivel',
            'g.name as grado',
            'm.name as materia',
            'te.name as tipo_examen',
            'cpo.name as carga_ponderacion',
            'cp.calificacion_parcial as calificacion',
            'cp.updated_at as fecha',
            'gru.name as grupo'
        )
            ->join('especialidads as e', 'e.id', '=', 'hacademicas.especialidad_id')
            ->join('nivels as n', 'n.id', '=', 'hacademicas.nivel_id')
            ->join('grados as g', 'g.id', '=', 'hacademicas.grado_id')
            ->join('materia as m', 'm.id', '=', 'hacademicas.materium_id')
            ->join('grupos as gru', 'gru.id', '=', 'hacademicas.grupo_id')
            ->join('clientes as c', 'c.id', '=', 'hacademicas.cliente_id')
            ->join('st_clientes as stc', 'stc.id', '=', 'c.st_cliente_id')
            ->join('calificacions as calif', 'calif.hacademica_id', '=', 'hacademicas.id')
            ->join('tpo_examens as te', 'te.id', '=', 'calif.tpo_examen_id')
            ->join('calificacion_ponderacions as cp', 'cp.calificacion_id', '=', 'calif.id')
            ->join('carga_ponderacions as cpo', 'cpo.id', '=', 'cp.carga_ponderacion_id')
            ->where('hacademicas.plantel_id', $datos['plantel'])
            ->where('c.st_cliente_id', 4)
            ->whereMonth('cp.updated_at', $mes)
            ->whereYear('cp.updated_at', $anio)
            ->where('cp.padre_id', 0)
            ->where('cp.tiene_detalle', 0)
            ->whereNull('hacademicas.deleted_at')
            ->whereNull('calif.deleted_at')
            ->whereNull('cpo.deleted_at')
            ->orderBy('e.id')
            ->orderBy('n.id')
            ->orderBy('g.id')
            ->orderBy('gru.id')
            ->orderBy('cp.updated_at')
            ->get();
        //dd($registros->toArray());
        $resumen = array();
        $detalle = array();
        $detalle['calificacion'] = 0;
        $detalle['cantidad'] = 0;

        $grupo = "";
        $indicador = 0;
        $cantidad = 0;
        foreach ($registros as $registro) {
            $indicador++;
            $detalle['especialidad'] = $registro->especialidad;
            $detalle['nivel'] = $registro->nivel;
            $detalle['grado'] = $registro->grado;
            $detalle['calificacion'] = $detalle['calificacion'] + $registro->calificacion;
            $detalle['cantidad']++;
            //Log::info($indicador . "-" . $detalle['cantidad']);
            $detalle['grupo'] = $registro->grupo;
            //dd($registro);
            if ($grupo != $registro->grupo and $indicador != 1) {
                //dd($grado . "-" . $registro->grado);
                $detalle['promedio'] = $detalle['calificacion'] / $detalle['cantidad'];
                array_push($resumen, $detalle);
                $detalle['cantidad'] = 0;
                $detalle['calificacion'] = 0;
            }
            $grupo = $registro->grupo;
        }
        array_push($resumen, $detalle);
        //dd($resumen);
        return view('inscripcions.reportes.wCalificacionRDetalle', compact('resumen', 'mese'));
    }

    public function historiaCalificaciones(Request $request)
    {
        $datos = $request->all();

        $cliente = Cliente::find($datos['cliente']);
        if (is_null($cliente)) {
            return response()->json([
                'message' => 'Cliente No Existe',
            ], 404);
        }
        //dd($cliente);
        $array_resultado = array();
        $inscripciones = Inscripcion::where('cliente_id', $cliente->id)->get();
        //dd($inscripciones->toArray());
        $array_inscripcions = array();
        foreach ($inscripciones as $inscripcion) {
            $array_materias = array();
            $materias = Hacademica::where('inscripcion_id', $inscripcion->id)->get();
            //dd($materias->toArray());
            foreach ($materias as $materia) {
                $calificacions = Calificacion::where('hacademica_id', $materia->id)->get();
                $array_calificaciones = array();
                foreach ($calificacions as $calificacion) {

                    $ponderacions = CalificacionPonderacion::where('calificacion_id', $calificacion->id)
                        ->where('calificacion_parcial', '<>', 0)
                        ->get();
                    $array_ponderaciones = array();
                    $registro = array();
                    foreach ($ponderacions as $ponderacion) {
                        $registro['ponderacion'] = $ponderacion->cargaPonderacion->name;
                        $registro['calificacion_parcial'] = $ponderacion->calificacion_parcial;
                        array_push($array_ponderaciones, $registro);
                    }
                    //dd($array_ponderaciones);
                    if (count($ponderacions) == 0) {
                        array_push($array_calificaciones, array(
                            'tipo_examen' => $calificacion->tpoExamen->name,
                            'calificacion' => $calificacion->calificacion,
                            'ponderaciones' => 'Sin Ponderaciones',
                        ));
                    } else {
                        array_push($array_calificaciones, array(
                            'tipo_examen' => $calificacion->tpoExamen->name,
                            'calificacion' => $calificacion->calificacion,
                            'ponderaciones' => $array_ponderaciones,
                        ));
                    }
                }
                //dd($array_calificaciones);
                if (count($calificacions) == 0) {
                    array_push($array_materias, array(
                        'materia' => $materia->materia->name,
                        'estatus' => $materia->stMateria->name,
                        'calificaciones' => 'Sin calificaciones',
                    ));
                } else {
                    array_push($array_materias, array(
                        'materia' => $materia->materia->name,
                        'estatus' => $materia->stMateria->name,
                        'calificaciones' => $array_calificaciones,
                    ));
                }
            }
            //dd($array_materias);
            if (count($materias) == 0) {
                array_push($array_inscripcions, array(
                    'plantel' => $inscripcion->plantel->razon,
                    'especialidad' => $inscripcion->especialidad->name,
                    'nivel' => $inscripcion->nivel->name,
                    'grado' => $inscripcion->grado->name,
                    'lectivo' => $inscripcion->lectivo->name,
                    'estatus' => $inscripcion->stInscripcion->name,
                    'materias' => 'Sin materias',
                ));
            } else {
                array_push($array_inscripcions, array(
                    'plantel' => $inscripcion->plantel->razon,
                    'especialidad' => $inscripcion->especialidad->name,
                    'nivel' => $inscripcion->nivel->name,
                    'grado' => $inscripcion->grado->name,
                    'lectivo' => $inscripcion->lectivo->name,
                    'estatus' => $inscripcion->stInscripcion->name,
                    'materias' => $array_materias,
                ));
            }
        }
        if (count($inscripciones) == 0) {
            array_push($array_resultado, array(
                'ciente_id' => $cliente->id,
                'cliente_nombre_completo' => $cliente->nombre . " " . $cliente->nombre2 . " " . $cliente->ape_paterno . " " . $cliente->ape_materno,
                'inscripciones' => 'Sin inscripciones',
            ));
        } else {
            array_push($array_resultado, array(
                'ciente_id' => $cliente->id,
                'cliente_nombre_completo' => $cliente->nombre . " " . $cliente->nombre2 . " " . $cliente->ape_paterno . " " . $cliente->ape_materno,
                'inscripciones' => $array_inscripcions,
            ));
        }

        //dd($array_resultado);
        return response()->json(['resultado' => $array_resultado]);
    }

    public function alumnosXinscripcion(Request $request)
    {
        $datos = $request->all();
        $inscripcion = Inscripcion::find($datos['id']);
        $inscripcions = Inscripcion::where('plantel_id', $inscripcion->plantel_id)
            ->where('especialidad_id', $inscripcion->especialidad_id)
            ->where('nivel_id', $inscripcion->nivel_id)
            ->where('grado_id', $inscripcion->grado_id)
            ->where('lectivo_id', $inscripcion->lectivo_id)
            ->where('grupo_id', $inscripcion->grupo_id)
            ->where('periodo_estudio_id', $inscripcion->periodo_estudio_id)
            ->with('cliente')
            ->get();

        return view('inscripcions.agregarMaterias', compact('inscripcions', 'inscripcion'));
    }

    public function cargarMaterias(Request $request)
    {
        $datos = $request->all();
        //dd($datos['insc']);
        $i = 0;
        foreach ($datos['insc'] as $buscarInscripcion) {
            //$inscripcion = Inscripcion::find($buscarInscripcion);
            $this->registrarMaterias2($buscarInscripcion);
            $i = $buscarInscripcion;
        }

        return redirect()->route('inscripcions.alumnosXinscripcion', array('id' => $i))->with('message', 'Registro Creado.');
    }

    protected function registrarMaterias2($id)
    {
        $i = Inscripcion::find($id);
        //Log::info($id);
        $materias = PeriodoEstudio::find($i->periodo_estudio_id)->materias;
        $materias_array = array();
        foreach ($materias as $m) {
            array_push($materias_array, $m->id);
        }
        //dd($materias);
        $materias_validar = Hacademica::where('hacademicas.grupo_id', '=', $i->grupo_id)
            ->join('inscripcions as i', 'i.id', '=', 'hacademicas.inscripcion_id')
            ->whereNull('i.deleted_at')
            ->where('hacademicas.cliente_id', '=', $i->cliente_id)
            ->where('hacademicas.grado_id', '=', $i->grado_id)
            ->where('hacademicas.lectivo_id', '=', $i->lectivo_id)
            ->whereIn('hacademicas.materium_id', $materias_array)
            ->whereNull('hacademicas.deleted_at')
            ->get();

        if ($materias_validar->count() == 0) {
            foreach ($materias as $m) {
                $h['inscripcion_id'] = $i->id;
                $h['cliente_id'] = $i->cliente_id;
                $h['plantel_id'] = $i->plantel_id;
                $h['especialidad_id'] = $i->especialidad_id;
                $h['nivel_id'] = $i->nivel_id;
                $h['grado_id'] = $i->grado_id;
                $h['grupo_id'] = $i->grupo_id;
                $h['materium_id'] = $m->id;
                $h['st_materium_id'] = 0;
                $h['lectivo_id'] = $i->lectivo_id;
                $h['usu_alta_id'] = Auth::user()->id;
                $h['usu_mod_id'] = Auth::user()->id;
                $ha = Hacademica::create($h);
                //$h=new Hacademica;
                //$h->save($h);
                $c['hacademica_id'] = $ha->id;
                $c['tpo_examen_id'] = 1;
                $c['calificacion'] = 0;
                $c['fecha'] = date('Y-m-d');
                $c['reporte_bnd'] = 0;
                $c['usu_alta_id'] = Auth::user()->id;
                $c['usu_mod_id'] = Auth::user()->id;
                $calif = Calificacion::create($c);

                $ponderaciones = CargaPonderacion::where('ponderacion_id', '=', $m->ponderacion_id)
                    ->where('bnd_activo', 1)
                    ->get();
                //dd($ponderaciones);
                foreach ($ponderaciones as $p) {
                    $ponde['calificacion_id'] = $calif->id;
                    $ponde['carga_ponderacion_id'] = $p->id;
                    $ponde['calificacion_parcial'] = 0;
                    $ponde['ponderacion'] = $p->porcentaje;
                    $ponde['usu_alta_id'] = Auth::user()->id;
                    $ponde['usu_mod_id'] = Auth::user()->id;
                    $ponde['tiene_detalle'] = $p->tiene_detalle;
                    $ponde['padre_id'] = $p->padre_id;
                    CalificacionPonderacion::create($ponde);
                }
            }
        }
    }

    public function InscritosSinMateriasLectivo()
    {

        return view('inscripcions.reportes.inscritosSinMateriasLectivo')
            ->with('list', Inscripcion::getListFromAllRelationApps());
    }

    public function InscritosSinMateriasLectivoR(Request $request)
    {
        $data = $request->all();
        //dd($data);
        $plantel = Plantel::find($data['plantel_f']);
        //dd($data);

        try {
            $registros = Inscripcion::select('c.id', DB::raw(' '
                . 'c.nombre, c.nombre2,c.ape_paterno,c.ape_materno,'
                . 'c.beca_bnd, esp.name as especialidad, n.name as nivel, g.name as grado,'
                . 'inscripcions.fec_inscripcion, p.razon as plantel, pe.name as periodo_estudio,'
                . 't.name as turno, pe.name as periodo_estudio, '
                . 'gru.name as grupo, gru.id as gru, stc.id as estatus_cliente_id, stc.name as estatus_cliente, '
                . 'l.name as lectivo'))
                ->join('clientes as c', 'c.id', '=', 'inscripcions.cliente_id')
                ->join('st_clientes as stc', 'stc.id', '=', 'c.st_cliente_id')
                ->join('medios as m', 'm.id', '=', 'c.medio_id')
                ->join('plantels as p', 'p.id', '=', 'inscripcions.plantel_id')
                ->join('especialidads as esp', 'esp.id', '=', 'inscripcions.especialidad_id')
                ->join('nivels as n', 'n.id', '=', 'inscripcions.nivel_id')
                ->join('grados as g', 'g.id', '=', 'inscripcions.grado_id')
                ->join('grupos as gru', 'gru.id', '=', 'inscripcions.grupo_id')
                ->join('turnos as t', 't.id', '=', 'inscripcions.turno_id')
                ->join('lectivos as l', 'l.id', '=', 'inscripcions.lectivo_id')
                ->join('periodo_estudios as pe', 'pe.id', '=', 'inscripcions.periodo_estudio_id')
                //->join('asignacion_academicas as aa', 'aa.materium_id', '=', 'inscripcions.materium_id')
                //->whereColumn('aa.grupo_id', 'inscripcions.grupo_id')
                //->whereColumn('aa.plantel_id', 'inscripcions.plantel_id')
                //->whereColumn('aa.lectivo_id', 'inscripcions.lectivo_id')
                //->join('empleados as e', 'e.id', '=', 'aa.empleado_id')
                ->where('inscripcions.plantel_id', $data['plantel_f'])
                //->whereIn('inscripcions.lectivo_id', $data['lectivo_f'])
                ->whereNull('inscripcions.deleted_at')
                //->whereNull('i.deleted_at')
                //->whereNull('hacademicas.deleted_at')
                //->whereNull('aa.deleted_at')
                //->orderBy('aa.id', 'asc')
                ->orderBy('esp.name', 'asc')
                ->orderBy('gru.id', 'asc')
                ->distinct()
                ->get();
        } catch (Exception $e) {
            dd($e);
        }

        //dd($registros->toArray());

        /*
        PDF::setOptions(['defaultFont' => 'arial']);

        $pdf = PDF::loadView('inscripcions.reportes.lista_calificacionesr', array('registros'=>$registros,'carga_ponderacions_enc'=>$carga_ponderacion))
        ->setPaper('legal', 'landscape');
        return $pdf->download('reporte.pdf');
         */
        $estatus_revisados = array();
        $i = 1;
        foreach ($registros as $registro) {
            //dd($registro);
            if (array_search($estatus_revisados, $registro->estatus_cliente_id) == false) {
                $estatus_revisados[$registro->estatus_cliente_id] = $registro->estatus_cliente;
                //array_push($estatus, array($registro->estatus_cliente, 0));
            }
        }

        return view('inscripcions.reportes.inscritosSinMateriasLectivoR', array(
            'registros' => $registros,
            'plantel' => $plantel,
            'estatus_revisados' => $estatus_revisados,
        ));
    }
}
