<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\DuracionPeriodo;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateDuracionPeriodo;
use App\Http\Requests\createDuracionPeriodo;

class DuracionPeriodosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$duracionPeriodos = DuracionPeriodo::getAllData($request);

		return view('duracionPeriodos.index', compact('duracionPeriodos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('duracionPeriodos.create')
			->with( 'list', DuracionPeriodo::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createDuracionPeriodo $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		DuracionPeriodo::create( $input );

		return redirect()->route('duracionPeriodos.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, DuracionPeriodo $duracionPeriodo)
	{
		$duracionPeriodo=$duracionPeriodo->find($id);
		return view('duracionPeriodos.show', compact('duracionPeriodo'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, DuracionPeriodo $duracionPeriodo)
	{
		$duracionPeriodo=$duracionPeriodo->find($id);
		return view('duracionPeriodos.edit', compact('duracionPeriodo'))
			->with( 'list', DuracionPeriodo::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, DuracionPeriodo $duracionPeriodo)
	{
		$duracionPeriodo=$duracionPeriodo->find($id);
		return view('duracionPeriodos.duplicate', compact('duracionPeriodo'))
			->with( 'list', DuracionPeriodo::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, DuracionPeriodo $duracionPeriodo, updateDuracionPeriodo $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$duracionPeriodo=$duracionPeriodo->find($id);
		$duracionPeriodo->update( $input );

		return redirect()->route('duracionPeriodos.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,DuracionPeriodo $duracionPeriodo)
	{
		$duracionPeriodo=$duracionPeriodo->find($id);
		$duracionPeriodo->delete();

		return redirect()->route('duracionPeriodos.index')->with('message', 'Registro Borrado.');
	}

}
