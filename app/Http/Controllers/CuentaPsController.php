<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\CuentaP;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateCuentaP;
use App\Http\Requests\createCuentaP;

class CuentaPsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$cuentaPs = CuentaP::getAllData($request);

		return view('cuentaPs.index', compact('cuentaPs'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('cuentaPs.create')
			->with( 'list', CuentaP::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createCuentaP $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		CuentaP::create( $input );

		return redirect()->route('cuentaPs.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, CuentaP $cuentaP)
	{
		$cuentaP=$cuentaP->find($id);
		return view('cuentaPs.show', compact('cuentaP'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, CuentaP $cuentaP)
	{
		$cuentaP=$cuentaP->find($id);
		return view('cuentaPs.edit', compact('cuentaP'))
			->with( 'list', CuentaP::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, CuentaP $cuentaP)
	{
		$cuentaP=$cuentaP->find($id);
		return view('cuentaPs.duplicate', compact('cuentaP'))
			->with( 'list', CuentaP::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, CuentaP $cuentaP, updateCuentaP $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$cuentaP=$cuentaP->find($id);
		$cuentaP->update( $input );

		return redirect()->route('cuentaPs.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,CuentaP $cuentaP)
	{
		$cuentaP=$cuentaP->find($id);
		$cuentaP->delete();

		return redirect()->route('cuentaPs.index')->with('message', 'Registro Borrado.');
	}

}
