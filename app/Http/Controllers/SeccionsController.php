<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Seccion;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateSeccion;
use App\Http\Requests\createSeccion;

class SeccionsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$seccions = Seccion::getAllData($request);

		return view('seccions.index', compact('seccions'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('seccions.create')
			->with( 'list', Seccion::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createSeccion $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		Seccion::create( $input );

		return redirect()->route('seccions.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, Seccion $seccion)
	{
		$seccion=$seccion->find($id);
		return view('seccions.show', compact('seccion'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, Seccion $seccion)
	{
		$seccion=$seccion->find($id);
		return view('seccions.edit', compact('seccion'))
			->with( 'list', Seccion::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, Seccion $seccion)
	{
		$seccion=$seccion->find($id);
		return view('seccions.duplicate', compact('seccion'))
			->with( 'list', Seccion::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, Seccion $seccion, updateSeccion $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$seccion=$seccion->find($id);
		$seccion->update( $input );

		return redirect()->route('seccions.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,Seccion $seccion)
	{
		$seccion=$seccion->find($id);
		$seccion->delete();

		return redirect()->route('seccions.index')->with('message', 'Registro Borrado.');
	}

}
