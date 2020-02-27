<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\DiaNoHabil;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateDiaNoHabil;
use App\Http\Requests\createDiaNoHabil;
use App\Lectivo;

class DiaNoHabilsController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$diaNoHabils = DiaNoHabil::getAllData($request);

		return view('diaNoHabils.index', compact('diaNoHabils'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('diaNoHabils.create')
			->with('list', DiaNoHabil::getListFromAllRelationApps());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createDiaNoHabil $request)
	{

		$input = $request->all();
		// 	($input);
		$input['usu_alta_id'] = Auth::user()->id;
		$input['usu_mod_id'] = Auth::user()->id;

		//create data
		DiaNoHabil::create($input);
		$lectivos = Lectivo::whereDate('inicio', '<=', $input['fecha'])->whereDate('fin', '>=', $input['fecha'])->get();
		foreach ($lectivos as $lectivo) {
			app('App\Http\Controllers\LectivosController')->calculaAsistencias($lectivo->id);
		}

		//return redirect()->route('lectivos.show', $input['lectivo_id'])->with('message', 'Registro Creado.');
		return redirect()->back();
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, DiaNoHabil $diaNoHabil)
	{
		$diaNoHabil = $diaNoHabil->find($id);
		return view('diaNoHabils.show', compact('diaNoHabil'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, DiaNoHabil $diaNoHabil)
	{
		$diaNoHabil = $diaNoHabil->find($id);
		return view('diaNoHabils.edit', compact('diaNoHabil'))
			->with('list', DiaNoHabil::getListFromAllRelationApps());
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, DiaNoHabil $diaNoHabil)
	{
		$diaNoHabil = $diaNoHabil->find($id);
		return view('diaNoHabils.duplicate', compact('diaNoHabil'))
			->with('list', DiaNoHabil::getListFromAllRelationApps());
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, DiaNoHabil $diaNoHabil, updateDiaNoHabil $request)
	{
		$input = $request->all();
		$input['usu_mod_id'] = Auth::user()->id;
		//update data
		$diaNoHabil = $diaNoHabil->find($id);
		$diaNoHabil->update($input);

		return redirect()->route('diaNoHabils.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id, DiaNoHabil $diaNoHabil)
	{
		$diaNoHabil = $diaNoHabil->find($id);
		$fecha = $diaNoHabil->fecha;
		$diaNoHabil->delete();
		$lectivos = Lectivo::whereDate('inicio', '<=', $fecha)->whereDate('fin', '>=', $fecha)->get();
		foreach ($lectivos as $lectivo) {
			app('App\Http\Controllers\LectivosController')->calculaAsistencias($lectivo->id);
		}
		return redirect()->back();
		//return redirect()->route('lectivos.show', $lectivo)->with('message', 'Registro Borrado.');
	}
}
