<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\SepCargo;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateSepCargo;
use App\Http\Requests\createSepCargo;

class SepCargosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$sepCargos = SepCargo::getAllData($request);

		return view('sepCargos.index', compact('sepCargos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('sepCargos.create')
			->with( 'list', SepCargo::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createSepCargo $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		SepCargo::create( $input );

		return redirect()->route('sepCargos.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, SepCargo $sepCargo)
	{
		$sepCargo=$sepCargo->find($id);
		return view('sepCargos.show', compact('sepCargo'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, SepCargo $sepCargo)
	{
		$sepCargo=$sepCargo->find($id);
		return view('sepCargos.edit', compact('sepCargo'))
			->with( 'list', SepCargo::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, SepCargo $sepCargo)
	{
		$sepCargo=$sepCargo->find($id);
		return view('sepCargos.duplicate', compact('sepCargo'))
			->with( 'list', SepCargo::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, SepCargo $sepCargo, updateSepCargo $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$sepCargo=$sepCargo->find($id);
		$sepCargo->update( $input );

		return redirect()->route('sepCargos.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,SepCargo $sepCargo)
	{
		$sepCargo=$sepCargo->find($id);
		$sepCargo->delete();

		return redirect()->route('sepCargos.index')->with('message', 'Registro Borrado.');
	}

}
