<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\IncidenceCliente;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateIncidenceCliente;
use App\Http\Requests\createIncidenceCliente;

class IncidenceClientesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$incidenceClientes = IncidenceCliente::getAllData($request);

		return view('incidenceClientes.index', compact('incidenceClientes'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('incidenceClientes.create')
			->with( 'list', IncidenceCliente::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createIncidenceCliente $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		IncidenceCliente::create( $input );

		return redirect()->route('incidenceClientes.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, IncidenceCliente $incidenceCliente)
	{
		$incidenceCliente=$incidenceCliente->find($id);
		return view('incidenceClientes.show', compact('incidenceCliente'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, IncidenceCliente $incidenceCliente)
	{
		$incidenceCliente=$incidenceCliente->find($id);
		return view('incidenceClientes.edit', compact('incidenceCliente'))
			->with( 'list', IncidenceCliente::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, IncidenceCliente $incidenceCliente)
	{
		$incidenceCliente=$incidenceCliente->find($id);
		return view('incidenceClientes.duplicate', compact('incidenceCliente'))
			->with( 'list', IncidenceCliente::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, IncidenceCliente $incidenceCliente, updateIncidenceCliente $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$incidenceCliente=$incidenceCliente->find($id);
		$incidenceCliente->update( $input );

		return redirect()->route('incidenceClientes.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,IncidenceCliente $incidenceCliente)
	{
		$incidenceCliente=$incidenceCliente->find($id);
		$incidenceCliente->delete();

		return redirect()->route('incidenceClientes.index')->with('message', 'Registro Borrado.');
	}

}
