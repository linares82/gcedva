<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\SetyceTitulo;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateSetyceTitulo;
use App\Http\Requests\createSetyceTitulo;

class SetyceTitulosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$setyceTitulos = SetyceTitulo::getAllData($request);

		return view('setyceTitulos.index', compact('setyceTitulos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('setyceTitulos.create')
			->with( 'list', SetyceTitulo::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createSetyceTitulo $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		SetyceTitulo::create( $input );

		return redirect()->route('setyceTitulos.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, SetyceTitulo $setyceTitulo)
	{
		$setyceTitulo=$setyceTitulo->find($id);
		return view('setyceTitulos.show', compact('setyceTitulo'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, SetyceTitulo $setyceTitulo)
	{
		$setyceTitulo=$setyceTitulo->find($id);
		return view('setyceTitulos.edit', compact('setyceTitulo'))
			->with( 'list', SetyceTitulo::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, SetyceTitulo $setyceTitulo)
	{
		$setyceTitulo=$setyceTitulo->find($id);
		return view('setyceTitulos.duplicate', compact('setyceTitulo'))
			->with( 'list', SetyceTitulo::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, SetyceTitulo $setyceTitulo, updateSetyceTitulo $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$setyceTitulo=$setyceTitulo->find($id);
		$setyceTitulo->update( $input );

		return redirect()->route('setyceTitulos.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,SetyceTitulo $setyceTitulo)
	{
		$setyceTitulo=$setyceTitulo->find($id);
		$setyceTitulo->delete();

		return redirect()->route('setyceTitulos.index')->with('message', 'Registro Borrado.');
	}

}
