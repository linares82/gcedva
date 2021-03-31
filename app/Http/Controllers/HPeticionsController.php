<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\HPeticion;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateHPeticion;
use App\Http\Requests\createHPeticion;

class HPeticionsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$hPeticions = HPeticion::getAllData($request);

		return view('hPeticions.index', compact('hPeticions'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('hPeticions.create')
			->with( 'list', HPeticion::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createHPeticion $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		HPeticion::create( $input );

		return redirect()->route('hPeticions.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, HPeticion $hPeticion)
	{
		$hPeticion=$hPeticion->find($id);
		return view('hPeticions.show', compact('hPeticion'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, HPeticion $hPeticion)
	{
		$hPeticion=$hPeticion->find($id);
		return view('hPeticions.edit', compact('hPeticion'))
			->with( 'list', HPeticion::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, HPeticion $hPeticion)
	{
		$hPeticion=$hPeticion->find($id);
		return view('hPeticions.duplicate', compact('hPeticion'))
			->with( 'list', HPeticion::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, HPeticion $hPeticion, updateHPeticion $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$hPeticion=$hPeticion->find($id);
		$hPeticion->update( $input );

		return redirect()->route('hPeticions.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,HPeticion $hPeticion)
	{
		$hPeticion=$hPeticion->find($id);
		$hPeticion->delete();

		return redirect()->route('hPeticions.index')->with('message', 'Registro Borrado.');
	}

}
