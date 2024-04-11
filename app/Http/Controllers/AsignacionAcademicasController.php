<?php

namespace App\Http\Controllers;

use DB;
use Auth;

use App\Grupo;
use App\Cliente;
use App\Horario;
use App\Lectivo;
use App\Plantel;
use App\Empleado;
use App\Materium;
use App\Hacademica;
use App\AsistenciaR;
use App\Inscripcion;
use App\Http\Requests;
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
		return view('asignacionAcademicas.create')
			->with('list', AsignacionAcademica::getListFromAllRelationApps());
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
	public function duplicate($id, AsignacionAcademica $asignacionAcademica)
	{
		$asignacionAcademica = $asignacionAcademica->find($id);
		return view('asignacionAcademicas.duplicate', compact('asignacionAcademica'))
			->with('list', AsignacionAcademica::getListFromAllRelationApps());
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
		$fecha = date('d-m-Y');
		//dd($request->all());
		$horarios = AsignacionAcademica::select(
			DB::raw("concat(e.nombre,' ',e.ape_paterno,' ',e.ape_materno) as empleado"),
			'p.razon as plantel',
			'm.name as materia',
			'g.name as grupo',
			'l.name as lectivo',
			DB::raw('concat(d.id,"-",d.name) as dia'),
			'h.hora'
		)
			->join('empleados as e', 'e.id', '=', 'asignacion_academicas.empleado_id')
			->join('plantels as p', 'p.id', '=', 'asignacion_academicas.plantel_id')
			->join('materia as m', 'm.id', '=', 'asignacion_academicas.materium_id')
			->join('grupos as g', 'g.id', '=', 'asignacion_academicas.grupo_id')
			->join('lectivos as l', 'l.id', '=', 'asignacion_academicas.lectivo_id')
			->join('horarios as h', 'h.asignacion_academica_id', '=', 'asignacion_academicas.id')
			->join('dias as d', 'd.id', '=', 'h.dia_id')
			//->where('asignacion_academicas.plantel_id', '>=', $input['plantel_f'])
			->where('asignacion_academicas.grupo_id', '=', $input['grupo_f'])
			//->where('asignacion_academicas.lectivo_id', '<=', $input['lectivo_f'])
			->whereNull('h.deleted_at')
			->orderBy('d.id')
			->orderBy('Plantel')
			//->groupBy('esp.meta','e.nombre', 'e.ape_paterno', 'e.ape_materno')
			->get();

		//dd($horarios->toArray());
		/*PDF::setOptions(['defaultFont' => 'arial']);
			$pdf = PDF::loadView('seguimientos.reportes.seguimientosXespecialidadGr', array('seguimientos'=>$seguimientos, 'fecha'=>$fecha, 'datos'=>json_encode($datos)))
						->setPaper('letter', 'landscape');
			return $pdf->download('reporte.pdf');
			*/
		return view('asignacionAcademicas.reportes.horarioGrupoR', array('fecha' => $fecha))
			->with('datos', json_encode($horarios));

		/*Excel::create('Laravel Excel', function($excel) use($seguimientos) {
				$excel->sheet('Productos', function($sheet) use($seguimientos) {
					$sheet->fromArray($seguimientos);
				});
			})->export('xls');
			*/
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
		$numero=0;
		$array_ponderaciones = array();
		if($datos['ponderacion_f']<>0){
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
		
		$nomenclatura = array("",'PRIMER', 'SEGUNDO', 'TERCERO', 'CUARTO', 'QUINTO', 'SEXTO', 'SEPTIMO', 'OCTAVO', 'NOVENO', 'DECIMO');
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

	public function actaExtraordinarios(){
		$empleado = Empleado::where('user_id', Auth::user()->id)->first();
		$planteles = $empleado->plantels->pluck('razon', 'id');
		$lectivos=Lectivo::pluck('name','id');
		$materias=Materium::pluck('name','id');
		//$grupos=Grupo::pluck('name','id');
		return view('asignacionAcademicas.reportes.actaExtraordinarios', 
		compact('planteles','lectivos','materias'));
	}

	public function actaExtraordinariosR(Request $request){
		$datos=$request->all();
		$encabezado=Hacademica::select('hacademicas.materium_id','m.bnd_tiene_nombre_oficial','m.nombre_oficial','m.name as materia','cali.fecha','m.codigo',
		'l.periodo_escolar','l.ciclo_escolar','e.imagen','g.denominacion', 'g.name as grado','g.fec_rvoe',
		'g.rvoe','g.cct','hacademicas.plantel_id','cali.lectivo_id','hacademicas.id as hacademica_id','l.fin')
		->join('materia as m','m.id','=','hacademicas.materium_id')
		->join('calificacions as cali','cali.hacademica_id','=','hacademicas.id')
		->join('lectivos as l','l.id','cali.lectivo_id')
		//->join('inscripcions as i','i.id','hacademicas.inscripcion_id')
		->join('especialidads as e','e.id','hacademicas.especialidad_id')
		->join('grados as g','g.id','hacademicas.grado_id')
		->where('hacademicas.plantel_id',$datos['plantel_f'])
		->where('hacademicas.materium_id',$datos['materia_f'])
		->where('cali.lectivo_id',$datos['lectivo_f'])
		//->where('hacademicas.grupo_id',$datos['grupo_f'])
		//->where('hacademicas.materium_id',$datos['materia_f'])
		->where('tpo_examen_id',2)
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
		return view('asignacionAcademicas.reportes.actaExtraordinariosR', 
		compact('encabezado', 'datos'));
	}

	public function listaAsignaciones(Request $request){
		$asignaciones= AsignacionAcademica::select('asignacion_academicas.id as asignacion_id','e.id as d_id','e.nombre as d_nombre',
		'e.ape_paterno as d_ape_paterno', 'e.ape_materno as d_ape_materno','p.id as plantel_id','p.razon',
		'l.id as lectivo_id','l.name as lectivo','m.id as materia_id','m.name as materia','g.id as grupo_id',
		'g.name as grupo','do.id as do_id','do.nombre as do_nombre',
		'do.ape_paterno as do_ape_paterno', 'do.ape_materno as do_ape_materno','lo.id as lo_lectivo_id',
		'lo.name as lo_lectivo')
		->join('empleados as e','e.id','asignacion_academicas.empleado_id')
		->join('plantels as p','p.id','asignacion_academicas.plantel_id')
		->join('lectivos as l','l.id','asignacion_academicas.lectivo_id')
		->join('materia as m','m.id','asignacion_academicas.materium_id')
		->join('grupos as g','g.id','asignacion_academicas.grupo_id')
		->join('empleados as do','do.id','asignacion_academicas.docente_oficial_id')
		->join('lectivos as lo','lo.id','asignacion_academicas.lectivo_oficial_id')
		->whereNull('asignacion_academicas.deleted_at')
		->whereIn('asignacion_academicas.plantel_id',$request->input('plantel'))
		->get();
			//dd($asignaciones);
			$plantels=Plantel::pluck('razon','id');
		return view('combinacionClientes.reportes.cargas', compact('asignaciones','plantels'));
	}
}
