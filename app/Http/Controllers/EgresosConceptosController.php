<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\EgresosConcepto;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateEgresosConcepto;
use App\Http\Requests\createEgresosConcepto;

class EgresosConceptosController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$egresosConceptos = EgresosConcepto::getAllData($request);

		return view('egresosConceptos.index', compact('egresosConceptos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$padres = EgresosConcepto::where('bnd_agrupador', 1)->pluck('name', 'id');
		$padres->prepend('Seleccionar Opción', '');
		return view('egresosConceptos.create', compact('padres'))
			->with('list', EgresosConcepto::getListFromAllRelationApps());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createEgresosConcepto $request)
	{

		$input = $request->all();
		$input['usu_alta_id'] = Auth::user()->id;
		$input['usu_mod_id'] = Auth::user()->id;

		//create data
		EgresosConcepto::create($input);

		return redirect()->route('egresosConceptos.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, EgresosConcepto $egresosConcepto)
	{
		$egresosConcepto = $egresosConcepto->find($id);
		return view('egresosConceptos.show', compact('egresosConcepto'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, EgresosConcepto $egresosConcepto)
	{
		$egresosConcepto = $egresosConcepto->find($id);
		$padres = EgresosConcepto::where('bnd_agrupador', 1)->pluck('name', 'id');
		$padres->prepend('Seleccionar Opción', '');
		return view('egresosConceptos.edit', compact('egresosConcepto', 'padres'))
			->with('list', EgresosConcepto::getListFromAllRelationApps());
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, EgresosConcepto $egresosConcepto)
	{
		$egresosConcepto = $egresosConcepto->find($id);
		return view('egresosConceptos.duplicate', compact('egresosConcepto'))
			->with('list', EgresosConcepto::getListFromAllRelationApps());
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, EgresosConcepto $egresosConcepto, updateEgresosConcepto $request)
	{
		$input = $request->all();
		$input['usu_mod_id'] = Auth::user()->id;
		//update data
		$egresosConcepto = $egresosConcepto->find($id);
		$egresosConcepto->update($input);

		return redirect()->route('egresosConceptos.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id, EgresosConcepto $egresosConcepto)
	{
		$egresosConcepto = $egresosConcepto->find($id);
		$egresosConcepto->delete();

		return redirect()->route('egresosConceptos.index')->with('message', 'Registro Borrado.');
	}
}
