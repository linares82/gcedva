<?php

namespace App\Http\Controllers;

use Auth;
use App\Http\Requests;

use App\OpcionTitulacion;
use Illuminate\Http\Request;
use App\SepModalidadTitulacion;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\createOpcionTitulacion;
use App\Http\Requests\updateOpcionTitulacion;

class OpcionTitulacionsController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$opcionTitulacions = OpcionTitulacion::getAllData($request);

		return view('opcionTitulacions.index', compact('opcionTitulacions'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$sep_modalidads = SepModalidadTitulacion::select(DB::raw('concat(id_modalidad,"-",descripcion) as name, id'))
			->pluck('name', 'id');
		$sep_modalidads->prepend('Seleccionar opcion', NULL);
		return view('opcionTitulacions.create', compact('sep_modalidads'))
			->with('list', OpcionTitulacion::getListFromAllRelationApps());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createOpcionTitulacion $request)
	{

		$input = $request->all();
		$input['usu_alta_id'] = Auth::user()->id;
		$input['usu_mod_id'] = Auth::user()->id;

		//create data
		OpcionTitulacion::create($input);

		return redirect()->route('opcionTitulacions.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, OpcionTitulacion $opcionTitulacion)
	{
		$opcionTitulacion = $opcionTitulacion->find($id);
		return view('opcionTitulacions.show', compact('opcionTitulacion'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, OpcionTitulacion $opcionTitulacion)
	{
		$opcionTitulacion = $opcionTitulacion->find($id);
		$sep_modalidads = SepModalidadTitulacion::select(DB::raw('concat(id_modalidad,"-",descripcion) as name, id'))
			->pluck('name', 'id');
		$sep_modalidads->prepend('Seleccionar opcion', NULL);
		return view('opcionTitulacions.edit', compact('opcionTitulacion', 'sep_modalidads'))
			->with('list', OpcionTitulacion::getListFromAllRelationApps());
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, OpcionTitulacion $opcionTitulacion)
	{
		$opcionTitulacion = $opcionTitulacion->find($id);
		return view('opcionTitulacions.duplicate', compact('opcionTitulacion'))
			->with('list', OpcionTitulacion::getListFromAllRelationApps());
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, OpcionTitulacion $opcionTitulacion, updateOpcionTitulacion $request)
	{
		$input = $request->all();
		$input['usu_mod_id'] = Auth::user()->id;
		//update data
		$opcionTitulacion = $opcionTitulacion->find($id);
		$opcionTitulacion->update($input);

		return redirect()->route('opcionTitulacions.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id, OpcionTitulacion $opcionTitulacion)
	{
		$opcionTitulacion = $opcionTitulacion->find($id);
		$opcionTitulacion->delete();

		return redirect()->route('opcionTitulacions.index')->with('message', 'Registro Borrado.');
	}
}
