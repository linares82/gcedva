<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\SepModalidadTitulacion;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateSepModalidadTitulacion;
use App\Http\Requests\createSepModalidadTitulacion;

class SepModalidadTitulacionsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$sepModalidadTitulacions = SepModalidadTitulacion::getAllData($request);

		return view('sepModalidadTitulacions.index', compact('sepModalidadTitulacions'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('sepModalidadTitulacions.create')
			->with( 'list', SepModalidadTitulacion::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createSepModalidadTitulacion $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		SepModalidadTitulacion::create( $input );

		return redirect()->route('sepModalidadTitulacions.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, SepModalidadTitulacion $sepModalidadTitulacion)
	{
		$sepModalidadTitulacion=$sepModalidadTitulacion->find($id);
		return view('sepModalidadTitulacions.show', compact('sepModalidadTitulacion'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, SepModalidadTitulacion $sepModalidadTitulacion)
	{
		$sepModalidadTitulacion=$sepModalidadTitulacion->find($id);
		return view('sepModalidadTitulacions.edit', compact('sepModalidadTitulacion'))
			->with( 'list', SepModalidadTitulacion::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, SepModalidadTitulacion $sepModalidadTitulacion)
	{
		$sepModalidadTitulacion=$sepModalidadTitulacion->find($id);
		return view('sepModalidadTitulacions.duplicate', compact('sepModalidadTitulacion'))
			->with( 'list', SepModalidadTitulacion::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, SepModalidadTitulacion $sepModalidadTitulacion, updateSepModalidadTitulacion $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$sepModalidadTitulacion=$sepModalidadTitulacion->find($id);
		$sepModalidadTitulacion->update( $input );

		return redirect()->route('sepModalidadTitulacions.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,SepModalidadTitulacion $sepModalidadTitulacion)
	{
		$sepModalidadTitulacion=$sepModalidadTitulacion->find($id);
		$sepModalidadTitulacion->delete();

		return redirect()->route('sepModalidadTitulacions.index')->with('message', 'Registro Borrado.');
	}

}
