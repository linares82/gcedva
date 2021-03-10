<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\StProspecto;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateStProspecto;
use App\Http\Requests\createStProspecto;

class StProspectosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$stProspectos = StProspecto::getAllData($request);

		return view('stProspectos.index', compact('stProspectos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('stProspectos.create')
			->with( 'list', StProspecto::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createStProspecto $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		StProspecto::create( $input );

		return redirect()->route('stProspectos.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, StProspecto $stProspecto)
	{
		$stProspecto=$stProspecto->find($id);
		return view('stProspectos.show', compact('stProspecto'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, StProspecto $stProspecto)
	{
		$stProspecto=$stProspecto->find($id);
		return view('stProspectos.edit', compact('stProspecto'))
			->with( 'list', StProspecto::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, StProspecto $stProspecto)
	{
		$stProspecto=$stProspecto->find($id);
		return view('stProspectos.duplicate', compact('stProspecto'))
			->with( 'list', StProspecto::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, StProspecto $stProspecto, updateStProspecto $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$stProspecto=$stProspecto->find($id);
		$stProspecto->update( $input );

		return redirect()->route('stProspectos.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,StProspecto $stProspecto)
	{
		$stProspecto=$stProspecto->find($id);
		$stProspecto->delete();

		return redirect()->route('stProspectos.index')->with('message', 'Registro Borrado.');
	}

}
