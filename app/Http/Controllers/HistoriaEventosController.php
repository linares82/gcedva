<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\HistoriaEvento;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateHistoriaEvento;
use App\Http\Requests\createHistoriaEvento;

class HistoriaEventosController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$historiaEventos = HistoriaEvento::getAllData($request);

		return view('historiaEventos.index', compact('historiaEventos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('historiaEventos.create')
			->with('list', HistoriaEvento::getListFromAllRelationApps());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createHistoriaEvento $request)
	{

		$input = $request->all();
		$input['usu_alta_id'] = Auth::user()->id;
		$input['usu_mod_id'] = Auth::user()->id;

		//create data
		HistoriaEvento::create($input);

		return redirect()->route('historiaEventos.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, HistoriaEvento $historiaEvento)
	{
		$historiaEvento = $historiaEvento->find($id);
		return view('historiaEventos.show', compact('historiaEvento'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, HistoriaEvento $historiaEvento)
	{
		$historiaEvento = $historiaEvento->find($id);
		return view('historiaEventos.edit', compact('historiaEvento'))
			->with('list', HistoriaEvento::getListFromAllRelationApps());
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, HistoriaEvento $historiaEvento)
	{
		$historiaEvento = $historiaEvento->find($id);
		return view('historiaEventos.duplicate', compact('historiaEvento'))
			->with('list', HistoriaEvento::getListFromAllRelationApps());
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, HistoriaEvento $historiaEvento, updateHistoriaEvento $request)
	{
		$input = $request->all();
		$input['usu_mod_id'] = Auth::user()->id;
		//update data
		$historiaEvento = $historiaEvento->find($id);
		$historiaEvento->update($input);

		return redirect()->route('historiaEventos.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id, HistoriaEvento $historiaEvento)
	{
		$historiaEvento = $historiaEvento->find($id);
		$historiaEvento->delete();

		return redirect()->route('historiaEventos.index')->with('message', 'Registro Borrado.');
	}
}
