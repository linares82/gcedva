<?php

namespace App\Http\Controllers;

use App\CalendarioAsignacionPonderacion;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\createCalendarioAsignacionPonderacion;
use App\Http\Requests\updateCalendarioAsignacionPonderacion;
use App\Lectivo;
use App\Plantel;
use Auth;
use Illuminate\Http\Request;

class CalendarioAsignacionPonderacionsController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$calendarioAsignacionPonderacions = CalendarioAsignacionPonderacion::getAllData($request);

		return view('calendarioAsignacionPonderacions.index', compact('calendarioAsignacionPonderacions'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('calendarioAsignacionPonderacions.create')
			->with('list', CalendarioAsignacionPonderacion::getListFromAllRelationApps());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createCalendarioAsignacionPonderacion $request)
	{

		$input = $request->all();
		$input['usu_alta_id'] = Auth::user()->id;
		$input['usu_mod_id'] = Auth::user()->id;

		//create data
		CalendarioAsignacionPonderacion::create($input);

		return redirect()->route('calendarioAsignacionPonderacions.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, CalendarioAsignacionPonderacion $calendarioAsignacionPonderacion)
	{
		$calendarioAsignacionPonderacion = $calendarioAsignacionPonderacion->find($id);
		return view('calendarioAsignacionPonderacions.show', compact('calendarioAsignacionPonderacion'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, CalendarioAsignacionPonderacion $calendarioAsignacionPonderacion)
	{
		$calendarioAsignacionPonderacion = $calendarioAsignacionPonderacion->find($id);
		return view('calendarioAsignacionPonderacions.edit', compact('calendarioAsignacionPonderacion'))
			->with('list', CalendarioAsignacionPonderacion::getListFromAllRelationApps());
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, CalendarioAsignacionPonderacion $calendarioAsignacionPonderacion)
	{
		$calendarioAsignacionPonderacion = $calendarioAsignacionPonderacion->find($id);
		return view('calendarioAsignacionPonderacions.duplicate', compact('calendarioAsignacionPonderacion'))
			->with('list', CalendarioAsignacionPonderacion::getListFromAllRelationApps());
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, CalendarioAsignacionPonderacion $calendarioAsignacionPonderacion, updateCalendarioAsignacionPonderacion $request)
	{
		$input = $request->all();
		$input['usu_mod_id'] = Auth::user()->id;
		//update data
		$calendarioAsignacionPonderacion = $calendarioAsignacionPonderacion->find($id);
		$calendarioAsignacionPonderacion->update($input);

		return redirect()->route('calendarioAsignacionPonderacions.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id, CalendarioAsignacionPonderacion $calendarioAsignacionPonderacion)
	{
		$calendarioAsignacionPonderacion = $calendarioAsignacionPonderacion->find($id);
		$asignacion = $calendarioAsignacionPonderacion->asignacion_id;
		$calendarioAsignacionPonderacion->delete();

		return redirect()->route('asignacionAcademicas.edit', $asignacion)->with('message', 'Registro Borrado.');
	}

	public function cambioXcalendario()
	{
		$planteles = Plantel::pluck('razon', 'id');

		$lectivos = Lectivo::pluck('name', 'id');
		return view('calendarioAsignacionPonderacions.reportes.cambioXcalendario', compact('planteles', 'lectivos'));
	}

	public function cambioXcalendarioR(Request $request)
	{
		$datos = $request->all();
		//dd($datos);

		$registros = CalendarioAsignacionPonderacion::select(
			'aa.id as asignacion_id',
			'p.razon',
			'l.name as lectivo',
			'calendario_asignacion_ponderacions.fec_inicio',
			'calendario_asignacion_ponderacions.fec_fin',
			'aa.plantel_id',
			'aa.lectivo_id',
			'aa.grupo_id',
			'aa.materium_id',
			'calif.id as calificacion_id',
			'h.id as hacadamica_id',
			'hcalif.calificacion_parcial_anterior',
			'hcalif.calificacion_parcial_actual',
			'u.name as usu_alta',
			'd.nombre',
			'd.ape_paterno',
			'd.ape_materno',
			'm.name as materia',
			'hcalif.created_at',
			'h.cliente_id',
			'cponde.name as carga_ponderacion'
		)
			->join('carga_ponderacions as cponde', 'cponde.id', 'calendario_asignacion_ponderacions.carga_ponderacion_id')
			->join('users as u', 'u.id', 'calendario_asignacion_ponderacions.usu_alta_id')
			->join('asignacion_academicas as aa', 'aa.id', 'calendario_asignacion_ponderacions.asignacion_id')
			->join('empleados as d', 'd.id', 'aa.empleado_id')
			->join('carga_ponderacions as cp', 'cp.id', 'calendario_asignacion_ponderacions.carga_ponderacion_id')
			->join('lectivos as l', 'l.id', 'aa.lectivo_id')
			->join('plantels as p', 'p.id', 'aa.plantel_id')
			->join('hacademicas as h', 'h.plantel_id', 'aa.plantel_id')
			->join('materia as m', 'm.id', 'aa.materium_id')
			->whereColumn('h.grupo_id', 'aa.grupo_id')
			->whereColumn('h.lectivo_id', 'aa.lectivo_id')
			->whereColumn('h.materium_id', 'aa.materium_id')
			->join('calificacions as calif', 'calif.hacademica_id', 'h.id')
			->join('calificacion_ponderacions as cpon', 'cpon.calificacion_id', 'calif.id')
			->join('h_calificacions as hcalif', 'hcalif.calificacion_id', 'calif.id')
			//->whereColumn('hcalif.calificacion_ponderacion_id', 'calendario_asignacion_ponderacions.carga_ponderacion_id')
			->where('calif.tpo_examen_id', 1)
			->where('aa.plantel_id', $datos['plantel_f'])
			->where('aa.lectivo_id', $datos['lectivo_f'])
			->whereColumn('hcalif.created_at', '>=', 'calendario_asignacion_ponderacions.fec_inicio')
			->whereColumn('hcalif.created_at', '<=', 'calendario_asignacion_ponderacions.fec_fin')
			->get();
		//dd($calendarios->toArray());

		return view('calendarioAsignacionPonderacions.reportes.cambioXcalendarioR', compact('registros'));

		//dd($registros->toArray());

	}
}
