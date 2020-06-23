<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\EstadoCivil;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateEstadoCivil;
use App\Http\Requests\createEstadoCivil;

class EstadoCivilsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$estadoCivils = EstadoCivil::getAllData($request);

		return view('estadoCivils.index', compact('estadoCivils'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('estadoCivils.create')
			->with( 'list', EstadoCivil::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createEstadoCivil $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		EstadoCivil::create( $input );

		return redirect()->route('estadoCivils.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, EstadoCivil $estadoCivil)
	{
		$estadoCivil=$estadoCivil->find($id);
		return view('estadoCivils.show', compact('estadoCivil'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, EstadoCivil $estadoCivil)
	{
		$estadoCivil=$estadoCivil->find($id);
		return view('estadoCivils.edit', compact('estadoCivil'))
			->with( 'list', EstadoCivil::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, EstadoCivil $estadoCivil)
	{
		$estadoCivil=$estadoCivil->find($id);
		return view('estadoCivils.duplicate', compact('estadoCivil'))
			->with( 'list', EstadoCivil::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, EstadoCivil $estadoCivil, updateEstadoCivil $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$estadoCivil=$estadoCivil->find($id);
		$estadoCivil->update( $input );

		return redirect()->route('estadoCivils.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,EstadoCivil $estadoCivil)
	{
		$estadoCivil=$estadoCivil->find($id);
		$estadoCivil->delete();

		return redirect()->route('estadoCivils.index')->with('message', 'Registro Borrado.');
	}

}
