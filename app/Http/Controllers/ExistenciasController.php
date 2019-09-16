<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Existencium;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateExistencium;
use App\Http\Requests\createExistencium;

class ExistenciasController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$existencias = Existencium::getAllData($request);

		return view('existencias.index', compact('existencias'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('existencias.create')
			->with( 'list', Existencium::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createExistencium $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		Existencium::create( $input );

		return redirect()->route('existencias.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, Existencium $existencium)
	{
		$existencium=$existencium->find($id);
		return view('existencias.show', compact('existencium'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, Existencium $existencium)
	{
		$existencium=$existencium->find($id);
		return view('existencias.edit', compact('existencium'))
			->with( 'list', Existencium::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, Existencium $existencium)
	{
		$existencium=$existencium->find($id);
		return view('existencias.duplicate', compact('existencium'))
			->with( 'list', Existencium::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, Existencium $existencium, updateExistencium $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$existencium=$existencium->find($id);
		$existencium->update( $input );

		return redirect()->route('existencias.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,Existencium $existencium)
	{
		$existencium=$existencium->find($id);
		$existencium->delete();

		return redirect()->route('existencias.index')->with('message', 'Registro Borrado.');
	}

}
