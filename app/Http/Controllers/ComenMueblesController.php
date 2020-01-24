<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\ComenMueble;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateComenMueble;
use App\Http\Requests\createComenMueble;

class ComenMueblesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$comenMuebles = ComenMueble::getAllData($request);

		return view('comenMuebles.index', compact('comenMuebles'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('comenMuebles.create')
			->with( 'list', ComenMueble::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createComenMueble $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		ComenMueble::create( $input );

		return redirect()->route('comenMuebles.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, ComenMueble $comenMueble)
	{
		$comenMueble=$comenMueble->find($id);
		return view('comenMuebles.show', compact('comenMueble'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, ComenMueble $comenMueble)
	{
		$comenMueble=$comenMueble->find($id);
		return view('comenMuebles.edit', compact('comenMueble'))
			->with( 'list', ComenMueble::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, ComenMueble $comenMueble)
	{
		$comenMueble=$comenMueble->find($id);
		return view('comenMuebles.duplicate', compact('comenMueble'))
			->with( 'list', ComenMueble::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, ComenMueble $comenMueble, updateComenMueble $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$comenMueble=$comenMueble->find($id);
		$comenMueble->update( $input );

		return redirect()->route('comenMuebles.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,ComenMueble $comenMueble)
	{
		$comenMueble=$comenMueble->find($id);
		$comenMueble->delete();

		return redirect()->route('comenMuebles.index')->with('message', 'Registro Borrado.');
	}

}
