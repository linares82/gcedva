<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\PeticionMultipago;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updatePeticionMultipago;
use App\Http\Requests\createPeticionMultipago;

class PeticionMultipagosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$peticionMultipagos = PeticionMultipago::getAllData($request);

		return view('peticionMultipagos.index', compact('peticionMultipagos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('peticionMultipagos.create')
			->with( 'list', PeticionMultipago::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createPeticionMultipago $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		PeticionMultipago::create( $input );

		return redirect()->route('peticionMultipagos.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, PeticionMultipago $peticionMultipago)
	{
		$peticionMultipago=$peticionMultipago->find($id);
		return view('peticionMultipagos.show', compact('peticionMultipago'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, PeticionMultipago $peticionMultipago)
	{
		$peticionMultipago=$peticionMultipago->find($id);
		return view('peticionMultipagos.edit', compact('peticionMultipago'))
			->with( 'list', PeticionMultipago::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, PeticionMultipago $peticionMultipago)
	{
		$peticionMultipago=$peticionMultipago->find($id);
		return view('peticionMultipagos.duplicate', compact('peticionMultipago'))
			->with( 'list', PeticionMultipago::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, PeticionMultipago $peticionMultipago, updatePeticionMultipago $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$peticionMultipago=$peticionMultipago->find($id);
		$peticionMultipago->update( $input );

		return redirect()->route('peticionMultipagos.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,PeticionMultipago $peticionMultipago)
	{
		$peticionMultipago=$peticionMultipago->find($id);
		$peticionMultipago->delete();

		return redirect()->route('peticionMultipagos.index')->with('message', 'Registro Borrado.');
	}

}
