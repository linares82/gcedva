<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\UusarioCliente;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateUusarioCliente;
use App\Http\Requests\createUusarioCliente;

class UusarioClientesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$uusarioClientes = UusarioCliente::getAllData($request);

		return view('uusarioClientes.index', compact('uusarioClientes'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('uusarioClientes.create')
			->with( 'list', UusarioCliente::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createUusarioCliente $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		UusarioCliente::create( $input );

		return redirect()->route('uusarioClientes.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, UusarioCliente $uusarioCliente)
	{
		$uusarioCliente=$uusarioCliente->find($id);
		return view('uusarioClientes.show', compact('uusarioCliente'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, UusarioCliente $uusarioCliente)
	{
		$uusarioCliente=$uusarioCliente->find($id);
		return view('uusarioClientes.edit', compact('uusarioCliente'))
			->with( 'list', UusarioCliente::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, UusarioCliente $uusarioCliente)
	{
		$uusarioCliente=$uusarioCliente->find($id);
		return view('uusarioClientes.duplicate', compact('uusarioCliente'))
			->with( 'list', UusarioCliente::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, UusarioCliente $uusarioCliente, updateUusarioCliente $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$uusarioCliente=$uusarioCliente->find($id);
		$uusarioCliente->update( $input );

		return redirect()->route('uusarioClientes.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,UusarioCliente $uusarioCliente)
	{
		$uusarioCliente=$uusarioCliente->find($id);
		$uusarioCliente->delete();

		return redirect()->route('uusarioClientes.index')->with('message', 'Registro Borrado.');
	}

}
