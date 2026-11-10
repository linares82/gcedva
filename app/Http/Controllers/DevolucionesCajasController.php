<?php

namespace App\Http\Controllers;

use App\Caja;
use App\DevolucionesCaja;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\createDevolucionesCaja;
use App\Http\Requests\updateDevolucionesCaja;
use Auth;
use Illuminate\Http\Request;

class DevolucionesCajasController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$devolucionesCajas = DevolucionesCaja::getAllData($request);

		return view('devolucionesCajas.index', compact('devolucionesCajas'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(Request $request)
	{
		$caja = Caja::with(['cliente', 'plantel', 'cliente.combinacionCliente.grado', 'cajaLn.cajaConcepto'])->find($request->caja);
		return view('devolucionesCajas.create', compact('caja'))
			->with('list', DevolucionesCaja::getListFromAllRelationApps());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createDevolucionesCaja $request)
	{

		$input = $request->all();
		$input['usu_alta_id'] = Auth::user()->id;
		$input['usu_mod_id'] = Auth::user()->id;
		$input['st_dev_caja_id'] = 1;

		//create data
		DevolucionesCaja::create($input);


		return redirect()->route('devolucionesCajas.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, DevolucionesCaja $devolucionesCaja)
	{
		$devolucionesCaja = $devolucionesCaja->find($id);
		return view('devolucionesCajas.show', compact('devolucionesCaja'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, DevolucionesCaja $devolucionesCaja)
	{
		$devolucionesCaja = $devolucionesCaja->find($id);
		return view('devolucionesCajas.edit', compact('devolucionesCaja'))
			->with('list', DevolucionesCaja::getListFromAllRelationApps());
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, DevolucionesCaja $devolucionesCaja)
	{
		$devolucionesCaja = $devolucionesCaja->find($id);
		return view('devolucionesCajas.duplicate', compact('devolucionesCaja'))
			->with('list', DevolucionesCaja::getListFromAllRelationApps());
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, DevolucionesCaja $devolucionesCaja, updateDevolucionesCaja $request)
	{
		$input = $request->all();
		$input['usu_mod_id'] = Auth::user()->id;
		//update data
		$devolucionesCaja = $devolucionesCaja->find($id);
		$devolucionesCaja->update($input);

		return redirect()->route('devolucionesCajas.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id, DevolucionesCaja $devolucionesCaja)
	{
		$devolucionesCaja = $devolucionesCaja->find($id);
		$devolucionesCaja->delete();

		return redirect()->route('devolucionesCajas.index')->with('message', 'Registro Borrado.');
	}

	public function aprobar($id, DevolucionesCaja $devolucionesCaja)
	{
		$devolucionesCaja = $devolucionesCaja->find($id);
		$devolucionesCaja->st_dev_caja_id = 2;
		$devolucionesCaja->save();

		return redirect()->route('devolucionesCajas.show', $id)->with('message', 'Registro Aprobado.');
	}

	public function rechazar($id, DevolucionesCaja $devolucionesCaja)
	{
		$devolucionesCaja = $devolucionesCaja->find($id);
		$devolucionesCaja->st_dev_caja_id = 3;
		$devolucionesCaja->save();

		return redirect()->route('devolucionesCajas.show', $id)->with('message', 'Registro Rechazado.');
	}
}
