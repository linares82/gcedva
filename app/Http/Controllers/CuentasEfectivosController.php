<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\CuentasEfectivo;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateCuentasEfectivo;
use App\Http\Requests\createCuentasEfectivo;

class CuentasEfectivosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$cuentasEfectivos = CuentasEfectivo::getAllData($request);

		return view('cuentasEfectivos.index', compact('cuentasEfectivos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('cuentasEfectivos.create')
			->with( 'list', CuentasEfectivo::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createCuentasEfectivo $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		CuentasEfectivo::create( $input );

		return redirect()->route('cuentasEfectivos.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, CuentasEfectivo $cuentasEfectivo)
	{
		$cuentasEfectivo=$cuentasEfectivo->find($id);
		return view('cuentasEfectivos.show', compact('cuentasEfectivo'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, CuentasEfectivo $cuentasEfectivo)
	{
		$cuentasEfectivo=$cuentasEfectivo->find($id);
		return view('cuentasEfectivos.edit', compact('cuentasEfectivo'))
			->with( 'list', CuentasEfectivo::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, CuentasEfectivo $cuentasEfectivo)
	{
		$cuentasEfectivo=$cuentasEfectivo->find($id);
		return view('cuentasEfectivos.duplicate', compact('cuentasEfectivo'))
			->with( 'list', CuentasEfectivo::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, CuentasEfectivo $cuentasEfectivo, updateCuentasEfectivo $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$cuentasEfectivo=$cuentasEfectivo->find($id);
		$cuentasEfectivo->update( $input );

		return redirect()->route('cuentasEfectivos.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,CuentasEfectivo $cuentasEfectivo)
	{
		$cuentasEfectivo=$cuentasEfectivo->find($id);
		$cuentasEfectivo->delete();

		return redirect()->route('cuentasEfectivos.index')->with('message', 'Registro Borrado.');
	}

}
