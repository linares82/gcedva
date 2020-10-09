<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Hadeudo;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateHadeudo;
use App\Http\Requests\createHadeudo;

class HadeudosController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$hadeudos = Hadeudo::getAllData($request);

		return view('hadeudos.index', compact('hadeudos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('hadeudos.create')
			->with('list', Hadeudo::getListFromAllRelationApps());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createHadeudo $request)
	{

		$input = $request->all();
		$input['usu_alta_id'] = Auth::user()->id;
		$input['usu_mod_id'] = Auth::user()->id;

		//create data
		Hadeudo::create($input);

		return redirect()->route('hadeudos.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, Hadeudo $hadeudo)
	{
		$hadeudo = $hadeudo->find($id);
		return view('hadeudos.show', compact('hadeudo'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, Hadeudo $hadeudo)
	{
		$hadeudo = $hadeudo->find($id);
		return view('hadeudos.edit', compact('hadeudo'))
			->with('list', Hadeudo::getListFromAllRelationApps());
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, Hadeudo $hadeudo)
	{
		$hadeudo = $hadeudo->find($id);
		return view('hadeudos.duplicate', compact('hadeudo'))
			->with('list', Hadeudo::getListFromAllRelationApps());
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, Hadeudo $hadeudo, updateHadeudo $request)
	{
		$input = $request->all();
		$input['usu_mod_id'] = Auth::user()->id;
		//update data
		$hadeudo = $hadeudo->find($id);
		$hadeudo->update($input);

		return redirect()->route('hadeudos.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id, Hadeudo $hadeudo)
	{
		$hadeudo = $hadeudo->find($id);
		$hadeudo->delete();

		return redirect()->route('hadeudos.index')->with('message', 'Registro Borrado.');
	}

	public function historia(Request $request)
	{
		$datos = $request->all();
		//dd($datos);
		$hadeudos = Hadeudo::where('adeudo_id', $datos['adeudo'])->orderBy('created_at')->get();
		//dd($hadeudos);

		return view('hadeudos.historia', compact('hadeudos'));
	}
}
