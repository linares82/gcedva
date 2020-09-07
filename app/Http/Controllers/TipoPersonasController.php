<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\TipoPersona;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateTipoPersona;
use App\Http\Requests\createTipoPersona;

class TipoPersonasController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$tipoPersonas = TipoPersona::getAllData($request);

		return view('tipoPersonas.index', compact('tipoPersonas'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('tipoPersonas.create')
			->with( 'list', TipoPersona::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createTipoPersona $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		TipoPersona::create( $input );

		return redirect()->route('tipoPersonas.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, TipoPersona $tipoPersona)
	{
		$tipoPersona=$tipoPersona->find($id);
		return view('tipoPersonas.show', compact('tipoPersona'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, TipoPersona $tipoPersona)
	{
		$tipoPersona=$tipoPersona->find($id);
		return view('tipoPersonas.edit', compact('tipoPersona'))
			->with( 'list', TipoPersona::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, TipoPersona $tipoPersona)
	{
		$tipoPersona=$tipoPersona->find($id);
		return view('tipoPersonas.duplicate', compact('tipoPersona'))
			->with( 'list', TipoPersona::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, TipoPersona $tipoPersona, updateTipoPersona $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$tipoPersona=$tipoPersona->find($id);
		$tipoPersona->update( $input );

		return redirect()->route('tipoPersonas.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,TipoPersona $tipoPersona)
	{
		$tipoPersona=$tipoPersona->find($id);
		$tipoPersona->delete();

		return redirect()->route('tipoPersonas.index')->with('message', 'Registro Borrado.');
	}

}
