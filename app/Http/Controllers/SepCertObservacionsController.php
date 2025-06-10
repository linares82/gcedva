<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\SepCertObservacion;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateSepCertObservacion;
use App\Http\Requests\createSepCertObservacion;

class SepCertObservacionsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$sepCertObservacions = SepCertObservacion::getAllData($request);

		return view('sepCertObservacions.index', compact('sepCertObservacions'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('sepCertObservacions.create')
			->with( 'list', SepCertObservacion::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createSepCertObservacion $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		SepCertObservacion::create( $input );

		return redirect()->route('sepCertObservacions.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, SepCertObservacion $sepCertObservacion)
	{
		$sepCertObservacion=$sepCertObservacion->find($id);
		return view('sepCertObservacions.show', compact('sepCertObservacion'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, SepCertObservacion $sepCertObservacion)
	{
		$sepCertObservacion=$sepCertObservacion->find($id);
		return view('sepCertObservacions.edit', compact('sepCertObservacion'))
			->with( 'list', SepCertObservacion::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, SepCertObservacion $sepCertObservacion)
	{
		$sepCertObservacion=$sepCertObservacion->find($id);
		return view('sepCertObservacions.duplicate', compact('sepCertObservacion'))
			->with( 'list', SepCertObservacion::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, SepCertObservacion $sepCertObservacion, updateSepCertObservacion $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$sepCertObservacion=$sepCertObservacion->find($id);
		$sepCertObservacion->update( $input );

		return redirect()->route('sepCertObservacions.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,SepCertObservacion $sepCertObservacion)
	{
		$sepCertObservacion=$sepCertObservacion->find($id);
		$sepCertObservacion->delete();

		return redirect()->route('sepCertObservacions.index')->with('message', 'Registro Borrado.');
	}

}
