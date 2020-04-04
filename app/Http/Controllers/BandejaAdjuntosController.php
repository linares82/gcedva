<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\BandejaAdjunto;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateBandejaAdjunto;
use App\Http\Requests\createBandejaAdjunto;

class BandejaAdjuntosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$bandejaAdjuntos = BandejaAdjunto::getAllData($request);

		return view('bandejaAdjuntos.index', compact('bandejaAdjuntos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('bandejaAdjuntos.create')
			->with( 'list', BandejaAdjunto::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createBandejaAdjunto $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		BandejaAdjunto::create( $input );

		return redirect()->route('bandejaAdjuntos.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, BandejaAdjunto $bandejaAdjunto)
	{
		$bandejaAdjunto=$bandejaAdjunto->find($id);
		return view('bandejaAdjuntos.show', compact('bandejaAdjunto'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, BandejaAdjunto $bandejaAdjunto)
	{
		$bandejaAdjunto=$bandejaAdjunto->find($id);
		return view('bandejaAdjuntos.edit', compact('bandejaAdjunto'))
			->with( 'list', BandejaAdjunto::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, BandejaAdjunto $bandejaAdjunto)
	{
		$bandejaAdjunto=$bandejaAdjunto->find($id);
		return view('bandejaAdjuntos.duplicate', compact('bandejaAdjunto'))
			->with( 'list', BandejaAdjunto::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, BandejaAdjunto $bandejaAdjunto, updateBandejaAdjunto $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$bandejaAdjunto=$bandejaAdjunto->find($id);
		$bandejaAdjunto->update( $input );

		return redirect()->route('bandejaAdjuntos.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,BandejaAdjunto $bandejaAdjunto)
	{
		$bandejaAdjunto=$bandejaAdjunto->find($id);
		$bandejaAdjunto->delete();

		return redirect()->route('bandejaAdjuntos.index')->with('message', 'Registro Borrado.');
	}

}
