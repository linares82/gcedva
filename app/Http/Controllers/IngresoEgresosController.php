<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\IngresoEgreso;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateIngresoEgreso;
use App\Http\Requests\createIngresoEgreso;

class IngresoEgresosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$ingresoEgresos = IngresoEgreso::getAllData($request);

		return view('ingresoEgresos.index', compact('ingresoEgresos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('ingresoEgresos.create')
			->with( 'list', IngresoEgreso::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createIngresoEgreso $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		IngresoEgreso::create( $input );

		return redirect()->route('ingresoEgresos.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, IngresoEgreso $ingresoEgreso)
	{
		$ingresoEgreso=$ingresoEgreso->find($id);
		return view('ingresoEgresos.show', compact('ingresoEgreso'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, IngresoEgreso $ingresoEgreso)
	{
		$ingresoEgreso=$ingresoEgreso->find($id);
		return view('ingresoEgresos.edit', compact('ingresoEgreso'))
			->with( 'list', IngresoEgreso::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, IngresoEgreso $ingresoEgreso)
	{
		$ingresoEgreso=$ingresoEgreso->find($id);
		return view('ingresoEgresos.duplicate', compact('ingresoEgreso'))
			->with( 'list', IngresoEgreso::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, IngresoEgreso $ingresoEgreso, updateIngresoEgreso $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$ingresoEgreso=$ingresoEgreso->find($id);
		$ingresoEgreso->update( $input );

		return redirect()->route('ingresoEgresos.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,IngresoEgreso $ingresoEgreso)
	{
		$ingresoEgreso=$ingresoEgreso->find($id);
		$ingresoEgreso->delete();

		return redirect()->route('ingresoEgresos.index')->with('message', 'Registro Borrado.');
	}

}
