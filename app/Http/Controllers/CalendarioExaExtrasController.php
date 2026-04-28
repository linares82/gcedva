<?php

namespace App\Http\Controllers;

use App\CalendarioExaExtra;
use App\Calificacion;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\createCalendarioExaExtra;
use App\Http\Requests\updateCalendarioExaExtra;
use Auth;
use DB;
use Illuminate\Http\Request;

class CalendarioExaExtrasController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$calendarioExaExtras = CalendarioExaExtra::getAllData($request);

		return view('calendarioExaExtras.index', compact('calendarioExaExtras'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('calendarioExaExtras.create')
			->with('list', CalendarioExaExtra::getListFromAllRelationApps());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createCalendarioExaExtra $request)
	{

		$input = $request->all();
		$input['usu_alta_id'] = Auth::user()->id;
		$input['usu_mod_id'] = Auth::user()->id;

		//create data
		CalendarioExaExtra::create($input);

		return redirect()->route('calendarioExaExtras.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, CalendarioExaExtra $calendarioExaExtra)
	{
		$calendarioExaExtra = $calendarioExaExtra->find($id);
		return view('calendarioExaExtras.show', compact('calendarioExaExtra'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, CalendarioExaExtra $calendarioExaExtra)
	{
		$calendarioExaExtra = $calendarioExaExtra->find($id);
		return view('calendarioExaExtras.edit', compact('calendarioExaExtra'))
			->with('list', CalendarioExaExtra::getListFromAllRelationApps());
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, CalendarioExaExtra $calendarioExaExtra)
	{
		$calendarioExaExtra = $calendarioExaExtra->find($id);
		return view('calendarioExaExtras.duplicate', compact('calendarioExaExtra'))
			->with('list', CalendarioExaExtra::getListFromAllRelationApps());
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, CalendarioExaExtra $calendarioExaExtra, updateCalendarioExaExtra $request)
	{
		$input = $request->all();
		$input['usu_mod_id'] = Auth::user()->id;
		//update data
		$calendarioExaExtra = $calendarioExaExtra->find($id);
		$calendarioExaExtra->update($input);

		return redirect()->route('calendarioExaExtras.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id, CalendarioExaExtra $calendarioExaExtra)
	{
		$calendarioExaExtra = $calendarioExaExtra->find($id);
		$calendarioExaExtra->delete();

		return redirect()->route('calendarioExaExtras.index')->with('message', 'Registro Borrado.');
	}

	public function getUltimoCalendarioXDuracionPlantel(Request $request)
	{
		$datos = $request->all();
		$calendario = CalendarioExaExtra::where('plantel_id', $datos['plantel_id'])
			->where('duracion_periodo_id', $datos['duracion_id'])
			->orderBy('id', 'DESC')
			->whereDate('fec_fin', '>=', date('Y-m-d'))
			->first();

		if (!is_null($calendario)) {
			$consulta_extras = Calificacion::select(
				'l.name as lectivo',
				'm.name as materia',
				'm.caja_concepto_id',
				'te.name as tipo_evaluacion',
				'calificacions.fecha',
				'calificacions.calificacion',
				'calificacions.id as calificacion_id',
				'h.cliente_id',
				DB::raw('(select count(c.id) from cajas as c inner join caja_lns as cl on cl.caja_id=c.id inner join calificacions as calif on calif.id=cl.calificacion_id inner join hacademicas as h2 on h2.id=calif.hacademica_id where c.st_caja_id=1 and date(c.fecha)>="' . $calendario->fec_inicio . '" and date(c.fecha)<="' . $calendario->fec_fin . '" and cl.caja_concepto_id=m.caja_concepto_id and h2.materium_id=h.materium_id and c.cliente_id=h.cliente_id and cl.deleted_at is null) as cajas_existentes')
			)
				->join('hacademicas as h', 'h.id', 'calificacions.hacademica_id')
				->join('lectivos as l', 'l.id', 'calificacions.lectivo_id')
				->join('materia as m', 'm.id', 'h.materium_id')
				->join('tpo_examens as te', 'te.id', '=', 'calificacions.tpo_examen_id')
				//->where('h.materium_id', $hacademica->materium_id)
				->where('h.cliente_id', $datos['cliente_id'])
				->where('calificacions.lectivo_id', $calendario->lectivo_id)
				->whereDate('calificacions.fecha', '>=', $calendario->fec_inicio)
				->whereDate('calificacions.fecha', '<=', $calendario->fec_fin)
				->where('tpo_examen_id', 2)
				->get();
			//dd($consulta_extras->toArray());
			//$calendario->push($consulta_extras);
			$detalle = $calendario->toArray();
			array_push($detalle, $consulta_extras->toArray());
			//dd($detalle);
		}

		//return $calendario;
		return json_encode($detalle);
	}
}
