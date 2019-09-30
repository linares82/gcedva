<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\PlantillaEmpresaCond;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updatePlantillaEmpresaCond;
use App\Http\Requests\createPlantillaEmpresaCond;

class PlantillaEmpresaCondsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$plantillaEmpresaConds = PlantillaEmpresaCond::getAllData($request);

		return view('plantillaEmpresaConds.index', compact('plantillaEmpresaConds'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('plantillaEmpresaConds.create')
			->with( 'list', PlantillaEmpresaCond::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createPlantillaEmpresaCond $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		PlantillaEmpresaCond::create( $input );

		return redirect()->route('plantillaEmpresaConds.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, PlantillaEmpresaCond $plantillaEmpresaCond)
	{
		$plantillaEmpresaCond=$plantillaEmpresaCond->find($id);
		return view('plantillaEmpresaConds.show', compact('plantillaEmpresaCond'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, PlantillaEmpresaCond $plantillaEmpresaCond)
	{
		$plantillaEmpresaCond=$plantillaEmpresaCond->find($id);
		return view('plantillaEmpresaConds.edit', compact('plantillaEmpresaCond'))
			->with( 'list', PlantillaEmpresaCond::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, PlantillaEmpresaCond $plantillaEmpresaCond)
	{
		$plantillaEmpresaCond=$plantillaEmpresaCond->find($id);
		return view('plantillaEmpresaConds.duplicate', compact('plantillaEmpresaCond'))
			->with( 'list', PlantillaEmpresaCond::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, PlantillaEmpresaCond $plantillaEmpresaCond, updatePlantillaEmpresaCond $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$plantillaEmpresaCond=$plantillaEmpresaCond->find($id);
		$plantillaEmpresaCond->update( $input );

		return redirect()->route('plantillaEmpresaConds.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,PlantillaEmpresaCond $plantillaEmpresaCond)
	{
		$plantillaEmpresaCond=$plantillaEmpresaCond->find($id);
		$plantillaEmpresaCond->usu_mod_id=Auth::user()->id;
		$plantillaEmpresaCond->save();
		$id=$plantillaEmpresaCond->plantilla_empresa_id;
		$plantillaEmpresaCond->delete();

		return redirect()->route('plantillaEmpresas.edit',$id)->with('message', 'Registro Borrado.');
	}

}
