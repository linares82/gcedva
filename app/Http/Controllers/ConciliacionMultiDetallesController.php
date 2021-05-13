<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\ConciliacionMultiDetalle;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateConciliacionMultiDetalle;
use App\Http\Requests\createConciliacionMultiDetalle;

class ConciliacionMultiDetallesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$conciliacionMultiDetalles = ConciliacionMultiDetalle::getAllData($request);

		return view('conciliacionMultiDetalles.index', compact('conciliacionMultiDetalles'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('conciliacionMultiDetalles.create')
			->with( 'list', ConciliacionMultiDetalle::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createConciliacionMultiDetalle $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		ConciliacionMultiDetalle::create( $input );

		return redirect()->route('conciliacionMultiDetalles.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, ConciliacionMultiDetalle $conciliacionMultiDetalle)
	{
		$conciliacionMultiDetalle=$conciliacionMultiDetalle->find($id);
		return view('conciliacionMultiDetalles.show', compact('conciliacionMultiDetalle'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, ConciliacionMultiDetalle $conciliacionMultiDetalle)
	{
		$conciliacionMultiDetalle=$conciliacionMultiDetalle->find($id);
		return view('conciliacionMultiDetalles.edit', compact('conciliacionMultiDetalle'))
			->with( 'list', ConciliacionMultiDetalle::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, ConciliacionMultiDetalle $conciliacionMultiDetalle)
	{
		$conciliacionMultiDetalle=$conciliacionMultiDetalle->find($id);
		return view('conciliacionMultiDetalles.duplicate', compact('conciliacionMultiDetalle'))
			->with( 'list', ConciliacionMultiDetalle::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, ConciliacionMultiDetalle $conciliacionMultiDetalle, updateConciliacionMultiDetalle $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$conciliacionMultiDetalle=$conciliacionMultiDetalle->find($id);
		$conciliacionMultiDetalle->update( $input );

		return redirect()->route('conciliacionMultiDetalles.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,ConciliacionMultiDetalle $conciliacionMultiDetalle)
	{
		$conciliacionMultiDetalle=$conciliacionMultiDetalle->find($id);
		$conciliacionMultiDetalle->delete();

		return redirect()->route('conciliacionMultiDetalles.index')->with('message', 'Registro Borrado.');
	}

	
}
