<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\IncidencesCliente;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateIncidencesCliente;
use App\Http\Requests\createIncidencesCliente;

class IncidencesClientesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$incidencesClientes = IncidencesCliente::getAllData($request);

		return view('incidencesClientes.index', compact('incidencesClientes'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('incidencesClientes.create')
			->with( 'list', IncidencesCliente::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createIncidencesCliente $request)
	{

		$input = $request->all();
		//dd($input);
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		$incidencia=IncidencesCliente::create( $input );

		return redirect()->route('clientes.edit', $incidencia->cliente_id)->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, IncidencesCliente $incidencesCliente)
	{
		$incidencesCliente=$incidencesCliente->find($id);
		return view('incidencesClientes.show', compact('incidencesCliente'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, IncidencesCliente $incidencesCliente)
	{
		$incidencesCliente=$incidencesCliente->find($id);
		return view('incidencesClientes.edit', compact('incidencesCliente'))
			->with( 'list', IncidencesCliente::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, IncidencesCliente $incidencesCliente)
	{
		$incidencesCliente=$incidencesCliente->find($id);
		return view('incidencesClientes.duplicate', compact('incidencesCliente'))
			->with( 'list', IncidencesCliente::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, IncidencesCliente $incidencesCliente, updateIncidencesCliente $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$incidencesCliente=$incidencesCliente->find($id);
		$incidencesCliente->update( $input );

		return redirect()->route('incidencesClientes.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,IncidencesCliente $incidencesCliente)
	{
		$incidencesCliente=$incidencesCliente->find($id);
		$cliente=$incidencesCliente->cliente_id;
		$incidencesCliente->delete();

		return redirect()->route('clientes.edit',$cliente)->with('message', 'Registro Borrado.');
	}

}
