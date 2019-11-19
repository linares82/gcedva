<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\StHistoriaCliente;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateStHistoriaCliente;
use App\Http\Requests\createStHistoriaCliente;

class StHistoriaClientesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$stHistoriaClientes = StHistoriaCliente::getAllData($request);

		return view('stHistoriaClientes.index', compact('stHistoriaClientes'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('stHistoriaClientes.create')
			->with( 'list', StHistoriaCliente::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createStHistoriaCliente $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		StHistoriaCliente::create( $input );

		return redirect()->route('stHistoriaClientes.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, StHistoriaCliente $stHistoriaCliente)
	{
		$stHistoriaCliente=$stHistoriaCliente->find($id);
		return view('stHistoriaClientes.show', compact('stHistoriaCliente'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, StHistoriaCliente $stHistoriaCliente)
	{
		$stHistoriaCliente=$stHistoriaCliente->find($id);
		return view('stHistoriaClientes.edit', compact('stHistoriaCliente'))
			->with( 'list', StHistoriaCliente::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, StHistoriaCliente $stHistoriaCliente)
	{
		$stHistoriaCliente=$stHistoriaCliente->find($id);
		return view('stHistoriaClientes.duplicate', compact('stHistoriaCliente'))
			->with( 'list', StHistoriaCliente::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, StHistoriaCliente $stHistoriaCliente, updateStHistoriaCliente $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$stHistoriaCliente=$stHistoriaCliente->find($id);
		$stHistoriaCliente->update( $input );

		return redirect()->route('stHistoriaClientes.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,StHistoriaCliente $stHistoriaCliente)
	{
		$stHistoriaCliente=$stHistoriaCliente->find($id);
		$stHistoriaCliente->delete();

		return redirect()->route('stHistoriaClientes.index')->with('message', 'Registro Borrado.');
	}

}
