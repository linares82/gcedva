<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\SepTituloL;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateSepTituloL;
use App\Http\Requests\createSepTituloL;

class SepTituloLsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$sepTituloLs = SepTituloL::getAllData($request);

		return view('sepTituloLs.index', compact('sepTituloLs'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('sepTituloLs.create')
			->with( 'list', SepTituloL::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createSepTituloL $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		SepTituloL::create( $input );

		return redirect()->route('sepTituloLs.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, SepTituloL $sepTituloL)
	{
		$sepTituloL=$sepTituloL->find($id);
		return view('sepTituloLs.show', compact('sepTituloL'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, SepTituloL $sepTituloL)
	{
		$sepTituloL=$sepTituloL->find($id);
		return view('sepTituloLs.edit', compact('sepTituloL'))
			->with( 'list', SepTituloL::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, SepTituloL $sepTituloL)
	{
		$sepTituloL=$sepTituloL->find($id);
		return view('sepTituloLs.duplicate', compact('sepTituloL'))
			->with( 'list', SepTituloL::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, SepTituloL $sepTituloL, updateSepTituloL $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$sepTituloL=$sepTituloL->find($id);
		$sepTituloL->update( $input );

		return redirect()->route('sepTituloLs.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,SepTituloL $sepTituloL)
	{
		$sepTituloL=$sepTituloL->find($id);
		$sepTituloL->delete();

		return redirect()->route('sepTituloLs.index')->with('message', 'Registro Borrado.');
	}

}
