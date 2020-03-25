<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Clasificacion;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateClasificacion;
use App\Http\Requests\createClasificacion;

class ClasificacionsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$clasificacions = Clasificacion::getAllData($request);

		return view('clasificacions.index', compact('clasificacions'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('clasificacions.create')
			->with( 'list', Clasificacion::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createClasificacion $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		Clasificacion::create( $input );

		return redirect()->route('clasificacions.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, Clasificacion $clasificacion)
	{
		$clasificacion=$clasificacion->find($id);
		return view('clasificacions.show', compact('clasificacion'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, Clasificacion $clasificacion)
	{
		$clasificacion=$clasificacion->find($id);
		return view('clasificacions.edit', compact('clasificacion'))
			->with( 'list', Clasificacion::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, Clasificacion $clasificacion)
	{
		$clasificacion=$clasificacion->find($id);
		return view('clasificacions.duplicate', compact('clasificacion'))
			->with( 'list', Clasificacion::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, Clasificacion $clasificacion, updateClasificacion $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$clasificacion=$clasificacion->find($id);
		$clasificacion->update( $input );

		return redirect()->route('clasificacions.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,Clasificacion $clasificacion)
	{
		$clasificacion=$clasificacion->find($id);
		$clasificacion->delete();

		return redirect()->route('clasificacions.index')->with('message', 'Registro Borrado.');
	}

}
