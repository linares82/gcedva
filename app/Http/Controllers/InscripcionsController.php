<?php

namespace App\Http\Controllers;

use DB;
use Log;
use Auth;
use Hash;
use App\Mese;
use App\Grado;
use App\Grupo;
use App\Param;
use App\Adeudo;
use App\Cliente;
use App\Lectivo;
use App\Plantel;
use App\Empleado;
use App\Materium;
use App\StCliente;
use App\TpoExamen;
use Carbon\Carbon;
use App\DiaNoHabil;
use App\Hacademica;
use App\AsistenciaR;
use App\Inscripcion;
use App\Ponderacion;
use App\Calificacion;
use App\Especialidad;
use App\PeriodoEstudio;
use App\UsuarioCliente;
use App\CargaPonderacion;
use App\AsignacionAcademica;
use Illuminate\Http\Request;
use App\ConsecutivoMatricula;
use App\ConsultaCalificacion;
use App\ImpresionListaAsisten;
use App\CalificacionPonderacion;
use App\Http\Controllers\Controller;
use App\Http\Requests\createInscripcion;
use App\Http\Requests\updateInscripcion;

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
        $input['st_inscripcion_id'] = 0;

        $plantel = Plantel::find($input['plantel_id']);


        //create data
        $i = Inscripcion::create($input);
        /*
        //Datos para matricula
        $lectivo = Lectivo::find($i->lectivo_id);
        $fecha = Carbon::createFromFormat('Y-m-d', $lectivo->inicio);
        $grado = Grado::find($i->grado_id);
        //dd($especialidad);
        $relleno = "00000";
        $rellenoPlantel = "00";
        $rellenoConsecutivo = "000";

        //dd($consecutivo);
        $cliente = Cliente::where('id', $i->cliente_id)->first();
        
        if ($grado->seccion != "" and $cliente->matricula == "") {
            $consecutivo = ConsecutivoMatricula::where('plantel_id', $i->plantel_id)
                ->where('anio', $fecha->year)
                ->where('mes', $fecha->month)
                ->where('seccion', $grado->seccion)
                ->first();

            if (is_null($consecutivo)) {
                $consecutivo = ConsecutivoMatricula::create(array(
                    'plantel_id' => $i->plantel_id,
                    'mes' => $fecha->month,
                    'anio' => $fecha->year,
                    'seccion' => $grado->seccion,
                    'consecutivo' => 1,
                    'usu_alta_id' => 1,
                    'usu_mod_id' => 1,
                ));
            } else {
                $consecutivo->consecutivo = $consecutivo->consecutivo + 1;
                $consecutivo->save();
            }
            $mes = substr($rellenoPlantel, 0, 2 - strlen($fecha->month)) . $fecha->month;
            $anio = $fecha->year - 2000;
            $plantel = substr($rellenoPlantel, 0, 2 - strlen($i->plantel_id)) . $i->plantel_id;
            $seccion = substr($relleno, 0, 5 - strlen($grado->seccion)) . $grado->seccion;
            $consecutivoCadena = substr($rellenoConsecutivo, 0, 3 - strlen($consecutivo->consecutivo)) . $consecutivo->consecutivo;

            $entrada['matricula'] = $mes . $anio . $seccion . $plantel . $consecutivoCadena;
            //$i->update($entrada);

            $cliente->matricula = $entrada['matricula'];
            $cliente->save();

            if (!is_null($cliente->matricula)) {
                $buscarMatricula = UsuarioCliente::find('name', $input['matricula'])->first();
                $buscarMail = UsuarioCliente::where('email', $input['mail'])->first();
                if (is_null($buscarMatricula) and is_null($buscarMail)) {
                    $usuario_cliente['name'] = $cliente->matricula;
                    $usuario_cliente['email'] = $cliente->mail;
                    $usuario_cliente['password'] = Hash::make('123456');
                    UsuarioCliente::create($usuario_cliente);
                }
            }
        }*/

        $combinacion = \App\CombinacionCliente::find($i->combinacion_cliente_id);
        if (!is_null($combinacion) > 0) {
            $combinacion->plantel_id = $i->plantel_id;
            if ($combinacion->plantel_id != $i->plantel_id) {
                $cliente = Cliente::find($combinacion->cliente_id);
                $cliente->plantel_id = $i->plantel_id;
                $cliente->save();
                $combinacion->especialidad_id = $i->especialidad_id;
                $combinacion->nivel_id = $i->nivel_id;
                $combinacion->grado_id = $i->grado_id;
                $combinacion->save();

                //$cliente=Cliente::
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
                $h['fec_inscripcion'] = $i->fec_inscripcion;
                $h['turno_id'] = $i->turno_id;
                $h['periodo_estudio_id'] = $i->periodo_estudio_id;
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
                    $h['fec_inscripcion'] = $i->fec_inscripcion;
                    $h['turno_id'] = $i->turno_id;
                    $h['periodo_estudio_id'] = $i->periodo_estudio_id;
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
            if (!is_null($combinacion) > 0) {
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
        if ($inscripcion->hacademicas()->coubnt() > 0) {
            foreach ($inscripcion->hacademicas() as $materia) {
                $materia->delete();
            }
        }
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
        $empleado = Empleado::where('user_id', Auth::user()->id)->first();
        $planteles = $empleado->plantels->pluck('razon', 'id');
        return view('inscripcions.reinscripcion', compact('planteles'))
            ->with('list', Inscripcion::getListFromAllRelationApps());
    }

    public function postReinscripcion(Request $request)
    {
        //dd('fil');
        $input = $request->all();

        $empleado = Empleado::where('user_id', Auth::user()->id)->first();
        $planteles = $empleado->plantels->pluck('razon', 'id');
        $bloqueo_materias_desaprobadas = Param::where('llave', 'bloqueo_materias_desaprobadas')->first();

        $grado = Grado::find($input['grado_id']);

        if (isset($input['id']) and isset($input['grupo_to']) and isset($input['lectivo_to'])) {

            foreach ($input['id'] as $key => $value) {
                $id = $value;
                $posicion = $key;
                $i = Inscripcion::find($id);
                $plantel_anterior = $i->plantel_id;
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
                $i->st_inscripcion_id = 1;
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
                ->join('grados as g', 'g.id', 'h.grado_id')
                ->leftJoin('duracion_periodos as dp', 'dp.id', 'g.duracion_periodo_id')
                ->select(
                    'i.id',
                    'clientes.id as cliente',
                    'p.name as periodo_estudio',
                    'st_cliente_id',
                    'h.grado_id',
                    'dp.id as duracion_periodo_id',
                    'dp.name as duracion_periodo',
                    'dp.bloqueo_cantidad_reprobadas',
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
            //dd($clientes->toArray());
            $resultado = collect();
            $resultados = collect();
            foreach ($clientes as $c) {
                //dd($c);
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
                    'duracion_periodo' => $c->duracion_periodo,
                    'duracion_periodo_id' => $c->duracion_periodo_id,
                    'bloqueo_cantidad_reprobadas' => $c->bloqueo_cantidad_reprobadas,
                    'aprobadas' => $aprobadas->aprobadas,
                    'no_aprobadas' => $contar_materias_no_aprobadas,
                    'aprobadas_modulo' => $aprobadas_modulo,
                    'no_aprobadas_modulo' => $no_aprobadas_modulo,
                ]);
            }
        }

        //dd($clientes->toArray());
        //dd($resultados->toArray());
        return view('inscripcions.reinscripcion', compact('resultados', 'input', 'planteles', 'bloqueo_materias_desaprobadas'))
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
            ->orderBy('c.nombre')
            ->orderBy('c.nombre2')

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
            if (in_array('Domingo', $dias)) {

                if ($pinicio->isSunday() and !in_array($pinicio, $no_habiles)) {
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
            ->whereIn('s.st_seguimiento_id', array(2, 5, 7, 9))
            ->whereIn('c.st_cliente_id', array(4, 25, 20, 30, 31))
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
        $plantel = $asignacion->plantel;
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
            'plantel_id' => $plantel->id,
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
            ->orderBy('c.ape_paterno')
            ->orderBy('c.ape_materno')
            ->orderBy('c.nombre')
            ->orderBy('c.nombre2')
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
            if (in_array('Domingo', $dias)) {

                if ($pinicio->isSunday() and !in_array($pinicio, $no_habiles)) {
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
        $cliente = Cliente::find($inscripcion->cliente_id);
        if ($cliente->matricula == "") {
            dd("Cliente sin matricula, no se puede emitir historial");
        }
        $plantel = Plantel::find($inscripcion->plantel_id);
        $grado = Grado::find($inscripcion->grado_id);
        $resultados = array();
        $fecha_lectivo_fin = carbon::createFromFormat('Y-m-d', $inscripcion->lectivo->fin);
        $hoy = carbon::createFromFormat('Y-m-d', date('Y-m-d'));
        if ($fecha_lectivo_fin->lessThanOrEqualTo($hoy)) {
            $hacademicas = Hacademica::select(
                'm.name as materia',
                'm.bnd_tiene_nombre_oficial',
                'm.nombre_oficial',
                'm.codigo',
                'm.creditos',
                'l.name as lectivo',
                'hacademicas.id',
                'hacademicas.materium_id',
                //'hacademicas.cliente_id'
            )
                ->join('lectivos as l', 'l.id', '=', 'hacademicas.lectivo_id')
                ->join('materia as m', 'm.id', '=', 'hacademicas.materium_id')
                ->join('periodo_estudios as pe', 'pe.id', '=', 'hacademicas.periodo_estudio_id')
                ->where('cliente_id', $inscripcion->cliente_id)
                ->whereNull('hacademicas.deleted_at')
                ->with('cliente')
                //->orderBy('pe.orden')
                ->orderBy('l.id')
                ->orderBy('m.codigo')
                //->orderBy('m.orden')
                //->orderBy('hacademicas.id')
                ->get();
        } else {
            $hacademicas = Hacademica::select(
                'm.name as materia',
                'm.bnd_tiene_nombre_oficial',
                'm.nombre_oficial',
                'm.codigo',
                'm.creditos',
                'l.name as lectivo',
                'hacademicas.id',
                'hacademicas.materium_id',
                //'hacademicas.cliente_id'
            )
                ->join('lectivos as l', 'l.id', '=', 'hacademicas.lectivo_id')
                ->join('materia as m', 'm.id', '=', 'hacademicas.materium_id')
                ->where('cliente_id', $inscripcion->cliente_id)
                ->whereNull('hacademicas.deleted_at')
                ->whereDate('l.fin', '<', $fecha_lectivo_fin->toDateString())
                ->with('cliente')
                //->orderBy('hacademicas.id')
                ->orderBy('l.id')
                ->orderBy('m.codigo')
                ->get();
        }
        //dd($hacademicas->toArray()); 8

        $consulta_calificaciones = ConsultaCalificacion::where('matricula', 'like', "%" . $cliente->matricula . "%")->get();
        //dd($consulta_calificaciones->count()); 

        foreach ($consulta_calificaciones as $c) {
            array_push($resultados, array(
                'materia' => $c->materia,
                'codigo' => $c->codigo,
                'creditos' => $c->creditos,
                'lectivo' => $c->lectivo,
                'calificacion' => $c->calificacion,
                'tipo_examen' => $c->tipo_examen,
                'materia_id' => ""
            ));
        }
        //dd(count($resultados));

        foreach ($hacademicas as $hacademica) {
            $tpo_examen_max = Calificacion::where('hacademica_id', $hacademica->id)->max('tpo_examen_id');
            $calificacion = Calificacion::select('calificacions.calificacion', 'te.name as tipo_examen')
                ->join('tpo_examens as te', 'te.id', 'calificacions.tpo_examen_id')
                ->where('hacademica_id', $hacademica->id)
                ->where('tpo_examen_id', $tpo_examen_max)
                ->first();

            $resultado = array(
                'materia' => $hacademica->materia,
                'bnd_tiene_nombre_oficial' => $hacademica->bnd_tiene_nombre_oficial,
                'nombre_oficial' => $hacademica->nombre_oficial,
                'codigo' => $hacademica->codigo,
                'creditos' => $hacademica->creditos,
                'lectivo' => $hacademica->lectivo,
                'calificacion' => $calificacion->calificacion,
                'tipo_examen' => $calificacion->tipo_examen,
                'materia_id' => $hacademica->materium_id
            );
            //dd($resultado);
            array_push($resultados, $resultado);
        }
        //dd(count($resultados));

        $total_creditos = 0;
        $suma_calificaciones = 0;
        $total_materias = 0;
        //dd($resultados[9]);
        $rechazados = array();
        foreach ($resultados as $resultado) {
            if (strval($resultado['calificacion']) >= 6) {
                Log::info($resultado['creditos']);
                $total_creditos = $total_creditos + trim($resultado['creditos']);
                $suma_calificaciones = $suma_calificaciones + $resultado['calificacion'];
                $total_materias = $total_materias + 1;
            } else {
                $r = $this->existeMateriaAprobadaPosterior($resultado['codigo'], $resultados);
                if (!$r) {
                    //dd($resultado['codigo']);
                    $total_creditos = $total_creditos + $resultado['creditos'];
                    $suma_calificaciones = $suma_calificaciones + $resultado['calificacion'];
                    $total_materias = $total_materias + 1;
                } else {
                    array_push($rechazados, $resultado);
                }
            }
        }
        //dd($consulta_calificaciones->toArray());
        //dd($rechazados);
        /*return view('inscripcions.reportes.lista_alumnosr',compact('registros'))
        ->with( 'list', Inscripcion::getListFromAllRelationApps() );
         * */

        /*                PDF::setOptions(['defaultFont' => 'arial']);

        $pdf = PDF::loadView('inscripcions.reportes.lista_alumnosr', array('registros'=>$registros,'fechas_enc'=>$fechas))
        ->setPaper('legal', 'landscape');
        return $pdf->download('reporte.pdf');
        
         */


        return view(
            'inscripcions.reportes.historial',
            compact('inscripcion', 'cliente', 'plantel', 'grado', 'consulta_calificaciones', 'total_materias', 'total_creditos', 'suma_calificaciones')
        )
            ->with('hacademicas', $resultados);
    }

    public function existeMateriaAprobadaPosterior($codigo, $matriz)
    {
        //dd($matriz); //744
        $resultado = false;
        $matriz_invertida = array_reverse($matriz);
        //dd($matriz_invertida);
        $r = array_search($codigo, array_column($matriz_invertida, 'codigo'));
        //dd($r); //18
        if (strval($matriz_invertida[$r]['calificacion']) >= 6)
            $resultado = true;
        return $resultado;
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
        $egresados = Cliente::select('i.created_at', 'clientes.id')
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
        dd($egresados->toArray());
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
        $egresados = Cliente::select('i.created_at', 'clientes.id', 'g.nombre2 as grado', 'e.ccte')
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
            //->where('id',4095)
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
                ->where('hacademicas.plantel_id', $asignacion->plantel_id)
                ->where('hacademicas.lectivo_id', $asignacion->lectivo_id)
                ->where('hacademicas.grupo_id', $asignacion->grupo_id)
                //->where('inscripcions.grado_id ',$asignacion->grado_id)
                //->where('aa.id', $asignacion->id)
                //->where('aa.plantel_id', $asignacion->plantel_id)
                //->where('aa.lectivo_id', $asignacion->lectivo_id)
                //->where('aa.grupo_id', $asignacion->grupo_id)
                //->where('aa.empleado_id', $asignacion->empleado_id)
                //->where('aa.materium_id', $asignacion->materium_id)
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
            //dd($total_alumnos);41

            //Log::info("FIL-".$asignacion->id."-".$total_alumnos);

            //dd($registros->toArray());

            //Agregar fechas
            //$asignacion = AsignacionAcademica::find($data['asignacion']);

            $dias = array();
            $dias_numero_validos = array();
            //dd($asignacion);
            foreach ($asignacion->horarios as $horario) {
                array_push($dias, $horario->dia->name);
                array_push($dias_numero_validos, $horario->dia_id);
            }
            //dd($dias_numero_validos);

            $fechas = array();
            $lectivo = Lectivo::find($data['lectivo_f']);
            //dd($lectivo);
            $no_habiles = array();
            $no_habilesNoCarbon = array();
            $diasNoHabiles = DiaNoHabil::distinct()
                ->where('fecha', '>=', $lectivo->inicio)
                ->where('fecha', '<=', $lectivo->fin)
                ->get();
            if (count($diasNoHabiles) > 0) {
                foreach ($diasNoHabiles as $no_habil) {
                    array_push($no_habiles, Carbon::createFromFormat('Y-m-d', $no_habil->fecha));
                    array_push($no_habilesNoCarbon, $no_habil->fecha);
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
                if (in_array('Domingo', $dias)) {

                    if ($pinicio->isSunday() and !in_array($pinicio, $no_habiles)) {
                        array_push($fechas, $pinicio->toDateString());
                        $total_asistencias++;
                    }
                }

                $pinicio->addDay();
                //dd($fechas);
            }
            //dd($fechas);6
            $asistencias_planeadas = 0;
            foreach ($fechas as $fecha) {
                $asistencias_planeadas++;
            }
            //dd($asistencias_planeadas); //6

            foreach ($registros as $r) {
                /*if($loop==1){
                Log::info("FLC-" . $asignacion->id . "-" . $total_alumnos);
                }*/
                $cadena_fechas_planeadas = "";
                $longitud = count($fechas);
                foreach ($fechas as $i => $fecha) {
                    //dd($i);
                    if ($i == $longitud - 1) {
                        //dd($i);
                        $cadena_fechas_planeadas = $cadena_fechas_planeadas . "'" . $fecha . "'";
                    } else {
                        $cadena_fechas_planeadas = $cadena_fechas_planeadas . "'" . $fecha . "', ";
                    }
                }
                $cadena = 'fecha in (' . $cadena_fechas_planeadas . ')';
                //dd($no_habiles);
                $asistencias_reales_aux = \App\AsistenciaR::where('asignacion_academica_id', $asignacion->id)
                    ->where('cliente_id', $r->cliente)
                    ->whereIn('est_asistencia_id', array(1, 4))
                    ->whereNotIn('cliente_id', [0, 2])
                    ->where('fecha', '>=', $data['fecha_f'])
                    ->where('fecha', '<=', $data['fecha_t'])
                    ->whereNotIn('fecha', $no_habilesNoCarbon)
                    //->whereRaw($cadena)	
                    //->count();
                    ->get();
                //dd($asistencias_reales_aux->toArray());
                $asistencias_reales = 0;
                foreach ($asistencias_reales_aux as $asistencia_real) {
                    $dia_carbon = Carbon::createFromFormat('Y-m-d', $asistencia_real->fecha);
                    if (in_array($dia_carbon->dayOfWeekIso, $dias_numero_validos)) {
                        $asistencias_reales++;
                    }
                }

                //dd($asistencias_planeadas ." - ".$asistencias_reales);
                if ($asistencias_planeadas == 0) {
                    dd("Asignacion con materia sin fechas de horario asignadas: " . $asignacion->id);
                }
                $promedio_cliente = ($asistencias_reales * 100) / $asistencias_planeadas;
                //Log::info('Promedio-'.$promedio_cliente);
                $contador_clientes++;
                $contador_clientes_asignacion++;
                $sumatoria_promedio_clientes_asignacion = $sumatoria_promedio_clientes_asignacion + $promedio_cliente;
                $sumatoria_promedio_clientes = $sumatoria_promedio_clientes + $promedio_cliente;
            }
            //dd($sumatoria_promedio_clientes_asignacion." - ".$contador_clientes_asignacion);
            if ($contador_clientes_asignacion > 0) {
                $resul = $sumatoria_promedio_clientes_asignacion / $contador_clientes_asignacion;
            } else {
                $resul = "Sin clientes";
            }

            array_push($resumen, array(
                'asignacion' => $asignacion->id,
                'plantel' => $asignacion->plantel->razon,
                'instructor' => $asignacion->empleado->nombre . ' ' . $asignacion->empleado->ape_paterno . ' ' . $asignacion->empleado->ape_materno,
                'materia' => optional($asignacion->materia)->name,
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
            //dd($registros);
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
                if (in_array('Domingo', $dias)) {

                    if ($pinicio->isSunday() and !in_array($pinicio, $no_habiles)) {
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
                if (in_array('Domingo', $dias)) {

                    if ($pinicio->isSunday() and !in_array($pinicio, $no_habiles)) {
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
                $h['fec_inscripcion'] = $i->fec_inscripcion;
                $h['turno_id'] = $i->turno_id;
                $h['periodo_estudio_id'] = $i->periodo_estudio_id;
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
                    $h['fec_inscripcion'] = $i->fec_inscripcion;
                    $h['turno_id'] = $i->turno_id;
                    $h['periodo_estudio_id'] = $i->periodo_estudio_id;
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
    }

    public function InscritosSinMateriasLectivo()
    {
        $empleado = Empleado::where('user_id', Auth::user()->id)->first();
        $planteles = $empleado->plantels->pluck('razon', 'id');

        return view('inscripcions.reportes.inscritosSinMateriasLectivo', compact('planteles'))
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
                . 'l.name as lectivo, c.matricula, c.tel_cel'))
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
                ->whereIn('inscripcions.lectivo_id', $data['lectivo_f'])
                //->whereIn('inscripcions.especialidad_id', $data['especialidad_f'])
                ->whereNull('inscripcions.deleted_at')
                //->whereNull('i.deleted_at')
                //->whereNull('hacademicas.deleted_at')
                //->whereNull('aa.deleted_at')
                //->orderBy('aa.id', 'asc')
                ->orderBy('esp.name', 'asc')
                ->orderBy('gru.id', 'asc')
                ->orderBy('c.ape_paterno', 'asc')
                ->orderBy('c.ape_materno', 'asc')
                ->orderBy('c.nombre', 'asc')
                ->orderBy('c.nombre2', 'asc')
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
            if (array_search($registro->estatus_cliente_id, $estatus_revisados) == false) {
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

    public function inscritosActivosPlantel()
    {
        $empleado = Empleado::where('user_id', Auth::user()->id)->first();
        //dd($empleado);
        $planteles_activos = $empleado->plantels->pluck('razon', 'id');

        return view('inscripcions.reportes.inscritosActivosPlantel', compact('planteles_activos'))
            ->with('list', Inscripcion::getListFromAllRelationApps());
    }

    public function inscritosActivosPlantelR(Request $request)
    {
        $datos = $request->all();
        $registros = Inscripcion::select('p.razon', 'gra.name as grado', 'g.name as grupo', DB::raw('count("name") as total'))
            ->join('plantels as p', 'p.id', '=', 'inscripcions.plantel_id')
            ->join('grupos as g', 'g.id', '=', 'inscripcions.grupo_id')
            ->join('grados as gra', 'gra.id', '=', 'inscripcions.grado_id')
            ->join('clientes as c', 'c.id', '=', 'inscripcions.cliente_id')
            ->whereNull('inscripcions.deleted_at')
            ->whereIn('inscripcions.plantel_id', $datos['plantel_f'])
            ->whereIn('c.st_cliente_id', array(1, 2, 4, 22, 23))
            ->groupBy('p.razon')
            ->groupBy('grupo')
            ->groupBy('grado')
            ->get();
        //dd($registros);
        return view('inscripcions.reportes.inscritosActivosPlantelR', compact('registros'));
    }

    public function certificados(Request $request)
    {
        $datos = $request->all();
        if (
            isset($datos['plantel_f']) and
            isset($datos['especialidad_f']) and
            isset($datos['nivel_f']) and
            isset($datos['grado_f']) and
            isset($datos['lectivo_f'])
        ) {
            $registros = Inscripcion::where('plantel_id', $datos['plantel_f'])
                ->where('especialidad_id', $datos['especialidad_f'])
                ->where('nivel_id', $datos['nivel_f'])
                ->where('grado_id', $datos['grado_f'])
                ->where('lectivo_id', $datos['lectivo_f'])
                ->distinct()
                ->get();
        }

        return view('inscripcions.reportes.certificados', compact('planteles_validos'));
    }

    public function certificadosR()
    {

        return view('inscripcions.reportes.certificadosR', compact('$registros'));
    }

    public function grupoAsignatura()
    {
        //dd('flc');
        $empleado = Empleado::where('user_id', Auth::user()->id)->first();
        $planteles_validos = $empleado->plantels->pluck('razon', 'id');
        return view('inscripcions.reportes.grupoAsignatura', compact('planteles_validos'))
            ->with('list', Inscripcion::getListFromAllRelationApps());
    }

    public function grupoAsignaturaR(Request $request)
    {
        $datos = $request->all();
        //dd($datos);
        $registros = Hacademica::select(
            'gra.rvoe',
            'l.ciclo_escolar',
            'l.periodo_escolar',
            'c.curp',
            'm.orden',
            'g.name',
            DB::raw('substr(g.name,-1) as grupo_letra, substr(g.name,1,1) as grupo_numero')
        )
            ->join('grupos as g', 'g.id', '=', 'hacademicas.grupo_id')
            ->join('clientes as c', 'c.id', '=', 'hacademicas.cliente_id')
            ->join('grados as gra', 'gra.id', '=', 'hacademicas.grado_id')
            ->join('lectivos as l', 'l.id', '=', 'hacademicas.lectivo_id')
            ->where('hacademicas.plantel_id', $datos['plantel_f'])
            ->join('materia as m', 'm.id', '=', 'hacademicas.materium_id')
            ->where('lectivo_id', $datos['lectivo_f'])
            ->whereNull('hacademicas.deleted_at')
            ->where('m.bnd_oficial', 1)
            //->with('cliente')
            //->with('grupo')
            //->with('lectivo')
            //->with('grado')
            ->distinct()
            ->orderBy('g.name')
            ->orderBy('m.orden')
            ->orderBy('c.curp')
            ->get();
        //dd($registros);
        return view('inscripcions.reportes.grupoAsignaturaR', compact('registros', 'datos'));
    }

    public function inscripcionReinscripcion()
    {

        $empleado = Empleado::where('user_id', Auth::user()->id)->first();
        $planteles_validos = $empleado->plantels->pluck('razon', 'id');
        return view('inscripcions.reportes.inscripcionReinscripcion', compact('planteles_validos'))
            ->with('list', Inscripcion::getListFromAllRelationApps());
    }

    public function inscripcionReinscripcionR(Request $request)
    {
        $datos = $request->all();

        $empleado = Empleado::where('user_id', Auth::user()->id)->first();
        $planteles = $empleado->plantels->pluck('razon', 'id');
        /*$registros = Inscripcion::select(
            'inscripcions.*',
            DB::raw('substr(cli.matricula,1,4) as mesAnioMatricula')
           
        )
            ->join('clientes as cli', 'cli.id', '=', 'inscripcions.cliente_id')
            ->where('inscripcions.plantel_id', $datos['plantel_f'])
            ->where('inscripcions.lectivo_id', $datos['lectivo_f'])
            ->whereNull('inscripcions.deleted_at')
            ->with('cliente')
            ->with('grupo')
            ->with('lectivo')
            ->with('grado')
            ->orderBy('inscripcions.st_inscripcion_id')
            ->get();
            */
        $registros = Inscripcion::select(
            'g.rvoe',
            'l.ciclo_escolar',
            'l.periodo_escolar',
            'g.id_mapa',
            'cli.curp',
            'h.plantel_id',
            'h.cliente_id',
            'l.inicio',
            'inscripcions.st_inscripcion_id',
            'cli.nombre',
            'cli.nombre2',
            'cli.ape_paterno',
            'cli.ape_materno',
            'cli.fec_nacimiento',
            'cli.genero',
            'cli.estado_nacimiento_id',
            'cli.bnd_trabaja',
            'cli.bnd_indigena',
            'd.clave as discapacidad_clave',
            'l.id as lectivo_id',
            DB::raw('substr(cli.matricula,1,4) as mesAnioMatricula'),
            'gru.name as grupo'
        )
            ->join('hacademicas as h', 'h.inscripcion_id', 'inscripcions.id')
            ->join('grupos as gru', 'gru.id', 'h.grupo_id')
            ->join('grados as g', 'g.id', 'h.grado_id')
            ->join('lectivos as l', 'l.id', 'h.lectivo_id')
            ->join('clientes as cli', 'cli.id', '=', 'inscripcions.cliente_id')
            ->leftJoin('discapacidads as d', 'd.id', 'cli.discapacidad_id')
            ->where('h.plantel_id', $datos['plantel_f'])
            ->where('h.lectivo_id', $datos['lectivo_f'])
            ->whereNull('inscripcions.deleted_at')
            ->whereNull('h.deleted_at')
            ->orderBy('inscripcions.st_inscripcion_id')
            ->orderBy('gru.name')
            ->orderBy('cli.ape_paterno')
            ->orderBy('cli.ape_materno')
            ->orderBy('cli.nombre')
            ->orderBy('cli.nombre2')
            ->distinct()
            ->get();


        //dd($registros->toArray());

        return view('inscripcions.reportes.inscripcionReinscripcionR', compact('registros', 'planteles'))
            ->with('list', Inscripcion::getListFromAllRelationApps());
    }

    public function evaluacionOE()
    {
        $empleado = Empleado::where('user_id', Auth::user()->id)->first();
        $planteles_validos = $empleado->plantels->pluck('razon', 'id');
        $tipoEvaluacion = TpoExamen::where('id', '>', 0)->pluck('name', 'id');
        return view('inscripcions.reportes.evaluacionOE', compact('planteles_validos', 'tipoEvaluacion'))
            ->with('list', Inscripcion::getListFromAllRelationApps());
    }

    public function evaluacionOER(Request $request)
    {
        $datos = $request->all();
        //dd($datos);
        if ($datos['tipo_examen_f'] == 1) {
            $registros = Hacademica::select(
                'p.razon',
                'l.ciclo_escolar',
                'l.periodo_escolar',
                'l.name as lectivo',
                'g.rvoe',
                'g.name as grado',
                'cli.curp',
                'cli.id as cliente',
                'te.name as tipo_examen',
                'e.curp as curp_docente',
                'gru.name as grupo',
                'm.codigo',
                'c.calificacion',
                'c.id as calificacion_id',
                DB::raw('substr(gru.name, 1,1) as grupo_numero, substr(gru.name, -1) as grupo_letra'),
                'm.orden',
                'af.consecutivo as consecutivo_acta',
                'af.fecha as fecha_acta',
                'af.plantel_id',
                'af.plantel_id',
                'l.fin'
            )
                ->join('inscripcions as i', 'i.id', '=', 'hacademicas.inscripcion_id')
                ->join('asignacion_academicas as aa', 'aa.plantel_id', '=', 'hacademicas.plantel_id')
                ->whereColumn('aa.grupo_id', 'hacademicas.grupo_id')
                ->whereColumn('aa.lectivo_id', 'hacademicas.lectivo_id')
                ->whereColumn('aa.materium_id', 'hacademicas.materium_id')
                ->join('plantels as p', 'p.id', 'i.plantel_id')
                ->join('empleados as e', 'e.id', '=', 'aa.docente_oficial_id')
                ->join('calificacions as c', 'c.hacademica_id', '=', 'hacademicas.id')
                ->leftJoin('acta_finals as af', 'af.id', '=', 'c.acta_final_id')
                ->join('tpo_examens as te', 'te.id', '=', 'c.tpo_examen_id')
                ->join('grados as g', 'g.id', '=', 'hacademicas.grado_id')
                ->join('lectivos as l', 'l.id', '=', 'aa.lectivo_oficial_id')
                ->join('grupos as gru', 'gru.id', '=', 'hacademicas.grupo_id')
                ->join('clientes as cli', 'cli.id', '=', 'hacademicas.cliente_id')
                ->join('materia as m', 'm.id', '=', 'hacademicas.materium_id')
                ->where('m.bnd_oficial', 1)
                ->where('c.tpo_examen_id', $datos['tipo_examen_f'])
                ->where('hacademicas.plantel_id', $datos['plantel_f'])
                ->where('aa.lectivo_oficial_id', $datos['lectivo_f'])
                //->where('aa.lectivo_id', $datos['lectivo_f'])
                ->whereNull('hacademicas.deleted_at')
                ->whereNull('i.deleted_at')
                ->whereNull('aa.deleted_at')
                ->orderBy('gru.name')
                ->orderBy('m.orden')
                ->orderBy('cli.curp')
                ->get();
        } elseif ($datos['tipo_examen_f'] == 2) {
            $registros = Hacademica::select(
                'p.razon',
                'l.ciclo_escolar',
                'l.periodo_escolar',
                'l.name as lectivo',
                'g.rvoe',
                'g.name as grado',
                'cli.curp',
                'te.name as tipo_examen',
                'e.curp as curp_docente',
                'cli.id as cliente',
                'gru.name as grupo',
                'm.codigo',
                'c.calificacion',
                'c.id as calificacion_id',
                DB::raw('substr(gru.name, 1,1) as grupo_numero, substr(gru.name, -1) as grupo_letra'),
                'm.orden',
                'af.consecutivo as consecutivo_acta',
                'af.plantel_id',
                'af.fecha as fecha_acta',
                'l.fin'
            )
                ->join('inscripcions as i', 'i.id', '=', 'hacademicas.inscripcion_id')
                ->join('asignacion_academicas as aa', 'aa.plantel_id', '=', 'hacademicas.plantel_id')
                ->whereColumn('aa.grupo_id', 'hacademicas.grupo_id')
                ->whereColumn('aa.lectivo_id', 'hacademicas.lectivo_id')
                ->whereColumn('aa.materium_id', 'hacademicas.materium_id')
                ->join('plantels as p', 'p.id', 'i.plantel_id')
                ->join('empleados as e', 'e.id', '=', 'aa.docente_oficial_id')
                ->join('calificacions as c', 'c.hacademica_id', '=', 'hacademicas.id')
                ->leftJoin('acta_finals as af', 'af.id', '=', 'c.acta_final_id')
                ->join('tpo_examens as te', 'te.id', '=', 'c.tpo_examen_id')
                ->join('grados as g', 'g.id', '=', 'hacademicas.grado_id')
                ->join('lectivos as l', 'l.id', '=', 'c.lectivo_id')
                ->join('grupos as gru', 'gru.id', '=', 'hacademicas.grupo_id')
                ->join('clientes as cli', 'cli.id', '=', 'hacademicas.cliente_id')
                ->join('materia as m', 'm.id', '=', 'hacademicas.materium_id')
                ->where('m.bnd_oficial', 1)
                ->where('c.calificacion', '>=', 6)
                ->where('c.tpo_examen_id', $datos['tipo_examen_f'])
                ->where('hacademicas.plantel_id', $datos['plantel_f'])
                ->where('c.lectivo_id', $datos['lectivo_f'])
                ->whereNull('hacademicas.deleted_at')
                ->whereNull('i.deleted_at')
                ->orderBy('gru.name')
                ->orderBy('m.orden')
                ->orderBy('cli.curp')
                ->get();
        }
        $idCalificacionesArray = array();
        $fecha_acta = "";
        foreach ($registros as $registro) {
            array_push($idCalificacionesArray, $registro->calificacion_id);
            $fecha_acta = $registro->fecha_acta;
            //Log::info('fecha_acta: '.$registro->fecha_acta);
        }
        //dd($registros->toArray());

        return view('inscripcions.reportes.evaluacionOER', compact('registros', 'datos', 'idCalificacionesArray', 'fecha_acta'));
    }

    public function historialOficial(Request $request)
    {
        $datos = $request->all();
        $inscripcion = Inscripcion::find($datos['inscripcion']);

        $cliente = Cliente::find($inscripcion->cliente_id);
        //dd($cliente->toArray());
        $plantel = Plantel::find($inscripcion->plantel_id);
        $grado = Grado::find($inscripcion->grado_id);
        $resultados = array();
        //dd($inscripcion->toArray());
        $fecha_lectivo_fin = carbon::createFromFormat('Y-m-d', $inscripcion->lectivo->fin);
        $hoy = carbon::createFromFormat('Y-m-d', date('Y-m-d'));
        if ($fecha_lectivo_fin->lessThanOrEqualTo($hoy)) {
            $hacademicas = Hacademica::select(
                'm.name as materia',
                'm.bnd_tiene_nombre_oficial',
                'm.nombre_oficial',
                'm.codigo',
                'm.creditos',
                'l.name as lectivo',
                'hacademicas.id',
                'hacademicas.cliente_id'
                //'c.calificacion',
                //'te.id',
                //'te.name as tipo_examen'
            )
                ->join('lectivos as l', 'l.id', '=', 'hacademicas.lectivo_id')
                //->join('grados as g', 'g.id', '=', 'hacademicas.grado_id')
                ->join('materia as m', 'm.id', '=', 'hacademicas.materium_id')
                //->join('calificacions as c', 'c.hacademica_id', 'hacademicas.id')
                //->join('tpo_examens as te', 'te.id', '=', 'c.tpo_examen_id')
                ->join('periodo_estudios as pe', 'pe.id', '=', 'hacademicas.periodo_estudio_id')
                ->where('cliente_id', $inscripcion->cliente_id)
                ->where('m.bnd_oficial', 1)
                ->whereNull('hacademicas.deleted_at')
                //->whereNull('c.deleted_at')
                ->with('cliente')
                //->orderBy('hacademicas.id')
                //->orderBy('pe.orden')
                ->orderBy('l.id')
                ->orderBy('m.codigo')
                //->orderBy('m.orden')
                //->orderBy('te.id')
                ->get();
        } else {
            $hacademicas = Hacademica::select(
                'm.name as materia',
                'm.bnd_tiene_nombre_oficial',
                'm.nombre_oficial',
                'm.codigo',
                'm.creditos',
                'l.name as lectivo',
                'hacademicas.id',
                'hacademicas.cliente_id'
                //'c.calificacion',
                //'te.id',
                //'te.name as tipo_examen'
            )
                ->join('lectivos as l', 'l.id', '=', 'hacademicas.lectivo_id')
                //->join('grados as g', 'g.id', '=', 'hacademicas.grado_id')
                ->join('materia as m', 'm.id', '=', 'hacademicas.materium_id')
                //->join('calificacions as c', 'c.hacademica_id', 'hacademicas.id')
                //->join('tpo_examens as te', 'te.id', '=', 'c.tpo_examen_id')
                ->where('cliente_id', $inscripcion->cliente_id)
                ->whereDate('l.fin', '<', $fecha_lectivo_fin->toDateString())
                ->where('m.bnd_oficial', 1)
                ->whereNull('hacademicas.deleted_at')
                //->whereNull('c.deleted_at')
                ->with('cliente')
                //->orderBy('hacademicas.id')
                ->orderBy('l.id')
                ->orderBy('m.codigo')
                //->orderBy('te.id')
                ->get();
        }
        //dd($hacademicas->toArray());
        foreach ($hacademicas as $hacademica) {
            $tpo_examen_max = Calificacion::where('hacademica_id', $hacademica->id)->max('tpo_examen_id');
            $calificacion = Calificacion::select('calificacions.calificacion', 'te.name as tipo_examen')
                ->join('tpo_examens as te', 'te.id', 'calificacions.tpo_examen_id')
                ->where('hacademica_id', $hacademica->id)
                ->where('tpo_examen_id', $tpo_examen_max)
                ->first();
            $resultado = array(
                'materia' => $hacademica->materia,
                'codigo' => $hacademica->codigo,
                'bnd_tiene_nombre_oficial' => $hacademica->bnd_tiene_nombre_oficial,
                'nombre_oficial' => $hacademica->nombre_oficial,
                'creditos' => $hacademica->creditos,
                'lectivo' => $hacademica->lectivo,
                'calificacion' => $calificacion->calificacion,
                'tipo_examen' => $calificacion->tipo_examen,
            );
            //dd($resultado);
            array_push($resultados, $resultado);
        }
        //dd($resultados);
        $consulta_calificaciones = ConsultaCalificacion::where('matricula', 'like', "%" . $cliente->matricula . "%")->get();
        //dd($consulta_calificaciones);
        //dd($inscripcion);
        /*return view('inscripcions.reportes.lista_alumnosr',compact('registros'))
        ->with( 'list', Inscripcion::getListFromAllRelationApps() );
         * */

        /*                PDF::setOptions(['defaultFont' => 'arial']);

        $pdf = PDF::loadView('inscripcions.reportes.lista_alumnosr', array('registros'=>$registros,'fechas_enc'=>$fechas))
        ->setPaper('legal', 'landscape');
        return $pdf->download('reporte.pdf');
         */
        return view('inscripcions.reportes.historialOficial', compact('inscripcion', 'cliente', 'plantel', 'grado', 'consulta_calificaciones'))->with('hacademicas', $resultados);
    }

    public function inspeccionVigilancia()
    {
        $empleado = Empleado::where('user_id', Auth::user()->id)->first();
        $planteles = $empleado->plantels->pluck('razon', 'id');
        $lectivos = Lectivo::pluck('name', 'id');
        return view('inscripcions.reportes.inspeccionVigilancia', compact('planteles', 'lectivos'));
    }

    public function inspeccionVigilanciaR(Request $request)
    {
        $datos = $request->all();
        //dd($datos);
        $resultados = Inscripcion::select(
            'p.razon',
            'c.id as cliente_id',
            'c.nombre',
            'c.nombre2',
            'c.ape_paterno',
            'c.ape_materno',
            'n.name as nivel',
            'g.name as grupo',
            'l.inicio',
            'l.fin',
            'inscripcions.id as inscripcion_id'
        )
            ->join('clientes as c', 'c.id', '=', 'inscripcions.cliente_id')
            ->join('plantels as p', 'p.id', '=', 'inscripcions.plantel_id')
            ->join('nivels as n', 'n.id', '=', 'inscripcions.nivel_id')
            ->join('grupos as g', 'g.id', '=', 'inscripcions.grupo_id')
            ->join('lectivos as l', 'l.id', '=', 'inscripcions.lectivo_id')
            ->where('inscripcions.lectivo_id', $datos['lectivo_f'])
            ->whereIn('inscripcions.plantel_id', $datos['plantel_f'])
            ->whereNull('inscripcions.deleted_at')
            //        ->where('c.id',606)
            ->orderBy('inscripcions.plantel_id')
            ->orderBy('c.ape_paterno')
            ->orderBy('c.ape_materno')
            ->orderBy('c.nombre')
            ->orderBy('c.nombre2')
            ->get();
        //dd($resultados->toArray());
        $registros = array();
        foreach ($resultados as $r) {
            $mes = Carbon::createFromFormat('Y-m-d', $r->inicio)->month;
            $anio = Carbon::createFromFormat('Y-m-d', $r->inicio)->year;
            $registro = array();
            $registro['razon'] = $r->razon;
            $registro['cliente_id'] = $r->cliente_id;
            $registro['nombre'] = $r->ape_paterno . " " . $r->ape_materno . " " . $r->nombre . " " . $r->nombre2;
            $registro['nivel'] = $r->nivel;
            $registro['grupo'] = $r->grupo;
            //Revisa inscripciones para identificar conceptos pagados
            $buscarInscripcion = Adeudo::whereMonth('fecha_pago', '>=', $mes)->whereYear('fecha_pago', $anio)
                ->whereDate('fecha_pago', '<=', $r->fin)
                ->whereIn('adeudos.caja_concepto_id', array(1, 23, 4))
                ->where('cliente_id', $r->cliente_id)
                ->whereNull('deleted_at')
                ->first();
            //dd($buscarInscripcion);
            if (!is_null($buscarInscripcion) and $buscarInscripcion->pagado_bnd == 1) {
                $registro['inscripcion'] = $buscarInscripcion->cajaConcepto->name;
                //Revisa adeudos para identificar conceptos pagados
                $buscarMensualidad = Adeudo::whereMonth('fecha_pago', '>=', $mes)->whereYear('fecha_pago', $anio)
                    ->join('caja_conceptos as cc', 'cc.id', '=', 'adeudos.caja_concepto_id')
                    ->whereNotIn('adeudos.caja_concepto_id', array(1, 23, 4))
                    ->where('cliente_id', $r->cliente_id)
                    ->where('cc.bnd_mensualidad', 1)
                    ->whereNull('adeudos.deleted_at')
                    ->first();
                if (!is_null($buscarMensualidad) and $buscarMensualidad->pagado_bnd == 1) {
                    $registro['primera_mensualidad'] = $buscarMensualidad->cajaConcepto->name;
                } elseif (!is_null($buscarMensualidad) and $buscarMensualidad->pagado_bnd == 0) {
                    $registro['primera_mensualidad'] = "";
                } elseif (is_null($buscarMensualidad)) {
                    $registro['primera_mensualidad'] = "";
                }
            } elseif (!is_null($buscarInscripcion) and $buscarInscripcion->pagado_bnd == 0) {
                $registro['inscripcion'] = "";
                $registro['primera_mensualidad'] = "";
            } elseif (is_null($buscarInscripcion)) {
                $registro['inscripcion'] = "";
                $registro['primera_mensualidad'] = "";
            }

            $hacademica = Hacademica::where('inscripcion_id', $r->inscripcion_id)
                ->whereNull('deleted_at')
                ->first();

            if (!is_null($hacademica)) {
                $asignacion = AsignacionAcademica::where('plantel_id', $hacademica->plantel_id)
                    ->where('grupo_id', $hacademica->grupo_id)
                    ->where('materium_id', $hacademica->materium_id)
                    ->where('lectivo_id', $hacademica->lectivo_id)
                    ->whereNull('deleted_at')
                    ->first();

                $registro['asignacion'] = $asignacion->id;

                $fechas = $this->getFechas($asignacion);

                $registro['asistencias'] = $this->getAsistencias($asignacion, $r->cliente_id, $fechas);
                if ($registro['inscripcion'] <> "" and $registro['primera_mensualidad'] <> "" and $registro['asistencias'] > 0) {
                    $registro['cumple'] = "SI";
                } else {
                    $registro['cumple'] = "NO";
                }

                /*if($buscarInscripcion->count()>0){
                dd($buscarInscripcion->toArray());
            }*/

                //Revisa
                array_push($registros, $registro);
            }
        }
        //dd($registros);
        return view('inscripcions.reportes.inspeccionVigilanciaR', compact('registros'));
    }

    public function getFechas($asignacion)
    {
        $dias = array();
        //dd($asignacion);

        foreach ($asignacion->horarios as $horario) {
            array_push($dias, $horario->dia->name);
        }
        if (count($dias) == 0) {
            dd('Asignacion sin dias de horario: ' . $asignacion->id);
            return 'Sin dias de horario asignados a Asignacion ' . $asignacion->id;
            //dd();
        }
        //dd($dias);

        $fechas = array();
        $lectivo = Lectivo::find($asignacion->lectivo_id);
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
        $pinicio = Carbon::createFromFormat('Y-m-d', $lectivo->inicio);
        $pfin = Carbon::createFromFormat('Y-m-d', $lectivo->fin);

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
            if (in_array('Domingo', $dias)) {

                if ($pinicio->isSunday() and !in_array($pinicio, $no_habiles)) {
                    array_push($fechas, $pinicio->toDateString());
                    $total_asistencias++;
                }
            }

            $pinicio->addDay();
            //dd($fechas);
        }
        return $fechas;
    }

    public function getAsistencias($asignacion, $cliente, $fechas)
    {
        //dd($hacademica->toArray());

        if (is_null($asignacion)) {
            return 'Sin asignaciones validas';
        }
        //dd($asignacion);

        //$asignacion = AsignacionAcademica::find($data['asignacion']);
        /*foreach($registros as $registro){
        $asignacion= AsignacionAcademica::find($registro->asignacion);
        break;
        }*/



        $fechasAsistenciasReales = \App\AsistenciaR::where('asignacion_academica_id', $asignacion->id)
            ->where('cliente_id', $cliente)
            ->whereNotIn('cliente_id', [0, 2])
            ->get();

        $contador = 0;
        //dd($fechasAsistenciasReales);
        foreach ($fechas as $fecha) {
            foreach ($fechasAsistenciasReales as $fechaAsistenciaReal) {
                if ($fecha == $fechaAsistenciaReal->fecha) {
                    $contador++;
                }
            }
        }

        return $contador;
        /*
        return view('inscripcions.reportes.lista_mesr', array(
            'registros' => $registros,
            'fechas_enc' => $fechas,
            'asignacion' => $asignacion,
            'total_asistencias' => $total_asistencias,
            'contador' => $contador,
            'data' => $data,
            'total_alumnos' => $total_alumnos,
            'token' => $impresion['token'],
        ));*/
    }

    public function registrarMateriaAdicional(Request $request)
    {

        $datos = $request->all();
        //dd($datos);
        $i = Inscripcion::find($datos['inscripcion_id']);
        $m = Materium::find($datos['materia_id']);
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
        $h['periodo_estudio_id'] = $i->periodo_estudio_id;
        $h['turno_id'] = $i->turno_id;
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
        return 1;
    }

    public function regenerarCalificacionPonderacion($id)
    {
        $hacademicas = Hacademica::find($id);
        $m = Materium::find($hacademicas->materium_id);
        //dd($m);
        $calificacions = Calificacion::where('hacademica_id', $id)->get();
        //dd($calificacions->toArray());
        foreach ($calificacions as $calificacion) {
            $calificacion_ponderacions = CalificacionPonderacion::where('calificacion_id', $calificacion->id)->get();
            //dd($calificacion_ponderacions);
            if (count($calificacion_ponderacions) > 0) {
                foreach ($calificacion_ponderacions as $cp) {
                    $cp->delete();
                }
            }
            //dd($m);
            $ponderaciones = CargaPonderacion::where('ponderacion_id', '=', $m->ponderacion_id)
                ->where('bnd_activo', 1)
                ->get();
            //dd($ponderaciones);
            foreach ($ponderaciones as $p) {
                $ponde['calificacion_id'] = $calificacion->id;
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

        return redirect()->route('clientes.edit', $hacademicas->cliente_id)->with('message', 'Registro Actualizado.');
    }

    public function reportesDgcft()
    {
        $reportes = [1 => 'IEAP-04 Materias', 2 => 'RIAP-01 Alumnos', 3 => "ICP-08 Boletas"];
        return view('inscripcions.reportes.reportesDgcft', compact('reportes'))
            ->with('list', Inscripcion::getListFromAllRelationApps());
    }

    public function reportesDgcftR(Request $request)
    {
        $data = $request->all();
        //dd($data['bnd_detalle'][0]);
        $plantel = Plantel::find($data['plantel_f']);
        $especialidad = Especialidad::find($data['especialidad_f']);
        $grado = Grado::find($data['grado_f']);

        switch ($data['reportes']) {
            case 1:
                $resultado = $this->ieap04Materias($data);
                $registros = $resultado['registros'];
                $registros_detalle = $resultado['registros_detalle'];
                return view('inscripcions.reportes.reportesDgcftIEAP04', compact(
                    'registros',
                    'plantel',
                    'especialidad',
                    'grado',
                    'registros_detalle',
                    'data'
                ));
                break;
            case 2:
                $resultado = $this->riap02ListaAlumnos($data);
                //$registros=$resultado['registros'];
                //$registros_detalle=$resultado['registros_detalle'];
                //return view('inscripcions.reportes.reportesDgcftIEAP', compact('registros',
                // 'plantel','especialidad','grado','registros_detalle','data')); 
                break;
            case 3:
                break;
        }


        //dd($registros);
        //dd($registros_detalle);

    }

    public function ieap04Materias($data)
    {
        $materias = PeriodoEstudio::select(
            'periodo_estudios.bnd_carrera_tecnica',
            'periodo_estudios.orden_carrera_tecnica',
            'm.id as materia_id',
            'm.name as materia',
            'm.codigo',
            'm.creditos',
            'l.inicio',
            'l.fin',
            'aa.horas',
            'aa.id as asignacion_academica_id',
            'i.plantel_id',
            'i.especialidad_id',
            'i.nivel_id',
            'i.grado_id',
            'i.grupo_id',
            'i.lectivo_id'
        )
            ->join('inscripcions as i', 'i.periodo_estudio_id', 'periodo_estudios.id')
            ->where('i.plantel_id', $data['plantel_f'])
            ->where('i.especialidad_id', $data['especialidad_f'])
            ->where('i.nivel_id', $data['nivel_f'])
            ->where('i.grado_id', $data['grado_f'])
            ->whereIn('i.grupo_id', $data['grupo_f'])
            ->whereIn('i.lectivo_id', $data['lectivo_f'])
            ->join('asignacion_academicas as aa', 'aa.plantel_id', 'i.plantel_id')
            ->whereColumn('aa.grupo_id', 'i.grupo_id')
            ->whereColumn('aa.lectivo_id', 'i.lectivo_id')
            ->join('lectivos as l', 'l.id', 'i.lectivo_id')
            ->join('materium_periodos as mp', 'mp.periodo_estudio_id', 'periodo_estudios.id')
            ->join('materia as m', 'm.id', 'mp.materium_id')
            ->where('periodo_estudios.plantel_id', $data['plantel_f'])
            ->where('periodo_estudios.especialidad_id', $data['especialidad_f'])
            ->where('periodo_estudios.nivel_id', $data['nivel_f'])
            ->where('periodo_estudios.grado_id', $data['grado_f'])
            ->where('periodo_estudios.bnd_carrera_tecnica', 1)
            ->distinct()
            ->orderBy('periodo_estudios.orden_carrera_tecnica')
            ->get();
        //dd($materias->toArray());

        $total_materias = count($materias);
        $contador = 1;

        $registros = array();
        $registros_detalle = array();
        foreach ($materias as $materia) {
            $hacademicas_detalle = Hacademica::select(
                'hacademicas.*',
                'g.name as grupo',
                'c.st_cliente_id',
                'hacademicas.st_materium_id',
                'p.razon',
                'e.name as especialidad',
                'n.name as nivel',
                'gra.name as grado',
                'l.name as lectivo',
                'stm.name as st_materia',
                'pe.name as periodo_estudio',
                'stc.name as st_cliente',
                'm.name as materia',
                'c.nombre',
                'c.nombre2',
                'c.ape_paterno',
                'c.ape_materno'
            )
                ->join('clientes as c', 'c.id', 'hacademicas.cliente_id')
                ->join('plantels as p', 'p.id', 'hacademicas.plantel_id')
                ->join('especialidads as e', 'e.id', 'hacademicas.especialidad_id')
                ->join('nivels as n', 'n.id', 'hacademicas.nivel_id')
                ->join('grados as gra', 'gra.id', 'hacademicas.grado_id')
                ->join('grupos as g', 'g.id', 'hacademicas.grupo_id')
                ->join('lectivos as l', 'l.id', 'hacademicas.lectivo_id')
                ->join('st_materias as stm', 'stm.id', 'hacademicas.st_materium_id')
                ->join('periodo_estudios as pe', 'pe.id', 'hacademicas.periodo_estudio_id')
                ->join('st_clientes as stc', 'stc.id', 'c.st_cliente_id')
                ->join('materia as m', 'm.id', 'hacademicas.materium_id')
                ->where('hacademicas.plantel_id', $materia->plantel_id)
                ->where('hacademicas.especialidad_id', $materia->especialidad_id)
                ->where('hacademicas.nivel_id', $materia->nivel_id)
                ->where('hacademicas.grado_id', $materia->grado_id)
                ->where('hacademicas.grupo_id', $materia->grupo_id)
                ->where('hacademicas.lectivo_id', $materia->lectivo_id)
                ->where('hacademicas.materium_id', $materia->materia_id)
                ->whereNull('hacademicas.deleted_at')
                //->where('hacademicas.st_materium_id',1)
                ->orderBy('c.ape_paterno')
                ->orderBy('c.ape_materno')
                ->orderBy('c.nombre')
                ->orderBy('c.nombre2')
                ->get();
            foreach ($hacademicas_detalle->toArray() as $linea) {
                array_push($registros_detalle, $linea);
            }
            //dd($hacademicas_detalle->toArray());
            $asignacion = AsignacionAcademica::where('id', $materia->asignacion_academica_id)->first();
            $horario = $asignacion->horarios()->first();
            $hora_fin = "";
            if (!is_null($horario) and !is_null($horario->hora)) {
                $hora_fin = Carbon::createFromFormat('H:i:s', $horario->hora)->addHour($horario->duracion_clase)->toTimeString();
            }

            $hacademicas_inscritos = Hacademica::select('id', 'g.name as grupo')
                ->join('grupos as g', 'g.id', 'hacademicas.grupo_id')
                ->where('hacademicas.plantel_id', $materia->plantel_id)
                ->where('hacademicas.especialidad_id', $materia->especialidad_id)
                ->where('hacademicas.nivel_id', $materia->nivel_id)
                ->where('hacademicas.grado_id', $materia->grado_id)
                ->where('hacademicas.grupo_id', $materia->grupo_id)
                ->where('hacademicas.lectivo_id', $materia->lectivo_id)
                ->where('hacademicas.materium_id', $materia->materia_id)
                ->whereNull('hacademicas.deleted_at')
                ->where('hacademicas.st_materium_id', 1)
                ->count();
            /*
            $hacademicas_acreditados=Hacademica::select('id','g.name as grupo')
            ->join('grupos as g','g.id','hacademicas.grupo_id')
            ->where('hacademicas.plantel_id', $materia->plantel_id)
            ->where('hacademicas.especialidad_id', $materia->especialidad_id)
            ->where('hacademicas.nivel_id', $materia->nivel_id)
            ->where('hacademicas.grado_id', $materia->grado_id)
            ->where('hacademicas.grupo_id', $materia->grupo_id)
            ->where('hacademicas.lectivo_id', $materia->lectivo_id)
            ->where('hacademicas.materium_id', $materia->materia_id)
            ->where('hacademicas.st_materium_id',1)
            ->whereNull('hacademicas.deleted_at')
            ->count();

            $hacademicas_bajas=Hacademica::select('id','g.name as grupo')
            ->join('grupos as g','g.id','hacademicas.grupo_id')
            ->join('clientes as c','c.id','hacademicas.cliente_id')
            ->where('hacademicas.plantel_id', $materia->plantel_id)
            ->where('hacademicas.especialidad_id', $materia->especialidad_id)
            ->where('hacademicas.nivel_id', $materia->nivel_id)
            ->where('hacademicas.grado_id', $materia->grado_id)
            ->where('hacademicas.grupo_id', $materia->grupo_id)
            ->where('hacademicas.lectivo_id', $materia->lectivo_id)
            ->where('hacademicas.materium_id', $materia->materia_id)
            ->where('c.st_cliente_id',3)
            ->whereNull('hacademicas.deleted_at')
            ->count();
            */
            //dd($hacademicas_cuenta);
            array_push($registros, array(
                'grado' => $materia->orden_carrera_tecnica . "/" . $total_materias,
                'materia' => $materia->materia,
                'inicio' => $materia->inicio,
                'fin' => $materia->fin,
                'hora_inicio' => (!is_null($horario) ? $horario->hora : ""),
                'hora_fin' => $hora_fin,
                'horas' => $asignacion->horas,
                'inscritos' => $hacademicas_inscritos,
                //'acreditados'=>$hacademicas_acreditados, 'bajas'=>$hacademicas_bajas
            ));
            $contador++;
        }
        return array('registros' => $registros, 'registros_detalle' => $registros_detalle);
    }

    public function riap02ListaAlumnos($data)
    {
        $materias = PeriodoEstudio::select(
            'periodo_estudios.bnd_carrera_tecnica',
            'periodo_estudios.orden_carrera_tecnica',
            'm.id as materia_id',
            'm.name as materia',
            'm.codigo',
            'm.creditos',
            'l.inicio',
            'l.fin',
            'aa.horas',
            'aa.id as asignacion_academica_id',
            'i.plantel_id',
            'i.especialidad_id',
            'i.nivel_id',
            'i.grado_id',
            'i.grupo_id',
            'i.lectivo_id'
        )
            ->join('inscripcions as i', 'i.periodo_estudio_id', 'periodo_estudios.id')
            ->where('i.plantel_id', $data['plantel_f'])
            ->where('i.especialidad_id', $data['especialidad_f'])
            ->where('i.nivel_id', $data['nivel_f'])
            ->where('i.grado_id', $data['grado_f'])
            ->whereIn('i.grupo_id', $data['grupo_f'])
            ->whereIn('i.lectivo_id', $data['lectivo_f'])
            ->join('asignacion_academicas as aa', 'aa.plantel_id', 'i.plantel_id')
            ->whereColumn('aa.grupo_id', 'i.grupo_id')
            ->whereColumn('aa.lectivo_id', 'i.lectivo_id')
            ->join('lectivos as l', 'l.id', 'i.lectivo_id')
            ->join('materium_periodos as mp', 'mp.periodo_estudio_id', 'periodo_estudios.id')
            ->join('materia as m', 'm.id', 'mp.materium_id')
            ->where('periodo_estudios.plantel_id', $data['plantel_f'])
            ->where('periodo_estudios.especialidad_id', $data['especialidad_f'])
            ->where('periodo_estudios.nivel_id', $data['nivel_f'])
            ->where('periodo_estudios.grado_id', $data['grado_f'])
            ->where('periodo_estudios.bnd_carrera_tecnica', 1)
            ->distinct()
            ->orderBy('periodo_estudios.orden_carrera_tecnica')
            ->get();
        //dd($materias->toArray());

        $total_materias = count($materias);
        $contador = 1;

        $registros = array();
        $registros_detalle = array();
        foreach ($materias as $materia) {
            $hacademicas_detalle = Hacademica::select(
                'hacademicas.*',
                'g.name as grupo',
                'c.st_cliente_id',
                'hacademicas.st_materium_id',
                'p.razon',
                'e.name as especialidad',
                'n.name as nivel',
                'g.name as grado',
                'l.name as lectivo',
                'stm.name as st_materia',
                'pe.name as periodo_estudio',
                'stc.name as st_cliente',
                'm.name as materia',
                'c.nombre',
                'c.nombre2',
                'c.ape_paterno',
                'c.ape_materno'
            )
                ->join('clientes as c', 'c.id', 'hacademicas.cliente_id')
                ->join('plantels as p', 'p.id', 'hacademicas.plantel_id')
                ->join('especialidads as e', 'e.id', 'hacademicas.especialidad_id')
                ->join('nivels as n', 'n.id', 'hacademicas.nivel_id')
                ->join('grados as gra', 'gra.id', 'hacademicas.grado_id')
                ->join('grupos as g', 'g.id', 'hacademicas.grupo_id')
                ->join('lectivos as l', 'l.id', 'hacademicas.lectivo_id')
                ->join('st_materias as stm', 'stm.id', 'hacademicas.st_materium_id')
                ->join('periodo_estudios as pe', 'pe.id', 'hacademicas.periodo_estudio_id')
                ->join('st_clientes as stc', 'stc.id', 'c.st_cliente_id')
                ->join('materia as m', 'm.id', 'hacademicas.materium_id')
                ->where('hacademicas.plantel_id', $materia->plantel_id)
                ->where('hacademicas.especialidad_id', $materia->especialidad_id)
                ->where('hacademicas.nivel_id', $materia->nivel_id)
                ->where('hacademicas.grado_id', $materia->grado_id)
                ->where('hacademicas.grupo_id', $materia->grupo_id)
                ->where('hacademicas.lectivo_id', $materia->lectivo_id)
                ->where('hacademicas.materium_id', $materia->materia_id)
                ->whereNull('hacademicas.deleted_at')
                //->where('hacademicas.st_materium_id',1)
                ->orderBy('c.ape_paterno')
                ->orderBy('c.ape_materno')
                ->orderBy('c.nombre')
                ->orderBy('c.nombre2')
                ->get();
            foreach ($hacademicas_detalle->toArray() as $linea) {
                array_push($registros_detalle, $linea);
            }
            //dd($hacademicas_detalle->toArray());
            $asignacion = AsignacionAcademica::where('id', $materia->asignacion_academica_id)->first();
            $horario = $asignacion->horarios()->first();
            $hora_fin = "";
            if (!is_null($horario) and !is_null($horario->hora)) {
                $hora_fin = Carbon::createFromFormat('H:i:s', $horario->hora)->addHour($horario->duracion_clase)->toTimeString();
            }

            $hacademicas_inscritos = Hacademica::select('id', 'g.name as grupo')
                ->join('grupos as g', 'g.id', 'hacademicas.grupo_id')
                ->where('hacademicas.plantel_id', $materia->plantel_id)
                ->where('hacademicas.especialidad_id', $materia->especialidad_id)
                ->where('hacademicas.nivel_id', $materia->nivel_id)
                ->where('hacademicas.grado_id', $materia->grado_id)
                ->where('hacademicas.grupo_id', $materia->grupo_id)
                ->where('hacademicas.lectivo_id', $materia->lectivo_id)
                ->where('hacademicas.materium_id', $materia->materia_id)
                ->whereNull('hacademicas.deleted_at')
                ->where('hacademicas.st_materium_id', 1)
                ->count();

            /*$hacademicas_acreditados=Hacademica::select('id','g.name as grupo')
            ->join('grupos as g','g.id','hacademicas.grupo_id')
            ->where('hacademicas.plantel_id', $materia->plantel_id)
            ->where('hacademicas.especialidad_id', $materia->especialidad_id)
            ->where('hacademicas.nivel_id', $materia->nivel_id)
            ->where('hacademicas.grado_id', $materia->grado_id)
            ->where('hacademicas.grupo_id', $materia->grupo_id)
            ->where('hacademicas.lectivo_id', $materia->lectivo_id)
            ->where('hacademicas.materium_id', $materia->materia_id)
            ->where('hacademicas.st_materium_id',1)
            ->whereNull('hacademicas.deleted_at')
            ->count();

            $hacademicas_bajas=Hacademica::select('id','g.name as grupo')
            ->join('grupos as g','g.id','hacademicas.grupo_id')
            ->join('clientes as c','c.id','hacademicas.cliente_id')
            ->where('hacademicas.plantel_id', $materia->plantel_id)
            ->where('hacademicas.especialidad_id', $materia->especialidad_id)
            ->where('hacademicas.nivel_id', $materia->nivel_id)
            ->where('hacademicas.grado_id', $materia->grado_id)
            ->where('hacademicas.grupo_id', $materia->grupo_id)
            ->where('hacademicas.lectivo_id', $materia->lectivo_id)
            ->where('hacademicas.materium_id', $materia->materia_id)
            ->where('c.st_cliente_id',3)
            ->whereNull('hacademicas.deleted_at')
            ->count();
            */
            //dd($hacademicas_cuenta);
            array_push($registros, array(
                'grado' => $materia->orden_carrera_tecnica . "/" . $total_materias,
                'materia' => $materia->materia,
                'inicio' => $materia->inicio,
                'fin' => $materia->fin,
                'hora_inicio' => (!is_null($horario) ? $horario->hora : ""),
                'hora_fin' => $hora_fin,
                'horas' => $asignacion->horas,
                'inscritos' => $hacademicas_inscritos,
                //'acreditados'=>$hacademicas_acreditados, 'bajas'=>$hacademicas_bajas
            ));
            $contador++;
        }
        return array('registros' => $registros, 'registros_detalle' => $registros_detalle);
    }
}
