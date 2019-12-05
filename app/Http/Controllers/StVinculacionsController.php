<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\StVinculacion;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateStVinculacion;
use App\Http\Requests\createStVinculacion;

class StVinculacionsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$stVinculacions = StVinculacion::getAllData($request);

		return view('stVinculacions.index', compact('stVinculacions'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('stVinculacions.create')
			->with( 'list', StVinculacion::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createStVinculacion $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		StVinculacion::create( $input );

		return redirect()->route('stVinculacions.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, StVinculacion $stVinculacion)
	{
		$stVinculacion=$stVinculacion->find($id);
		return view('stVinculacions.show', compact('stVinculacion'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, StVinculacion $stVinculacion)
	{
		$stVinculacion=$stVinculacion->find($id);
		return view('stVinculacions.edit', compact('stVinculacion'))
			->with( 'list', StVinculacion::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, StVinculacion $stVinculacion)
	{
		$stVinculacion=$stVinculacion->find($id);
		return view('stVinculacions.duplicate', compact('stVinculacion'))
			->with( 'list', StVinculacion::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, StVinculacion $stVinculacion, updateStVinculacion $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$stVinculacion=$stVinculacion->find($id);
		$stVinculacion->update( $input );

		return redirect()->route('stVinculacions.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,StVinculacion $stVinculacion)
	{
		$stVinculacion=$stVinculacion->find($id);
		$stVinculacion->delete();

		return redirect()->route('stVinculacions.index')->with('message', 'Registro Borrado.');
	}

}
