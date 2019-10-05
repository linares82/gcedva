<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\HistoriClienteInscripcion;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateHistoriClienteInscripcion;
use App\Http\Requests\createHistoriClienteInscripcion;

class HistoriClienteInscripcionsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$historiClienteInscripcions = HistoriClienteInscripcion::getAllData($request);

		return view('historiClienteInscripcions.index', compact('historiClienteInscripcions'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('historiClienteInscripcions.create')
			->with( 'list', HistoriClienteInscripcion::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createHistoriClienteInscripcion $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		HistoriClienteInscripcion::create( $input );

		return redirect()->route('historiClienteInscripcions.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, HistoriClienteInscripcion $historiClienteInscripcion)
	{
		$historiClienteInscripcion=$historiClienteInscripcion->find($id);
		return view('historiClienteInscripcions.show', compact('historiClienteInscripcion'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, HistoriClienteInscripcion $historiClienteInscripcion)
	{
		$historiClienteInscripcion=$historiClienteInscripcion->find($id);
		return view('historiClienteInscripcions.edit', compact('historiClienteInscripcion'))
			->with( 'list', HistoriClienteInscripcion::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, HistoriClienteInscripcion $historiClienteInscripcion)
	{
		$historiClienteInscripcion=$historiClienteInscripcion->find($id);
		return view('historiClienteInscripcions.duplicate', compact('historiClienteInscripcion'))
			->with( 'list', HistoriClienteInscripcion::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, HistoriClienteInscripcion $historiClienteInscripcion, updateHistoriClienteInscripcion $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$historiClienteInscripcion=$historiClienteInscripcion->find($id);
		$historiClienteInscripcion->update( $input );

		return redirect()->route('historiClienteInscripcions.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,HistoriClienteInscripcion $historiClienteInscripcion)
	{
		$historiClienteInscripcion=$historiClienteInscripcion->find($id);
		$historiClienteInscripcion->delete();

		return redirect()->route('historiClienteInscripcions.index')->with('message', 'Registro Borrado.');
	}

}
