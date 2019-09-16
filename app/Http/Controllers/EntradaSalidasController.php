<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\EntradaSalida;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateEntradaSalida;
use App\Http\Requests\createEntradaSalida;

class EntradaSalidasController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$entradaSalidas = EntradaSalida::getAllData($request);

		return view('entradaSalidas.index', compact('entradaSalidas'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('entradaSalidas.create')
			->with( 'list', EntradaSalida::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createEntradaSalida $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		EntradaSalida::create( $input );

		return redirect()->route('entradaSalidas.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, EntradaSalida $entradaSalida)
	{
		$entradaSalida=$entradaSalida->find($id);
		return view('entradaSalidas.show', compact('entradaSalida'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, EntradaSalida $entradaSalida)
	{
		$entradaSalida=$entradaSalida->find($id);
		return view('entradaSalidas.edit', compact('entradaSalida'))
			->with( 'list', EntradaSalida::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, EntradaSalida $entradaSalida)
	{
		$entradaSalida=$entradaSalida->find($id);
		return view('entradaSalidas.duplicate', compact('entradaSalida'))
			->with( 'list', EntradaSalida::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, EntradaSalida $entradaSalida, updateEntradaSalida $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$entradaSalida=$entradaSalida->find($id);
		$entradaSalida->update( $input );

		return redirect()->route('entradaSalidas.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,EntradaSalida $entradaSalida)
	{
		$entradaSalida=$entradaSalida->find($id);
		$entradaSalida->delete();

		return redirect()->route('entradaSalidas.index')->with('message', 'Registro Borrado.');
	}

}
