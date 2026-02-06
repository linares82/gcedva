<?php

namespace App\Http\Controllers;

use Auth;
use App\Http\Requests;

use App\ProspectoInforme;
use Illuminate\Http\Request;
use App\ProspectoSeguimiento;
use App\Http\Controllers\Controller;
use App\Http\Requests\createProspectoInforme;
use App\Http\Requests\updateProspectoInforme;

class ProspectoInformesController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$prospectoInformes = ProspectoInforme::getAllData($request);

		return view('prospectoInformes.index', compact('prospectoInformes'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('prospectoInformes.create')
			->with('list', ProspectoInforme::getListFromAllRelationApps());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createProspectoInforme $request)
	{

		$input = $request->all();
		//dd($input);
		$input['usu_alta_id'] = Auth::user()->id;
		$input['usu_mod_id'] = Auth::user()->id;

		//create data
		$informe = ProspectoInforme::create($input);
		$prospectoSeguimiento = ProspectoSeguimiento::find($input['prospecto_seguimiento_id']);

		return redirect()->route('prospectoSeguimientos.show', $prospectoSeguimiento->prospecto_id)->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, ProspectoInforme $prospectoInforme)
	{
		$prospectoInforme = $prospectoInforme->find($id);
		return view('prospectoInformes.show', compact('prospectoInforme'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, ProspectoInforme $prospectoInforme)
	{
		$prospectoInforme = $prospectoInforme->find($id);
		return view('prospectoInformes.edit', compact('prospectoInforme'))
			->with('list', ProspectoInforme::getListFromAllRelationApps());
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, ProspectoInforme $prospectoInforme)
	{
		$prospectoInforme = $prospectoInforme->find($id);
		return view('prospectoInformes.duplicate', compact('prospectoInforme'))
			->with('list', ProspectoInforme::getListFromAllRelationApps());
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, ProspectoInforme $prospectoInforme, updateProspectoInforme $request)
	{
		$input = $request->all();
		$input['usu_mod_id'] = Auth::user()->id;
		//update data
		$prospectoInforme = $prospectoInforme->find($id);
		$prospectoInforme->update($input);

		return redirect()->route('prospectoInformes.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id, ProspectoInforme $prospectoInforme)
	{
		$prospectoInforme = $prospectoInforme->find($id);
		$prospectoInforme->delete();

		return redirect()->route('prospectoSeguimientos.show', $prospectoInforme->prospecto_id)->with('message', 'Registro Borrado.');
	}
}
