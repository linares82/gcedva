<?php

namespace App\Http\Controllers;

use App\CalendarioIncidenciaCal;
use App\Empleado;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\createCalendarioIncidenciaCal;
use App\Http\Requests\updateCalendarioIncidenciaCal;
use Auth;
use Illuminate\Http\Request;

class CalendarioIncidenciaCalsController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$calendarioIncidenciaCals = CalendarioIncidenciaCal::getAllData($request);

		return view('calendarioIncidenciaCals.index', compact('calendarioIncidenciaCals'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('calendarioIncidenciaCals.create')
			->with('list', CalendarioIncidenciaCal::getListFromAllRelationApps());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createCalendarioIncidenciaCal $request)
	{

		$input = $request->all();
		$input['usu_alta_id'] = Auth::user()->id;
		$input['usu_mod_id'] = Auth::user()->id;
		$input['plantel_id'] = Empleado::where('user_id', '=', Auth::user()->id)
			->value('plantel_id');

		//create data
		CalendarioIncidenciaCal::create($input);

		return redirect()->route('calendarioIncidenciaCals.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, CalendarioIncidenciaCal $calendarioIncidenciaCal)
	{
		$calendarioIncidenciaCal = $calendarioIncidenciaCal->find($id);
		return view('calendarioIncidenciaCals.show', compact('calendarioIncidenciaCal'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, CalendarioIncidenciaCal $calendarioIncidenciaCal)
	{
		$calendarioIncidenciaCal = $calendarioIncidenciaCal->find($id);
		return view('calendarioIncidenciaCals.edit', compact('calendarioIncidenciaCal'))
			->with('list', CalendarioIncidenciaCal::getListFromAllRelationApps());
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, CalendarioIncidenciaCal $calendarioIncidenciaCal)
	{
		$calendarioIncidenciaCal = $calendarioIncidenciaCal->find($id);
		return view('calendarioIncidenciaCals.duplicate', compact('calendarioIncidenciaCal'))
			->with('list', CalendarioIncidenciaCal::getListFromAllRelationApps());
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, CalendarioIncidenciaCal $calendarioIncidenciaCal, updateCalendarioIncidenciaCal $request)
	{
		$input = $request->all();
		$input['usu_mod_id'] = Auth::user()->id;
		$input['plantel_id'] = Empleado::where('user_id', '=', Auth::user()->id)
			->value('plantel_id');
		//update data
		$calendarioIncidenciaCal = $calendarioIncidenciaCal->find($id);
		$calendarioIncidenciaCal->update($input);

		return redirect()->route('calendarioIncidenciaCals.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id, CalendarioIncidenciaCal $calendarioIncidenciaCal)
	{
		$calendarioIncidenciaCal = $calendarioIncidenciaCal->find($id);
		$calendarioIncidenciaCal->delete();

		return redirect()->route('calendarioIncidenciaCals.index')->with('message', 'Registro Borrado.');
	}
}
