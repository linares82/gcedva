<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Escolaridad;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateEscolaridad;
use App\Http\Requests\createEscolaridad;

class EscolaridadsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$escolaridads = Escolaridad::getAllData($request);

		return view('escolaridads.index', compact('escolaridads'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('escolaridads.create')
			->with( 'list', Escolaridad::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createEscolaridad $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		Escolaridad::create( $input );

		return redirect()->route('escolaridads.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, Escolaridad $escolaridad)
	{
		$escolaridad=$escolaridad->find($id);
		return view('escolaridads.show', compact('escolaridad'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, Escolaridad $escolaridad)
	{
		$escolaridad=$escolaridad->find($id);
		return view('escolaridads.edit', compact('escolaridad'))
			->with( 'list', Escolaridad::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, Escolaridad $escolaridad)
	{
		$escolaridad=$escolaridad->find($id);
		return view('escolaridads.duplicate', compact('escolaridad'))
			->with( 'list', Escolaridad::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, Escolaridad $escolaridad, updateEscolaridad $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$escolaridad=$escolaridad->find($id);
		$escolaridad->update( $input );

		return redirect()->route('escolaridads.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,Escolaridad $escolaridad)
	{
		$escolaridad=$escolaridad->find($id);
		$escolaridad->delete();

		return redirect()->route('escolaridads.index')->with('message', 'Registro Borrado.');
	}

}
