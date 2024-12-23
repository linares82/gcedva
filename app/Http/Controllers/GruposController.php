<?php

namespace App\Http\Controllers;

use DB;
use Auth;

use App\Grupo;
use App\Plantel;
use App\Inscripcion;
use App\Http\Requests;
use App\PeriodoEstudio;
use Illuminate\Http\Request;
use App\Http\Requests\createGrupo;
use App\Http\Requests\updateGrupo;
use App\Http\Controllers\Controller;

class GruposController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$grupos = Grupo::getAllData($request);

		return view('grupos.index', compact('grupos'))->with('list', Grupo::getListFromAllRelationApps());
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('grupos.create')
			->with('list', Grupo::getListFromAllRelationApps());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createGrupo $request)
	{

		$input = $request->all();
		
		$input['usu_alta_id'] = Auth::user()->id;
		$input['usu_mod_id'] = Auth::user()->id;
		$periodo_estudio = $input['periodo_estudio_id'];
		$input['periodo_estudio_id'] = 0;

		//create data
		$g = Grupo::create($input);
		if ($periodo_estudio <> 0) {
			$g->periodosEstudio()->attach($periodo_estudio);
		}

		return redirect()->route('grupos.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, Grupo $grupo)
	{
		$grupo = $grupo->find($id);
		return view('grupos.show', compact('grupo'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, Grupo $grupo)
	{
		$grupo = $grupo->find($id);
		//$periodos=PeriodoEstudio::whereIn('' $i->periodo_estudio_id)->materias;
		//$materias=PeriodoEstudio::find($i->periodo_estudio_id)->materias;
		return view('grupos.edit', compact('grupo'))
			->with('list', Grupo::getListFromAllRelationApps());
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, Grupo $grupo)
	{
		$grupo = $grupo->find($id);
		return view('grupos.duplicate', compact('grupo'))
			->with('list', Grupo::getListFromAllRelationApps());
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, Grupo $grupo, updateGrupo $request)
	{

		$input = $request->all();
		//dd($input);
		$input['usu_mod_id'] = Auth::user()->id;
		$periodo_estudio = $input['periodo_estudio_id'];
		$input['periodo_estudio_id'] = 0;

		//update data
		$grupo = $grupo->find($id);
		$grupo->update($input);
		//dd($periodo_estudio);
		if ($periodo_estudio <> 0) {
			$grupo->periodosEstudio()->attach($periodo_estudio);
		}

		return redirect()->route('grupos.edit', $id)->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id, Grupo $grupo)
	{
		$grupo = $grupo->find($id);
		$grupo->delete();

		return redirect()->route('grupos.index')->with('message', 'Registro Borrado.');
	}

	public function getCmbGrupo(Request $request)
	{
		if ($request->ajax()) {
			//dd($request->get('plantel_id'));
			$plantel = $request->get('plantel_id');
			$grupo = $request->get('grupo_id');
			$final = array();
			$r = DB::table('grupos as g')
				->select('g.id', 'g.name')
				->where('g.plantel_id', '=', $plantel)
				->whereNull('g.deleted_at')
				->where('g.id', '>', '0')
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

	public function getDisponibles(Request $request)
	{
		$r = DB::table('grupos as g')->find($request->input('grupo_id'));
		$alumnosInscritos=Inscripcion::where('plantel_id',$request->input('plantel_id'))
		->where('especialidad_id',$request->input('especialidad_id'))
		->where('nivel_id',$request->input('nivel_id'))
		->where('grado_id',$request->input('grado_id'))
		->where('lectivo_id',$request->input('lectivo_id'))
		->where('grupo_id',$request->input('grupo_id'))
		->whereNull('inscripcions.deleted_at')
		->count();
		//dd($alumnosInscritos);
		return $r->limite_alumnos - $alumnosInscritos;
	}

	public function destroyPeriodo(Request $request)
	{
		$input = $request->all();
		//dd($input);
		$grupo = Grupo::find($input['g']);
		$g = $grupo->id;
		//dd($periodo_estudio);
		if ($input['p'] <> 0) {
			$grupo->periodosEstudio()->detach($input['p']);
		}

		return redirect()->route('grupos.edit', $g)->with('message', 'Registro Actualizado.');
	}

	public function cbmPeriodosEstudio(Request $request)
	{
		$datos = $request->all();
		if ($request->ajax()) {
			//dd($request->get('plantel_id'));
			$grupo = $request->get('grupo');
			$periodo = $request->get('periodo');
			$final = array();
			$r = DB::table('grupos as g')
				->join('grupo_periodo_estudios as gp', 'gp.grupo_id', '=', 'g.id')
				->join('periodo_estudios as p', 'p.id', '=', 'gp.periodo_estudio_id')
				->select('p.id', 'p.name')
				->where('g.id', '=', $grupo)
				->where('g.id', '>', '0')
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

	public function listaGrupos(Request $request)
	{
		$grupos = Grupo::whereIn('plantel_id',$request->input('plantel'))->orderBy('plantel_id')->orderBy('id')->get();
		$plantels=Plantel::pluck('razon','id');
		return view('combinacionClientes.reportes.cargas', compact('grupos','plantels'));
	}

	public function gruposXplantelXasignacion(Request $request)
	{
		if ($request->ajax()) {
			//dd($request->all());
			$plantel = $request->get('plantel_id');
			$lectivo = $request->get('lectivo_id');
			$grupo = $request->get('grupo_id');

			$final = array();
			$r = DB::table('grupos as g')
				->join('asignacion_academicas as aa', 'aa.grupo_id', '=', 'g.id')
				->select('g.id', 'g.name')
				->where('aa.plantel_id', '=', $plantel)
				->where('aa.lectivo_id', '=', $lectivo)
				->where('g.id', '>', '0')
				->whereNull('aa.deleted_at')
				->distinct()
				->get();

			//dd($r);
			if (isset($grupo) and $grupo != 0) {
				foreach ($r as $r1) {
					if ($r1->id == $grupo) {
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

	public function listaMateriasXGrupo(Request $request){
		$lista= Plantel::select('plantels.id as plantel_id', 'plantels.razon', 'g.id as grupo_id', 'g.name AS grupo', 
		'pe.id as periodo_estudio_id', 'pe.name AS periodo_estudio', 'plan.id as plan_estudio_id', 
		'plan.name AS plan_estudio', 'm.id as materia_id', 'm.name AS materia', 'ponde.id AS ponderacion_id',
		'ponde.name AS ponderacion')
		->join('grupos as g','g.plantel_id','plantels.id')
		->join('grupo_periodo_estudios as gpe','gpe.grupo_id','g.id')
		->join('periodo_estudios as pe','pe.id','gpe.periodo_estudio_id')
		->join('plan_estudios as plan','plan.id','pe.plan_estudio_id')
		->join('materium_periodos as mp','mp.periodo_estudio_id','pe.id')
		->join('materia as m','m.id','mp.materium_id')
		->join('ponderacions as ponde','ponde.id','m.ponderacion_id')
		->whereIn('plantels.id',$request->input('plantel'))
		//->whereNull('asignacion_academicas.deleted_at')
		->get();
			//dd($asignaciones);
			$plantels=Plantel::pluck('razon','id');
		return view('combinacionClientes.reportes.cargas', compact('lista','plantels'));
	}

	public function getCmbGrupoXGrado(Request $request)
	{
		if ($request->ajax()) {
			//dd($request->get('plantel_id'));
			$plantel = $request->get('plantel_id');
			$especialidad = $request->get('especialidad_id');
			$nivel = $request->get('nivel_id');
			$grado = $request->get('grado_id');
			$grupo = $request->get('grupo_id');
			$final = array();
			$r = DB::table('grupos as g')
				->select('g.id', 'g.name')
				->join('inscripcions as i','i.grupo_id','g.id')
				->where('i.plantel_id',$plantel)
				->where('i.especialidad_id',$especialidad)
				->where('i.nivel_id',$nivel)
				->where('i.grado_id', '=', $grado)
				->whereNull('g.deleted_at')
				->where('g.id', '>', '0')
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
}
