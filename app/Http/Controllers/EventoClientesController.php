<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\EventoCliente;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateEventoCliente;
use App\Http\Requests\createEventoCliente;

class EventoClientesController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$eventoClientes = EventoCliente::getAllData($request);

		return view('eventoClientes.index', compact('eventoClientes'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{

		return view('eventoClientes.create')
			->with('list', EventoCliente::getListFromAllRelationApps());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createEventoCliente $request)
	{

		$input = $request->all();
		$input['usu_alta_id'] = Auth::user()->id;
		$input['usu_mod_id'] = Auth::user()->id;
		if (isset($input['bnd_duplicar_cliente'])) {
			$input['bnd_duplicar_cliente'] = 1;
		} else {
			$input['bnd_duplicar_cliente'] = 0;
		}

		//create data
		EventoCliente::create($input);

		return redirect()->route('eventoClientes.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, EventoCliente $eventoCliente)
	{
		$eventoCliente = $eventoCliente->find($id);
		return view('eventoClientes.show', compact('eventoCliente'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, EventoCliente $eventoCliente)
	{
		$eventoCliente = $eventoCliente->find($id);
		return view('eventoClientes.edit', compact('eventoCliente'))
			->with('list', EventoCliente::getListFromAllRelationApps());
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, EventoCliente $eventoCliente)
	{
		$eventoCliente = $eventoCliente->find($id);
		return view('eventoClientes.duplicate', compact('eventoCliente'))
			->with('list', EventoCliente::getListFromAllRelationApps());
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, EventoCliente $eventoCliente, updateEventoCliente $request)
	{
		$input = $request->all();
		$input['usu_mod_id'] = Auth::user()->id;
		if (isset($input['bnd_duplicar_cliente'])) {
			$input['bnd_duplicar_cliente'] = 1;
		} else {
			$input['bnd_duplicar_cliente'] = 0;
		}
		//update data
		$eventoCliente = $eventoCliente->find($id);
		$eventoCliente->update($input);

		return redirect()->route('eventoClientes.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id, EventoCliente $eventoCliente)
	{
		$eventoCliente = $eventoCliente->find($id);
		$eventoCliente->delete();

		return redirect()->route('eventoClientes.index')->with('message', 'Registro Borrado.');
	}
}
