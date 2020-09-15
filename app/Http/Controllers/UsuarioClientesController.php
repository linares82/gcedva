<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\UsuarioCliente;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateUsuarioCliente;
use App\Http\Requests\createUsuarioCliente;
use Hash;

class UsuarioClientesController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$usuarioClientes = UsuarioCliente::getAllData($request);

		return view('usuarioClientes.index', compact('usuarioClientes'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('usuarioClientes.create')
			->with('list', UsuarioCliente::getListFromAllRelationApps());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createUsuarioCliente $request)
	{

		$input = $request->all();
		$input['usu_alta_id'] = Auth::user()->id;
		$input['usu_mod_id'] = Auth::user()->id;

		//create data
		UsuarioCliente::create($input);

		return redirect()->route('usuarioClientes.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, UsuarioCliente $usuarioCliente)
	{
		$usuarioCliente = $usuarioCliente->find($id);
		return view('usuarioClientes.show', compact('usuarioCliente'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, UsuarioCliente $usuarioCliente)
	{
		$usuarioCliente = $usuarioCliente->find($id);
		return view('usuarioClientes.edit', compact('usuarioCliente'));
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, UsuarioCliente $usuarioCliente)
	{
		$usuarioCliente = $usuarioCliente->find($id);
		return view('usuarioClientes.duplicate', compact('usuarioCliente'))
			->with('list', UsuarioCliente::getListFromAllRelationApps());
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, UsuarioCliente $usuarioCliente, updateUsuarioCliente $request)
	{
		$input = $request->all();
		$input['usu_mod_id'] = Auth::user()->id;
		$input['password'] = Hash::make($input['password']);
		//update data
		$usuarioCliente = $usuarioCliente->find($id);
		$usuarioCliente->update($input);

		return redirect()->route('clientes.indexEventos')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id, UsuarioCliente $usuarioCliente)
	{
		$usuarioCliente = $usuarioCliente->find($id);
		$usuarioCliente->delete();

		return redirect()->route('usuarioClientes.index')->with('message', 'Registro Borrado.');
	}
}
