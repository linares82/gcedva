<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\ProcesoActivoABaja;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateProcesoActivoABaja;
use App\Http\Requests\createProcesoActivoABaja;

class ProcesoActivoABajasController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$procesoActivoABajas = ProcesoActivoABaja::getAllData($request);

		return view('procesoActivoABajas.index', compact('procesoActivoABajas'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('procesoActivoABajas.create')
			->with( 'list', ProcesoActivoABaja::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createProcesoActivoABaja $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		ProcesoActivoABaja::create( $input );

		return redirect()->route('procesoActivoABajas.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, ProcesoActivoABaja $procesoActivoABaja)
	{
		$procesoActivoABaja=$procesoActivoABaja->find($id);
		return view('procesoActivoABajas.show', compact('procesoActivoABaja'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, ProcesoActivoABaja $procesoActivoABaja)
	{
		$procesoActivoABaja=$procesoActivoABaja->find($id);
		return view('procesoActivoABajas.edit', compact('procesoActivoABaja'))
			->with( 'list', ProcesoActivoABaja::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, ProcesoActivoABaja $procesoActivoABaja)
	{
		$procesoActivoABaja=$procesoActivoABaja->find($id);
		return view('procesoActivoABajas.duplicate', compact('procesoActivoABaja'))
			->with( 'list', ProcesoActivoABaja::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, ProcesoActivoABaja $procesoActivoABaja, updateProcesoActivoABaja $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$procesoActivoABaja=$procesoActivoABaja->find($id);
		$procesoActivoABaja->update( $input );

		return redirect()->route('procesoActivoABajas.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,ProcesoActivoABaja $procesoActivoABaja)
	{
		$procesoActivoABaja=$procesoActivoABaja->find($id);
		$procesoActivoABaja->delete();

		return redirect()->route('procesoActivoABajas.index')->with('message', 'Registro Borrado.');
	}

}
