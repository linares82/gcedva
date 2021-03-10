<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\HStProspecto;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateHStProspecto;
use App\Http\Requests\createHStProspecto;

class HStProspectosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$hStProspectos = HStProspecto::getAllData($request);

		return view('hStProspectos.index', compact('hStProspectos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('hStProspectos.create')
			->with( 'list', HStProspecto::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createHStProspecto $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		HStProspecto::create( $input );

		return redirect()->route('hStProspectos.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, HStProspecto $hStProspecto)
	{
		$hStProspecto=$hStProspecto->find($id);
		return view('hStProspectos.show', compact('hStProspecto'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, HStProspecto $hStProspecto)
	{
		$hStProspecto=$hStProspecto->find($id);
		return view('hStProspectos.edit', compact('hStProspecto'))
			->with( 'list', HStProspecto::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, HStProspecto $hStProspecto)
	{
		$hStProspecto=$hStProspecto->find($id);
		return view('hStProspectos.duplicate', compact('hStProspecto'))
			->with( 'list', HStProspecto::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, HStProspecto $hStProspecto, updateHStProspecto $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$hStProspecto=$hStProspecto->find($id);
		$hStProspecto->update( $input );

		return redirect()->route('hStProspectos.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,HStProspecto $hStProspecto)
	{
		$hStProspecto=$hStProspecto->find($id);
		$hStProspecto->delete();

		return redirect()->route('hStProspectos.index')->with('message', 'Registro Borrado.');
	}

}
