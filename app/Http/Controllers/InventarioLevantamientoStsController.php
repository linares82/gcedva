<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\InventarioLevantamientoSt;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateInventarioLevantamientoSt;
use App\Http\Requests\createInventarioLevantamientoSt;

class InventarioLevantamientoStsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$inventarioLevantamientoSts = InventarioLevantamientoSt::getAllData($request);

		return view('inventarioLevantamientoSts.index', compact('inventarioLevantamientoSts'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('inventarioLevantamientoSts.create')
			->with( 'list', InventarioLevantamientoSt::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createInventarioLevantamientoSt $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		InventarioLevantamientoSt::create( $input );

		return redirect()->route('inventarioLevantamientoSts.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, InventarioLevantamientoSt $inventarioLevantamientoSt)
	{
		$inventarioLevantamientoSt=$inventarioLevantamientoSt->find($id);
		return view('inventarioLevantamientoSts.show', compact('inventarioLevantamientoSt'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, InventarioLevantamientoSt $inventarioLevantamientoSt)
	{
		$inventarioLevantamientoSt=$inventarioLevantamientoSt->find($id);
		return view('inventarioLevantamientoSts.edit', compact('inventarioLevantamientoSt'))
			->with( 'list', InventarioLevantamientoSt::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, InventarioLevantamientoSt $inventarioLevantamientoSt)
	{
		$inventarioLevantamientoSt=$inventarioLevantamientoSt->find($id);
		return view('inventarioLevantamientoSts.duplicate', compact('inventarioLevantamientoSt'))
			->with( 'list', InventarioLevantamientoSt::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, InventarioLevantamientoSt $inventarioLevantamientoSt, updateInventarioLevantamientoSt $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$inventarioLevantamientoSt=$inventarioLevantamientoSt->find($id);
		$inventarioLevantamientoSt->update( $input );

		return redirect()->route('inventarioLevantamientoSts.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,InventarioLevantamientoSt $inventarioLevantamientoSt)
	{
		$inventarioLevantamientoSt=$inventarioLevantamientoSt->find($id);
		$inventarioLevantamientoSt->delete();

		return redirect()->route('inventarioLevantamientoSts.index')->with('message', 'Registro Borrado.');
	}

}
