<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\ProspectoEtiquetum;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateProspectoEtiquetum;
use App\Http\Requests\createProspectoEtiquetum;

class ProspectoEtiquetasController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$prospectoEtiquetas = ProspectoEtiquetum::getAllData($request);

		return view('prospectoEtiquetas.index', compact('prospectoEtiquetas'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('prospectoEtiquetas.create')
			->with('list', ProspectoEtiquetum::getListFromAllRelationApps());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createProspectoEtiquetum $request)
	{

		$input = $request->all();
		$input['usu_alta_id'] = Auth::user()->id;
		$input['usu_mod_id'] = Auth::user()->id;

		//create data
		ProspectoEtiquetum::create($input);

		return redirect()->route('prospectoEtiquetas.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, ProspectoEtiquetum $prospectoEtiquetum)
	{
		$prospectoEtiquetum = $prospectoEtiquetum->find($id);
		return view('prospectoEtiquetas.show', compact('prospectoEtiquetum'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, ProspectoEtiquetum $prospectoEtiquetum)
	{
		$prospectoEtiquetum = $prospectoEtiquetum->find($id);
		return view('prospectoEtiquetas.edit', compact('prospectoEtiquetum'))
			->with('list', ProspectoEtiquetum::getListFromAllRelationApps());
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, ProspectoEtiquetum $prospectoEtiquetum)
	{
		$prospectoEtiquetum = $prospectoEtiquetum->find($id);
		return view('prospectoEtiquetas.duplicate', compact('prospectoEtiquetum'))
			->with('list', ProspectoEtiquetum::getListFromAllRelationApps());
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, ProspectoEtiquetum $prospectoEtiquetum, updateProspectoEtiquetum $request)
	{
		$input = $request->all();
		$input['usu_mod_id'] = Auth::user()->id;
		//update data
		$prospectoEtiquetum = $prospectoEtiquetum->find($id);
		$prospectoEtiquetum->update($input);

		return redirect()->route('prospectoEtiquetas.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id, ProspectoEtiquetum $prospectoEtiquetum)
	{
		$prospectoEtiquetum = $prospectoEtiquetum->find($id);
		$prospectoEtiquetum->delete();

		return redirect()->route('prospectoEtiquetas.index')->with('message', 'Registro Borrado.');
	}
}
