<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\HCalificacion;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateHCalificacion;
use App\Http\Requests\createHCalificacion;

class HCalificacionsController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$hCalificacions = HCalificacion::getAllData($request);

		return view('hCalificacions.index', compact('hCalificacions'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('hCalificacions.create')
			->with('list', HCalificacion::getListFromAllRelationApps());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createHCalificacion $request)
	{

		$input = $request->all();
		$input['usu_alta_id'] = Auth::user()->id;
		$input['usu_mod_id'] = Auth::user()->id;

		//create data
		HCalificacion::create($input);

		return redirect()->route('hCalificacions.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, HCalificacion $hCalificacion)
	{
		$hCalificacion = $hCalificacion->find($id);
		return view('hCalificacions.show', compact('hCalificacion'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, HCalificacion $hCalificacion)
	{
		$hCalificacion = $hCalificacion->find($id);
		return view('hCalificacions.edit', compact('hCalificacion'))
			->with('list', HCalificacion::getListFromAllRelationApps());
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, HCalificacion $hCalificacion)
	{
		$hCalificacion = $hCalificacion->find($id);
		return view('hCalificacions.duplicate', compact('hCalificacion'))
			->with('list', HCalificacion::getListFromAllRelationApps());
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, HCalificacion $hCalificacion, updateHCalificacion $request)
	{
		$input = $request->all();
		$input['usu_mod_id'] = Auth::user()->id;
		//update data
		$hCalificacion = $hCalificacion->find($id);
		$hCalificacion->update($input);

		return redirect()->route('hCalificacions.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id, HCalificacion $hCalificacion)
	{
		$hCalificacion = $hCalificacion->find($id);
		$hCalificacion->delete();

		return redirect()->route('hCalificacions.index')->with('message', 'Registro Borrado.');
	}
}
