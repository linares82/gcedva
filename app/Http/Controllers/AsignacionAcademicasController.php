<?php

namespace App\Http\Controllers;

use DB;
use Auth;

use App\Dium;
use App\Grupo;
use App\Cliente;
use App\Horario;
use App\Lectivo;
use App\Plantel;
use App\Empleado;
use App\Materium;
use Carbon\Carbon;
use App\DiaNoHabil;
use App\Hacademica;
use App\AsistenciaR;
use App\Inscripcion;
use App\Http\Requests;
use App\PeriodoEstudio;
use App\CargaPonderacion;
use App\AsignacionAcademica;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Luecano\NumeroALetras\NumeroALetras;
use App\Http\Requests\createAsignacionAcademica;
use App\Http\Requests\updateAsignacionAcademica;

class AsignacionAcademicasController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{

		$asignacionAcademicas = AsignacionAcademica::getAllData($request);
		$e = Empleado::where('user_id', '=', Auth::user()->id)->first();
		return view('asignacionAcademicas.index', compact('asignacionAcademicas', 'e'))
			->with('list', AsignacionAcademica::getListFromAllRelationApps());
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$asignacionAcademica = new AsignacionAcademica;

		return view('asignacionAcademicas.create')
			->with('list', AsignacionAcademica::getListFromAllRelationApps());
	}

	public function createfromHorario(AsignacionAcademica $asignacionAcademica, Request $request)
	{
		$datos = $request->all();


		$asignacionAcademica->empleado_id = null;
		$asignacionAcademica->materium_id = null;
		$asignacionAcademica->grupo_id = $datos['grupo_f'];
		$asignacionAcademica->horas = null;
		$asignacionAcademica->plantel_id = $datos['plantel_f'];
		$asignacionAcademica->lectivo_id = $datos['lectivo_f'];
		$asignacionAcademica->usu_alta_id = Auth::user()->id;
		$asignacionAcademica->usu_mod_id = Auth::user()->id;
		$asignacionAcademica->asistencias_max = null;
		$asignacionAcademica->fec_inicio = null;
		$asignacionAcademica->fec_fin = null;
		$asignacionAcademica->docente_oficial = null;
		$asignacionAcademica->horas = null;
		$asignacionAcademica->lectivo_oficial_id = null;
		$asignacionAcademica->docente_oficial_id = null;

		//dd($datos);

		//dd($asignacionAcademica);
		return view('asignacionAcademicas.createFromHorario', compact('asignacionAcademica'))
			->with('list', AsignacionAcademica::getListFromAllRelationApps())
			->with('list1', Horario::getListFromAllRelationApps());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createAsignacionAcademica $request)
	{

		$input = $request->all();
		$input['usu_alta_id'] = Auth::user()->id;
		$input['usu_mod_id'] = Auth::user()->id;
		//dd($input);
		//create data
		AsignacionAcademica::create($input);

		return redirect()->route('asignacionAcademicas.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, AsignacionAcademica $asignacionAcademica)
	{
		$asignacionAcademica = $asignacionAcademica->find($id);
		return view('asignacionAcademicas.show', compact('asignacionAcademica'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, AsignacionAcademica $asignacionAcademica)
	{
		$asignacionAcademica = $asignacionAcademica->find($id);


		return view('asignacionAcademicas.edit', compact('asignacionAcademica'))
			->with('list', AsignacionAcademica::getListFromAllRelationApps())
			->with('list1', Horario::getListFromAllRelationApps());
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, AsignacionAcademica $asignacionAcademica, Request $request)
	{
		$asignacionAcademica = $asignacionAcademica->find($id);

		return view('asignacionAcademicas.duplicate', compact('asignacionAcademica'))
			->with('list', AsignacionAcademica::getListFromAllRelationApps())
			->with('list1', Horario::getListFromAllRelationApps());
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, AsignacionAcademica $asignacionAcademica, updateAsignacionAcademica $request)
	{
		$input = $request->all();
		$input['usu_mod_id'] = Auth::user()->id;
		//dd($request->all());
		$input2['asignacion_academica_id'] = $id;
		$input2['dia_id'] = $input['dia_id'];
		$input2['hora'] = $input['hora'];
		$input2['duracion_clase'] = $input['duracion_clase'];
		$input2['usu_mod_id'] = Auth::user()->id;
		$input2['usu_alta_id'] = Auth::user()->id;
		unset($input['dia_id']);
		unset($input['hora']);
		unset($input['duracion_clase']);

		//update data
		$asignacionAcademica = $asignacionAcademica->find($id);
		$asignacionAcademica->update($input);
		if ($request->input('dia_id') and $request->input('hora') and $request->input('duracion_clase')) {

			Horario::create($input2);
		}




		return redirect()->route('asignacionAcademicas.edit', $id)->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id, AsignacionAcademica $asignacionAcademica)
	{
		$asignacionAcademica = $asignacionAcademica->find($id);
		$asignacionAcademica->delete();

		return redirect()->route('asignacionAcademicas.index')->with('message', 'Registro Borrado.');
	}

	public function horarioGrupo()
	{
		return view('asignacionAcademicas.reportes.horarioGrupo')
			->with('list', AsignacionAcademica::getListFromAllRelationApps());
	}

	public function horarioGrupoR(Request $request)
	{
		$input = $request->all();
		//dd($input);
		$fecha = date('d-m-Y');
		$dias = Dium::where('id', '>', 0)->get();
		$horario_armado = array();
		$encabezado = array();
		array_push($encabezado, 'Horas');
		$periodo_estudio = PeriodoEstudio::find($input['periodo_estudio_id']);
		$grupo = Grupo::find($input['grupo_f']);
		$lectivo = Lectivo::find($input['lectivo_f']);
		foreach ($dias as $dia) {
			array_push($encabezado, $dia->name);
		}
		array_push($horario_armado, $encabezado);
		//dd($encabezado);

		$horas = AsignacionAcademica::select(
			'h.hora'
		)
			//->join('empleados as e', 'e.id', '=', 'asignacion_academicas.empleado_id')
			->join('plantels as p', 'p.id', '=', 'asignacion_academicas.plantel_id')
			->join('materia as m', 'm.id', '=', 'asignacion_academicas.materium_id')
			->join('grupos as g', 'g.id', '=', 'asignacion_academicas.grupo_id')
			->join('lectivos as l', 'l.id', '=', 'asignacion_academicas.lectivo_id')
			->join('horarios as h', 'h.asignacion_academica_id', '=', 'asignacion_academicas.id')
			->join('dias as d', 'd.id', '=', 'h.dia_id')
			->join('periodo_estudios as pe', 'pe.plantel_id', 'asignacion_academicas.plantel_id')
			->join('materium_periodos as mp', 'mp.periodo_estudio_id', 'pe.id')
			->whereColumn('m.id', 'mp.materium_id')
			//->where('asignacion_academicas.plantel_id', '>=', $input['plantel_f'])
			->where('asignacion_academicas.grupo_id', '=', $input['grupo_f'])
			->where('l.id', '=', $input['lectivo_f'])
			->where('pe.plantel_id', '=', $input['plantel_f'])
			->where('pe.especialidad_id', '=', $input['especialidad_id'])
			->where('pe.nivel_id', '=', $input['nivel_id'])
			->where('pe.grado_id', '=', $input['grado_id'])
			->whereNull('h.deleted_at')
			->whereNull('h.deleted_at')
			->whereNull('pe.deleted_at')
			->orderBy('hora')
			->distinct()
			//->groupBy('esp.meta','e.nombre', 'e.ape_paterno', 'e.ape_materno')
			->get();
		//dd($horas->toArray());
		foreach ($horas as $hora) {
			//dd($hora->hora);
			$registro = array();
			array_push($registro, $hora->hora);
			foreach ($dias as $dia) {
				$materia = AsignacionAcademica::select(
					//DB::raw("concat(e.nombre,' ',e.ape_paterno,' ',e.ape_materno) as empleado"),
					'asignacion_academicas.id as asignacion_academica_id',
					'pe.id as periodo_estudio_id',
					'emp.id as empleado_id',
					'p.razon as plantel',
					'm.name as materia',
					'g.name as grupo',
					'l.name as lectivo',
					DB::raw('d.name as dia'),
					'h.hora',
					'h.duracion_clase',
					'pe.name as periodo_estudio'
				)
					//->join('empleados as e', 'e.id', '=', 'asignacion_academicas.empleado_id')
					->join('plantels as p', 'p.id', '=', 'asignacion_academicas.plantel_id')
					->join('materia as m', 'm.id', '=', 'asignacion_academicas.materium_id')
					->join('grupos as g', 'g.id', '=', 'asignacion_academicas.grupo_id')
					->join('lectivos as l', 'l.id', '=', 'asignacion_academicas.lectivo_id')
					->join('horarios as h', 'h.asignacion_academica_id', '=', 'asignacion_academicas.id')
					->join('dias as d', 'd.id', '=', 'h.dia_id')
					->join('periodo_estudios as pe', 'pe.plantel_id', 'asignacion_academicas.plantel_id')
					->join('materium_periodos as mp', 'mp.periodo_estudio_id', 'pe.id')
					->join('empleados as emp', 'emp.id', 'asignacion_academicas.empleado_id')
					->whereColumn('m.id', 'mp.materium_id')
					->where('asignacion_academicas.grupo_id', '=', $input['grupo_f'])
					->where('l.id', '=', $input['lectivo_f'])
					->where('pe.plantel_id', '=', $input['plantel_f'])
					->where('pe.especialidad_id', '=', $input['especialidad_id'])
					->where('pe.nivel_id', '=', $input['nivel_id'])
					->where('pe.grado_id', '=', $input['grado_id'])
					->whereNull('h.deleted_at')
					->whereNull('pe.deleted_at')
					->whereNull('asignacion_academicas.deleted_at')
					->where('h.hora', $hora->hora)
					->where('d.id', $dia->id)
					->distinct()
					->get();
				//dd($materia->materia);
				if ($materia->count() == 0) {
					array_push($registro, '');
				} else {
					$cadena_materias = "";
					$cadenas = array();
					foreach ($materia as $m) {
						//dd($m);

						$hora_fin = $m->duracion_clase * 50;
						$cadena_materias = " asignacion-" . $m->asignacion_academica_id .
							" periodo-" . $m->periodo_estudio_id .
							" docente-" . $m->empleado_id .
							" materia-" . $m->materia .
							" duracion clase-" . $m->duracion_clase . " horas(" .
							date('H:i:s', strtotime('+' . $hora_fin . " minutes", strtotime($m->hora)))
							. ")";
						array_push($cadenas, array('materia' => $cadena_materias, 'asignacion' => $m->asignacion_academica_id));
					}
					array_push($registro, $cadenas);
				}
				//dd($registro);	
			}
			array_push($horario_armado, $registro);
		}
		//dd($horario_armado);


		//dd($request->all());
		$horarios = AsignacionAcademica::select(
			//DB::raw("concat(e.nombre,' ',e.ape_paterno,' ',e.ape_materno) as empleado"),
			'asignacion_academicas.id as asignacion_academica_id',
			'pe.id as periodo_estudio_id',
			'p.razon as plantel',
			'm.name as materia',
			'g.name as grupo',
			'l.name as lectivo',
			DB::raw('concat(d.id,"-",d.name) as dia'),
			'h.hora',
			'pe.name as periodo_estudio'
		)
			//->join('empleados as e', 'e.id', '=', 'asignacion_academicas.empleado_id')
			->join('plantels as p', 'p.id', '=', 'asignacion_academicas.plantel_id')
			->join('materia as m', 'm.id', '=', 'asignacion_academicas.materium_id')
			->join('grupos as g', 'g.id', '=', 'asignacion_academicas.grupo_id')
			->join('lectivos as l', 'l.id', '=', 'asignacion_academicas.lectivo_id')
			->join('horarios as h', 'h.asignacion_academica_id', '=', 'asignacion_academicas.id')
			->join('dias as d', 'd.id', '=', 'h.dia_id')
			->join('periodo_estudios as pe', 'pe.plantel_id', 'asignacion_academicas.plantel_id')
			->join('materium_periodos as mp', 'mp.periodo_estudio_id', 'pe.id')
			->whereColumn('m.id', 'mp.materium_id')
			->where('pe.plantel_id', '=', $input['plantel_f'])
			->where('pe.grado_id', '=', $input['grado_id'])
			->where('asignacion_academicas.grupo_id', '=', $input['grupo_f'])
			//->where('asignacion_academicas.lectivo_id', '<=', $input['lectivo_f'])
			->whereNull('h.deleted_at')
			->orderBy('plantel')
			->orderBy('grupo')
			->orderBy('d.id')
			->orderBy('hora')

			//->groupBy('esp.meta','e.nombre', 'e.ape_paterno', 'e.ape_materno')
			->get();

		//dd($horarios->toArray());
		$colores = [
			12 => "#42FF33",
			11 => "#FF3333",
			10 => "#FFFF33",
			9 => "#33FFE6",
			8 => "#335EFF",
			7 => "#FF33F6",
			6 => "#FF8D33",
			5 => "#068800",
			4 => "#008FFF",
			3 => "#5D00FF",
			2 => "#FF007C",
			1 => "#838082"
		];

		return view(
			'asignacionAcademicas.reportes.horarioGrupoR',
			compact('fecha', 'horario_armado', 'periodo_estudio', 'grupo', 'lectivo', 'colores', 'input')
		)
			->with('datos', json_encode($horarios));
	}


	public function getCmbGrupo(Request $request)
	{
		if ($request->ajax()) {
			//dd($request->get('plantel_id'));
			$plantel = $request->get('plantel_id');
			$grupo = $request->get('grupo_id');
			$lectivo = $request->get('lectivo_id');
			$nivel = $request->get('nivel_id');
			$final = array();
			$r = DB::table('grupos as g')
				->select('g.id', 'g.name')
				->join('asignacion_academicas as aa', 'aa.plantel_id', '=', 'g.plantel_id')
				->join('grupo_periodo_estudios as gpe', 'gpe.grupo_id', '=', 'g.id')
				->join('periodo_estudios as pe', 'pe.id', '=', 'gpe.periodo_estudio_id')
				->where('pe.nivel_id', $nivel)
				->where('g.plantel_id', '=', $plantel)
				->where('aa.lectivo_id', '=', $lectivo)
				->where('g.id', '>', '0')
				->whereNull('aa.deleted_at')
				->whereNull('g.deleted_at')
				->distinct()
				->get();
			//dd($r);
			if (isset($grupo) and $grupo <> 0) {
				foreach ($r as $r1) {
					if ($r1->id == $grupo) {
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

	public function getCmbLectivo(Request $request)
	{
		if ($request->ajax()) {
			//dd($request->get('plantel_id'));
			$plantel = $request->get('plantel_id');
			$lectivo = $request->get('lectivo_id');
			$final = array();
			$r = DB::table('lectivos as l')
				->select('l.id', 'l.name')
				->join('asignacion_academicas as aa', 'aa.lectivo_id', '=', 'l.id')
				->where('aa.plantel_id', '=', $plantel)
				//->where('aa.lectivo_i', '=', $lectivo)
				->where('l.id', '>', '0')
				->distinct()
				->get();
			//dd($r);
			if (isset($lectivo) and $lectivo <> 0) {
				foreach ($r as $r1) {
					if ($r1->id == $lectivo) {
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

	public function getCmbInstructor(Request $request)
	{
		if ($request->ajax()) {
			//dd($request->get('plantel_id'));
			$plantel = $request->get('plantel');
			$lectivo = $request->get('lectivo');
			$grupo = $request->get('grupo');
			$instructor = $request->get('instructor');
			$final = array();
			$r = DB::table('empleados as e')
				->select('e.id', DB::Raw('concat(e.nombre," ",ape_paterno," ",ape_materno) as name'))
				->join('asignacion_academicas as aa', 'aa.empleado_id', '=', 'e.id')
				->where('aa.plantel_id', '=', $plantel)
				->where('aa.lectivo_id', '=', $lectivo)
				->where('aa.grupo_id', '=', $grupo)
				->where('e.id', '>', '0')
				->distinct()
				->get();
			//dd($r);
			if (isset($instructor) and $instructor <> 0) {
				foreach ($r as $r1) {
					if ($r1->id == $instructor) {
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

	/*public function boletasGrupo(Request $request){
            $datos=$request->all();
            $asignacion= AsignacionAcademica::find($datos['asignacion']);
            $clientes=Cliente::select('p.razon as plantel','i.matricula', 'clientes.id', 'clientes.nombre','clientes.nombre2','clientes.ape_paterno',
                             'clientes.ape_materno','i.fec_inscripcion','t.name as turno',
                             'g.name as grado', 'l.id as lectivo')
                             ->join('plantels as p','p.id','=','clientes.plantel_id')
                             ->join('inscripcions as i','i.cliente_id','=','clientes.id')
                             ->join('grados as g','g.id','=','i.grado_id')
                             ->join('lectivos as l','l.id','=','i.lectivo_id')
                             ->join('turnos as t','t.id','=','i.turno_id')
                             ->where('i.lectivo_id','=',$asignacion->lectivo_id)
                             ->where('i.grupo_id','=',$asignacion->grupo_id)
                             ->where('i.plantel_id','=',$asignacion->plantel_id)
                             ->get();
            return view('asignacionAcademicas.reportes.boletasr', array('clientes'=>$clientes,'datos'=>$datos));
        }*/

	public function boletasGrupo(Request $request)
	{
		$datos = $request->all();
		$asignacion = AsignacionAcademica::find($datos['asignacion']);
		/*
            $clientes=Cliente::select('clientes.id','e.imagen')
                             ->join('inscripcions as i','i.cliente_id','=','clientes.id')
                             ->join('especialidads as e','e.id','=','i.especialidad_id')
                             ->where('i.lectivo_id','=',$asignacion->lectivo_id)
                             ->where('i.grupo_id','=',$asignacion->grupo_id)
                             ->where('i.plantel_id','=',$asignacion->plantel_id)
                             ->get();
            */
		$clientes = Cliente::select(
			'clientes.id',
			'clientes.matricula',
			'h.inscripcion_id',
			'e.imagen',
			'e.name as especialidad',
			'h.especialidad_id',
			'n.name as nivel',
			'h.nivel_id',
			'g.name as grado',
			'g.rvoe',
			'h.grado_id',
			'p.razon as plantel',
			'h.plantel_id',
			'gr.name as grupo',
			'h.grupo_id',
			'h.lectivo_id',
			'l.name as lectivo'
		)
			->join('hacademicas as h', 'h.cliente_id', '=', 'clientes.id')
			->join('inscripcions as i', 'i.id', '=', 'h.inscripcion_id')
			->join('plantels as p', 'p.id', '=', 'h.plantel_id')
			->join('especialidads as e', 'e.id', '=', 'h.especialidad_id')
			->join('nivels as n', 'n.id', '=', 'h.nivel_id')
			->join('grados as g', 'g.id', '=', 'h.grado_id')
			->join('grupos as gr', 'gr.id', '=', 'h.grupo_id')
			->join('lectivos as l', 'l.id', '=', 'h.lectivo_id')
			->where('h.lectivo_id', '=', $asignacion->lectivo_id)
			->where('h.grupo_id', '=', $asignacion->grupo_id)
			->where('h.plantel_id', '=', $asignacion->plantel_id)
			->whereNull('h.deleted_at')
			->whereNull('i.deleted_at')
			->distinct()
			->get();
		//dd($clientes->toArray());
		return view('asignacionAcademicas.reportes.boleta', compact('clientes'))
			->with('');
	}

	public function boletasGrupoO(Request $request)
	{
		$datos = $request->all();
		$asignacion = AsignacionAcademica::find($datos['asignacion']);
		/*
            $clientes=Cliente::select('clientes.id','e.imagen')
                             ->join('inscripcions as i','i.cliente_id','=','clientes.id')
                             ->join('especialidads as e','e.id','=','i.especialidad_id')
                             ->where('i.lectivo_id','=',$asignacion->lectivo_id)
                             ->where('i.grupo_id','=',$asignacion->grupo_id)
                             ->where('i.plantel_id','=',$asignacion->plantel_id)
                             ->get();
            */
		$clientes = Cliente::select(
			'clientes.id',
			'clientes.matricula',
			'h.inscripcion_id',
			'e.imagen',
			'e.name as especialidad',
			'h.especialidad_id',
			'n.name as nivel',
			'h.nivel_id',
			'g.name as grado',
			'g.rvoe',
			'h.grado_id',
			'p.razon as plantel',
			'h.plantel_id',
			'gr.name as grupo',
			'h.grupo_id',
			'h.lectivo_id',
			'l.name as lectivo'
		)
			->join('hacademicas as h', 'h.cliente_id', '=', 'clientes.id')
			->join('inscripcions as i', 'i.id', '=', 'h.inscripcion_id')
			->join('plantels as p', 'p.id', '=', 'h.plantel_id')
			->join('especialidads as e', 'e.id', '=', 'h.especialidad_id')
			->join('nivels as n', 'n.id', '=', 'h.nivel_id')
			->join('grados as g', 'g.id', '=', 'h.grado_id')
			->join('grupos as gr', 'gr.id', '=', 'h.grupo_id')
			->join('lectivos as l', 'l.id', '=', 'h.lectivo_id')
			->where('h.lectivo_id', '=', $asignacion->lectivo_id)
			->where('h.grupo_id', '=', $asignacion->grupo_id)
			->where('h.plantel_id', '=', $asignacion->plantel_id)
			->whereNull('h.deleted_at')
			->whereNull('i.deleted_at')
			->distinct()
			->get();
		//dd($clientes->toArray());
		return view('asignacionAcademicas.reportes.boletaO', compact('clientes'))
			->with('');
	}

	public function asistenciasXAsignacion(Request $request)
	{
		$datos = $request->all();

		$cliente = Cliente::find($datos['cliente']);
		if (is_null($cliente)) {
			return response()->json([
				'message' => 'Cliente No Existe'
			], 404);
		}

		$asignaciones = AsignacionAcademica::where('grupo_id', $datos['grupo'])
			->where('lectivo_id', $datos['lectivo'])
			->where('materium_id', $datos['materia'])
			->get();
		//dd($asignaciones->toArray());

		$array_asistencias = array();
		$array_resultado = array();
		foreach ($asignaciones as $asignacion) {
			//dd($asignacion);
			$asistencias = AsistenciaR::where('cliente_id', $datos['cliente'])
				->where('asignacion_academica_id', $asignacion->id)
				->get();
			//dd($asistencias);
			foreach ($asistencias as $asistencia) {
				//dd($asistencia->estAsistencium);
				array_push($array_asistencias, array(
					'fecha' => $asistencia->fecha,
					'estatus' => $asistencia->estAsistencium->name
				));
			}
			array_push($array_resultado, array([
				'id_asignacion_academicas' => $asignacion->id,
				'ciente_id' => $cliente->id,
				'cliente_nombre_completo' => $cliente->nombre . " " . $cliente->nombre2 . " " . $cliente->ape_paterno . " " . $cliente->ape_materno,
				'materia' => $asignacion->materia->name,
				'grupo' => $asignacion->grupo->name,
				'lectivo' => $asignacion->lectivo->name,
				'asistencias' => $array_asistencias
			]));
		}

		return response()->json(['resultado' => $array_resultado]);
	}

	public function actaCalificaciones()
	{
		$empleado = Empleado::where('user_id', Auth::user()->id)->first();
		$planteles_validos = $empleado->plantels->pluck('razon', 'id');
		return view('asignacionAcademicas.reportes.actaCalificaciones', compact('planteles_validos'))
			->with('list', AsignacionAcademica::getListFromAllRelationApps());
	}

	public function actaCalificacionesR(Request $request)
	{
		$datos = $request->all();
		//dd($datos);
		/*if($datos['ponderacion_f']==0){
			DB::table('carga_ponderacions as cp')
                ->select('cp.id', 'cp.name')
                ->where('cp.ponderacion_id', '=', $datos['']materium->ponderacion_id)
                ->where('cp.id', '>', '0')
                ->where('cp.bnd_activo', 1)
                ->distinct()
                ->get();
		}*/
		$numero = 0;
		$array_ponderaciones = array();
		if ($datos['ponderacion_f'] <> 0) {
			$carga_ponderacion = CargaPonderacion::find($datos['ponderacion_f']);
			$cadena = explode(" ", $carga_ponderacion->name);
			//dd($cadena);
			$numero = $cadena[count($cadena) - 1];
			//dd($numero);
			$ponderaciones = CargaPonderacion::where('ponderacion_id', $carga_ponderacion->ponderacion_id)
				->get();
			//dd($ponderaciones);


			foreach ($ponderaciones as $p) {
				array_push($array_ponderaciones, $p->id);
			}
		}

		$nomenclatura = array("", 'PRIMER', 'SEGUNDO', 'TERCERO', 'CUARTO', 'QUINTO', 'SEXTO', 'SEPTIMO', 'OCTAVO', 'NOVENO', 'DECIMO');
		//dd($nomenclatura[$numero]);
		$asignacion_academica = AsignacionAcademica::where('plantel_id', $datos['plantel_f'])
			->where('lectivo_id', $datos['lectivo_f'])
			->where('grupo_id', $datos['grupo_f'])
			->where('materium_id', $datos['materia_f'])
			->whereNull('deleted_at')
			->first();
		//dd($asignacion_academica->docenteOficial);
		$encabezado = Hacademica::where('plantel_id', $datos['plantel_f'])
			->where('lectivo_id', $datos['lectivo_f'])
			->where('grupo_id', $datos['grupo_f'])
			->where('materium_id', $datos['materia_f'])
			->whereNull('deleted_at')
			->first();
		//dd($encabezado);
		$alumnos = Hacademica::where('plantel_id', $datos['plantel_f'])
			->where('lectivo_id', $datos['lectivo_f'])
			->where('grupo_id', $datos['grupo_f'])
			->where('materium_id', $datos['materia_f'])
			->whereNull('deleted_at')
			->get();
		$formatter = new NumeroALetras;
		//dd($alumnos);
		//dd($numero);
		return view(
			'asignacionAcademicas.reportes.actaCalificacionesR',
			compact('datos', 'encabezado', 'alumnos', 'asignacion_academica', 'array_ponderaciones', 'formatter', 'numero', 'nomenclatura')
		);
	}

	public function actaExtraordinarios()
	{
		$empleado = Empleado::where('user_id', Auth::user()->id)->first();
		$planteles = $empleado->plantels->pluck('razon', 'id');
		$lectivos = Lectivo::pluck('name', 'id');
		$materias = Materium::pluck('name', 'id');
		//$grupos=Grupo::pluck('name','id');
		return view(
			'asignacionAcademicas.reportes.actaExtraordinarios',
			compact('planteles', 'lectivos', 'materias')
		);
	}

	public function actaExtraordinariosR(Request $request)
	{
		$datos = $request->all();
		$encabezado = Hacademica::select(
			'hacademicas.materium_id',
			'm.bnd_tiene_nombre_oficial',
			'm.nombre_oficial',
			'm.name as materia',
			'cali.fecha',
			'm.codigo',
			'l.periodo_escolar',
			'l.ciclo_escolar',
			'e.imagen',
			'g.denominacion',
			'g.name as grado',
			'g.fec_rvoe',
			'g.rvoe',
			'g.cct',
			'hacademicas.plantel_id',
			'cali.lectivo_id',
			'hacademicas.id as hacademica_id',
			'l.fin'
		)
			->join('materia as m', 'm.id', '=', 'hacademicas.materium_id')
			->join('calificacions as cali', 'cali.hacademica_id', '=', 'hacademicas.id')
			->join('lectivos as l', 'l.id', 'cali.lectivo_id')
			//->join('inscripcions as i','i.id','hacademicas.inscripcion_id')
			->join('especialidads as e', 'e.id', 'hacademicas.especialidad_id')
			->join('grados as g', 'g.id', 'hacademicas.grado_id')
			->where('hacademicas.plantel_id', $datos['plantel_f'])
			->where('hacademicas.materium_id', $datos['materia_f'])
			->where('cali.lectivo_id', $datos['lectivo_f'])
			//->where('hacademicas.grupo_id',$datos['grupo_f'])
			//->where('hacademicas.materium_id',$datos['materia_f'])
			->where('tpo_examen_id', 2)
			->whereNull('hacademicas.deleted_at')
			->whereNull('cali.deleted_at')
			->orderBy('m.codigo')
			->distinct()
			->first();
		//dd($encabezados->toArray());
		/*foreach($calificaciones as $c){
			$encabezado=Inscripcion::find($c->inscripcion_id);
			$hacademica=Hacademica::find($c->hacademica_id);
			break;
		}*/
		//dd($hacademica);
		//dd($calificaciones->toArray());
		return view(
			'asignacionAcademicas.reportes.actaExtraordinariosR',
			compact('encabezado', 'datos')
		);
	}

	public function listaAsignaciones(Request $request)
	{
		$asignaciones = AsignacionAcademica::select(
			'asignacion_academicas.id as asignacion_id',
			'e.id as d_id',
			'e.nombre as d_nombre',
			'e.ape_paterno as d_ape_paterno',
			'e.ape_materno as d_ape_materno',
			'p.id as plantel_id',
			'p.razon',
			'l.id as lectivo_id',
			'l.name as lectivo',
			'm.id as materia_id',
			'm.name as materia',
			'g.id as grupo_id',
			'g.name as grupo',
			'do.id as do_id',
			'do.nombre as do_nombre',
			'do.ape_paterno as do_ape_paterno',
			'do.ape_materno as do_ape_materno',
			'lo.id as lo_lectivo_id',
			'lo.name as lo_lectivo'
		)
			->join('empleados as e', 'e.id', 'asignacion_academicas.empleado_id')
			->join('plantels as p', 'p.id', 'asignacion_academicas.plantel_id')
			->join('lectivos as l', 'l.id', 'asignacion_academicas.lectivo_id')
			->join('materia as m', 'm.id', 'asignacion_academicas.materium_id')
			->join('grupos as g', 'g.id', 'asignacion_academicas.grupo_id')
			->join('empleados as do', 'do.id', 'asignacion_academicas.docente_oficial_id')
			->join('lectivos as lo', 'lo.id', 'asignacion_academicas.lectivo_oficial_id')
			->whereNull('asignacion_academicas.deleted_at')
			->whereIn('asignacion_academicas.plantel_id', $request->input('plantel'))
			->get();
		//dd($asignaciones);
		$plantels = Plantel::pluck('razon', 'id');
		return view('combinacionClientes.reportes.cargas', compact('asignaciones', 'plantels'));
	}

	public function formatoHorario()
	{
		$plantels = Plantel::pluck('razon', 'id');
		return view('asignacionAcademcas.reportes.formatoHorario', compact('plantels'));
	}

	public function formatoHorarioR(Request $request)
	{

		return view('asignacionAcademcas.reportes.formatoHorarioR', compact('plantels'));
	}

	public function clasesDocentes()
	{
		return view('asignacionAcademicas.reportes.clasesDocentes')
			->with('list', AsignacionAcademica::getListFromAllRelationApps());
	}

	public function clasesDocentesR(Request $request)
	{
		$input = $request->all();

		$horarios = AsignacionAcademica::select(
			'fec_inicio as asignacion_inicio',
			'fec_fin as asignacion_fin',
			DB::raw("concat(e.nombre,' ',e.ape_paterno,' ',e.ape_materno) as empleado"),
			'asignacion_academicas.id as asignacion_academica_id',
			//'pe.id as periodo_estudio_id',
			'p.razon as plantel',
			'm.name as materia',
			'g.name as grupo',
			'l.name as lectivo',
			'l.inicio',
			'l.fin'
			//DB::raw('concat(d.id,"-",d.name) as dia'),
			//'h.hora'
			//'pe.name as periodo_estudio'
		)
			->join('empleados as e', 'e.id', '=', 'asignacion_academicas.empleado_id')
			->join('plantels as p', 'p.id', '=', 'asignacion_academicas.plantel_id')
			->join('materia as m', 'm.id', '=', 'asignacion_academicas.materium_id')
			->join('grupos as g', 'g.id', '=', 'asignacion_academicas.grupo_id')
			->join('lectivos as l', 'l.id', '=', 'asignacion_academicas.lectivo_id')
			->with('horarios')
			//->join('horarios as h', 'h.asignacion_academica_id', '=', 'asignacion_academicas.id')
			//->join('dias as d', 'd.id', '=', 'h.dia_id')
			//->join('periodo_estudios as pe','pe.plantel_id','asignacion_academicas.plantel_id')
			//->join('materium_periodos as mp','mp.periodo_estudio_id','pe.id')
			//->whereColumn('m.id','mp.materium_id')
			->where('p.id', '=', $input['plantel_f'])
			//->where('pe.grado_id', '=', $input['grado_id'])			
			//->where('g.id', '=', $input['grupo_f'])
			->where('l.id', $input['lectivo_f'])
			//->whereNull('h.deleted_at')
			->orderBy('plantel')
			->orderBy('lectivo')
			->orderBy('grupo')
			->orderBy('materia')
			->orderBy('empleado')
			->orderBy('materia')
			//->orderBy('d.id')
			//->orderBy('hora')

			//->groupBy('esp.meta','e.nombre', 'e.ape_paterno', 'e.ape_materno')
			->get();
		//dd($horarios);
		$resultados = array();
		foreach ($horarios as $horario) {
			$registro = array();
			//dd($horario);
			$registro['asignacion_academica_id'] = $horario->asignacion_academica_id;
			$registro['plantel'] = $horario->plantel;
			$registro['empleado'] = $horario->empleado;
			$registro['lectivo'] = $horario->lectivo;
			$registro['inicio'] = $horario->inicio;
			$registro['fin'] = $horario->fin;
			$registro['grupo'] = $horario->grupo;
			$registro['materia'] = $horario->materia;
			//dd($horario->horarios);
			$registro['duracion_clases_total']=0;
			//dd($horarios);
			
			$registro['fecha_clase']=array();

			////
			$dias = array();
			$horarios = Horario::where('asignacion_academica_id', $horario->asignacion_academica_id)
							->get();
			//dd($asignacion);
			foreach ($horarios as $h) {
				array_push($dias, $h->dia->name);
			}
			//dd($dias);

			$fechas = array();
			
			$diasNoHabiles = DiaNoHabil::distinct()
				->where('fecha', '>=', $registro['inicio'])
				->where('fecha', '<=', $registro['fin'])
				->get();

			$no_habiles = array();
			foreach ($diasNoHabiles as $no_habil) {
				array_push($no_habiles, Carbon::createFromFormat('Y-m-d', $no_habil->fecha));
			}
			//dd($horario);
			$pinicio = Carbon::createFromFormat('Y-m-d', $horario->asignacion_inicio);
			$pfin = Carbon::createFromFormat('Y-m-d', $horario->asignacion_fin);

			
			while ($pfin->greaterThanOrEqualTo($pinicio)) {
				//dd($pinicio);
				if (in_array('Lunes', $dias)) {
					//dd($horario);
					if($horario->asignacion_academica_id==19984 and $pinicio->toDateString()=="2025-03-03"){
						//dd($pinicio);
					}
					if ($pinicio->isMonday() and !in_array($pinicio, $no_habiles)) {
						$asistencias=AsistenciaR::where('fecha', $pinicio->toDateString())
						->where('asignacion_academica_id', $horario->asignacion_academica_id)
						->where('est_asistencia_id',1)
						->count();
						if($asistencias>0){
							$horarios = Horario::where('asignacion_academica_id', $horario->asignacion_academica_id)
							->where('dia_id', 1)
							->get();
							foreach($horarios as $horario){
								$registro['duracion_clases_total']=$registro['duracion_clases_total']+$horario->duracion_clase;
							}
							
							array_push($fechas, $pinicio->toDateString());
						}
					}
					//dd($fechas);
				}
				if (in_array('Martes', $dias)) {
					//dd("hay martes");
					if ($pinicio->isTuesday() and !in_array($pinicio, $no_habiles)) {
						$asistencias=AsistenciaR::where('fecha', $pinicio->toDateString())
						->where('asignacion_academica_id', $horario->asignacion_academica_id)
						->where('est_asistencia_id',1)
						->count();
						if($asistencias>0){
							$horarios = Horario::where('asignacion_academica_id', $horario->asignacion_academica_id)
							->where('dia_id', 1)
							->get();
							foreach($horarios as $horario){
								$registro['duracion_clases_total']=$registro['duracion_clases_total']+$horario->duracion_clase;
							}
							array_push($fechas, $pinicio->toDateString());
						}
					}
				}
				if (in_array('Miercoles', $dias)) {
					//dd("hay miercoles");
					if ($pinicio->isWednesday() and !in_array($pinicio, $no_habiles)) {
						$asistencias=AsistenciaR::where('fecha', $pinicio->toDateString())
						->where('asignacion_academica_id', $horario->asignacion_academica_id)
						->where('est_asistencia_id',1)
						->count();
						if($asistencias>0){
							$horarios = Horario::where('asignacion_academica_id', $horario->asignacion_academica_id)
							->where('dia_id', 1)
							->get();
							foreach($horarios as $horario){
								$registro['duracion_clases_total']=$registro['duracion_clases_total']+$horario->duracion_clase;
							}
							array_push($fechas, $pinicio->toDateString());
						}
					}
				}
				if (in_array('Jueves', $dias)) {
					//dd("hay jueves");
					if ($pinicio->isThursday() and !in_array($pinicio, $no_habiles)) {
						$asistencias=AsistenciaR::where('fecha', $pinicio->toDateString())
						->where('asignacion_academica_id', $horario->asignacion_academica_id)
						->where('est_asistencia_id',1)
						->count();
						if($asistencias>0){
							$horarios = Horario::where('asignacion_academica_id', $horario->asignacion_academica_id)
							->where('dia_id', 1)
							->get();
							foreach($horarios as $horario){
								$registro['duracion_clases_total']=$registro['duracion_clases_total']+$horario->duracion_clase;
							}
							array_push($fechas, $pinicio->toDateString());
						}
					}
				}
				if (in_array('Viernes', $dias)) {
					//dd($pinicio->toDateString());
					
					if ($pinicio->isFriday() and !in_array($pinicio, $no_habiles)) {
						$asistencias=AsistenciaR::where('fecha', $pinicio->toDateString())
						->where('asignacion_academica_id', $horario->asignacion_academica_id)
						->where('est_asistencia_id',1)
						->count();
						//dd($asistencias);
						if($asistencias>0){
							//dd($horario);
							$horarios = Horario::where('asignacion_academica_id', $horario->asignacion_academica_id)
							->where('dia_id', 1)
							->get();
							foreach($horarios as $horario){
								$registro['duracion_clases_total']=$registro['duracion_clases_total']+$horario->duracion_clase;
							}
							array_push($fechas, $pinicio->toDateString());
						}
					}
				}
				if (in_array('Sabado', $dias)) {

					if ($pinicio->isSaturday() and !in_array($pinicio, $no_habiles)) {
						$asistencias=AsistenciaR::where('fecha', $pinicio->toDateString())
						->where('asignacion_academica_id', $horario->asignacion_academica_id)
						->where('est_asistencia_id',1)
						->count();
						if($asistencias>0){
							$horarios = Horario::where('asignacion_academica_id', $horario->asignacion_academica_id)
							->where('dia_id', 1)
							->get();
							foreach($horarios as $horario){
								$registro['duracion_clases_total']=$registro['duracion_clases_total']+$horario->duracion_clase;
							}
							array_push($fechas, $pinicio->toDateString());
						}
					}
				}
				if (in_array('Domingo', $dias)) {

					if ($pinicio->isSunday() and !in_array($pinicio, $no_habiles)) {
						$asistencias=AsistenciaR::where('fecha', $pinicio->toDateString())
						->where('asignacion_academica_id', $horario->asignacion_academica_id)
						->where('est_asistencia_id',1)
						->count();
						if($asistencias>0){
							$horarios = Horario::where('asignacion_academica_id', $horario->asignacion_academica_id)
							->where('dia_id', 1)
							->get();
							foreach($horarios as $horario){
								$registro['duracion_clases_total']=$registro['duracion_clases_total']+$horario->duracion_clase;
							}
							array_push($fechas, $pinicio->toDateString());
						}
					}
				}
				$pinicio->addDay();
				//dd($fechas);
			}
			//dd($fechas);
			//if(is_array($fechas)){
				array_push($registro['fecha_clase'], $fechas);	
			//}
			
			//dd($fechas);
			array_push($resultados, $registro);////
		}
		//dd($resultados);
		return view(
			'asignacionAcademicas.reportes.clasesDocentesR',
			compact('resultados',  'input')
		)
			->with('datos', json_encode($horarios));
	}
}
