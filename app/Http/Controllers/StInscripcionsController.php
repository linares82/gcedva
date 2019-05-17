<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\StInscripcion;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateStInscripcion;
use App\Http\Requests\createStInscripcion;

class StInscripcionsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$stInscripcions = StInscripcion::getAllData($request);

		return view('stInscripcions.index', compact('stInscripcions'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('stInscripcions.create')
			->with( 'list', StInscripcion::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createStInscripcion $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		StInscripcion::create( $input );

		return redirect()->route('stInscripcions.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, StInscripcion $stInscripcion)
	{
		$stInscripcion=$stInscripcion->find($id);
		return view('stInscripcions.show', compact('stInscripcion'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, StInscripcion $stInscripcion)
	{
		$stInscripcion=$stInscripcion->find($id);
		return view('stInscripcions.edit', compact('stInscripcion'))
			->with( 'list', StInscripcion::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, StInscripcion $stInscripcion)
	{
		$stInscripcion=$stInscripcion->find($id);
		return view('stInscripcions.duplicate', compact('stInscripcion'))
			->with( 'list', StInscripcion::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, StInscripcion $stInscripcion, updateStInscripcion $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$stInscripcion=$stInscripcion->find($id);
		$stInscripcion->update( $input );

		return redirect()->route('stInscripcions.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,StInscripcion $stInscripcion)
	{
		$stInscripcion=$stInscripcion->find($id);
		$stInscripcion->delete();

		return redirect()->route('stInscripcions.index')->with('message', 'Registro Borrado.');
	}

}
