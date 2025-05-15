<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\SepObservacion;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateSepObservacion;
use App\Http\Requests\createSepObservacion;

class SepObservacionsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$sepObservacions = SepObservacion::getAllData($request);

		return view('sepObservacions.index', compact('sepObservacions'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('sepObservacions.create')
			->with( 'list', SepObservacion::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createSepObservacion $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		SepObservacion::create( $input );

		return redirect()->route('sepObservacions.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, SepObservacion $sepObservacion)
	{
		$sepObservacion=$sepObservacion->find($id);
		return view('sepObservacions.show', compact('sepObservacion'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, SepObservacion $sepObservacion)
	{
		$sepObservacion=$sepObservacion->find($id);
		return view('sepObservacions.edit', compact('sepObservacion'))
			->with( 'list', SepObservacion::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, SepObservacion $sepObservacion)
	{
		$sepObservacion=$sepObservacion->find($id);
		return view('sepObservacions.duplicate', compact('sepObservacion'))
			->with( 'list', SepObservacion::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, SepObservacion $sepObservacion, updateSepObservacion $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$sepObservacion=$sepObservacion->find($id);
		$sepObservacion->update( $input );

		return redirect()->route('sepObservacions.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,SepObservacion $sepObservacion)
	{
		$sepObservacion=$sepObservacion->find($id);
		$sepObservacion->delete();

		return redirect()->route('sepObservacions.index')->with('message', 'Registro Borrado.');
	}

}
