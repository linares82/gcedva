<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\HCuentasEfectivo;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateHCuentasEfectivo;
use App\Http\Requests\createHCuentasEfectivo;

class HCuentasEfectivosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$hCuentasEfectivos = HCuentasEfectivo::getAllData($request);

		return view('hCuentasEfectivos.index', compact('hCuentasEfectivos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('hCuentasEfectivos.create')
			->with( 'list', HCuentasEfectivo::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createHCuentasEfectivo $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		HCuentasEfectivo::create( $input );

		return redirect()->route('hCuentasEfectivos.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, HCuentasEfectivo $hCuentasEfectivo)
	{
		$hCuentasEfectivo=$hCuentasEfectivo->find($id);
		return view('hCuentasEfectivos.show', compact('hCuentasEfectivo'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, HCuentasEfectivo $hCuentasEfectivo)
	{
		$hCuentasEfectivo=$hCuentasEfectivo->find($id);
		return view('hCuentasEfectivos.edit', compact('hCuentasEfectivo'))
			->with( 'list', HCuentasEfectivo::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, HCuentasEfectivo $hCuentasEfectivo)
	{
		$hCuentasEfectivo=$hCuentasEfectivo->find($id);
		return view('hCuentasEfectivos.duplicate', compact('hCuentasEfectivo'))
			->with( 'list', HCuentasEfectivo::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, HCuentasEfectivo $hCuentasEfectivo, updateHCuentasEfectivo $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$hCuentasEfectivo=$hCuentasEfectivo->find($id);
		$hCuentasEfectivo->update( $input );

		return redirect()->route('hCuentasEfectivos.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,HCuentasEfectivo $hCuentasEfectivo)
	{
		$hCuentasEfectivo=$hCuentasEfectivo->find($id);
		$hCuentasEfectivo->delete();

		return redirect()->route('hCuentasEfectivos.index')->with('message', 'Registro Borrado.');
	}

}
