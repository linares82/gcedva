<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\SepCarrera;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateSepCarrera;
use App\Http\Requests\createSepCarrera;

class SepCarrerasController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$sepCarreras = SepCarrera::getAllData($request);

		return view('sepCarreras.index', compact('sepCarreras'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('sepCarreras.create')
			->with( 'list', SepCarrera::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createSepCarrera $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		SepCarrera::create( $input );

		return redirect()->route('sepCarreras.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, SepCarrera $sepCarrera)
	{
		$sepCarrera=$sepCarrera->find($id);
		return view('sepCarreras.show', compact('sepCarrera'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, SepCarrera $sepCarrera)
	{
		$sepCarrera=$sepCarrera->find($id);
		return view('sepCarreras.edit', compact('sepCarrera'))
			->with( 'list', SepCarrera::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, SepCarrera $sepCarrera)
	{
		$sepCarrera=$sepCarrera->find($id);
		return view('sepCarreras.duplicate', compact('sepCarrera'))
			->with( 'list', SepCarrera::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, SepCarrera $sepCarrera, updateSepCarrera $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$sepCarrera=$sepCarrera->find($id);
		$sepCarrera->update( $input );

		return redirect()->route('sepCarreras.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,SepCarrera $sepCarrera)
	{
		$sepCarrera=$sepCarrera->find($id);
		$sepCarrera->delete();

		return redirect()->route('sepCarreras.index')->with('message', 'Registro Borrado.');
	}

}
