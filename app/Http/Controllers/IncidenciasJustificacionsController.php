<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\IncidenciasJustificacion;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateIncidenciasJustificacion;
use App\Http\Requests\createIncidenciasJustificacion;

class IncidenciasJustificacionsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$incidenciasJustificacions = IncidenciasJustificacion::getAllData($request);

		return view('incidenciasJustificacions.index', compact('incidenciasJustificacions'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('incidenciasJustificacions.create')
			->with( 'list', IncidenciasJustificacion::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createIncidenciasJustificacion $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		IncidenciasJustificacion::create( $input );

		return redirect()->route('incidenciasJustificacions.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, IncidenciasJustificacion $incidenciasJustificacion)
	{
		$incidenciasJustificacion=$incidenciasJustificacion->find($id);
		return view('incidenciasJustificacions.show', compact('incidenciasJustificacion'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, IncidenciasJustificacion $incidenciasJustificacion)
	{
		$incidenciasJustificacion=$incidenciasJustificacion->find($id);
		return view('incidenciasJustificacions.edit', compact('incidenciasJustificacion'))
			->with( 'list', IncidenciasJustificacion::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, IncidenciasJustificacion $incidenciasJustificacion)
	{
		$incidenciasJustificacion=$incidenciasJustificacion->find($id);
		return view('incidenciasJustificacions.duplicate', compact('incidenciasJustificacion'))
			->with( 'list', IncidenciasJustificacion::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, IncidenciasJustificacion $incidenciasJustificacion, updateIncidenciasJustificacion $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$incidenciasJustificacion=$incidenciasJustificacion->find($id);
		$incidenciasJustificacion->update( $input );

		return redirect()->route('incidenciasJustificacions.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,IncidenciasJustificacion $incidenciasJustificacion)
	{
		$incidenciasJustificacion=$incidenciasJustificacion->find($id);
		$incidenciasJustificacion->delete();

		return redirect()->route('incidenciasJustificacions.index')->with('message', 'Registro Borrado.');
	}

}
