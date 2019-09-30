<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\PlantillaEmpresaCampo;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updatePlantillaEmpresaCampo;
use App\Http\Requests\createPlantillaEmpresaCampo;

class PlantillaEmpresaCamposController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$plantillaEmpresaCampos = PlantillaEmpresaCampo::getAllData($request);

		return view('plantillaEmpresaCampos.index', compact('plantillaEmpresaCampos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('plantillaEmpresaCampos.create')
			->with( 'list', PlantillaEmpresaCampo::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createPlantillaEmpresaCampo $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		PlantillaEmpresaCampo::create( $input );

		return redirect()->route('plantillaEmpresaCampos.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, PlantillaEmpresaCampo $plantillaEmpresaCampo)
	{
		$plantillaEmpresaCampo=$plantillaEmpresaCampo->find($id);
		return view('plantillaEmpresaCampos.show', compact('plantillaEmpresaCampo'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, PlantillaEmpresaCampo $plantillaEmpresaCampo)
	{
		$plantillaEmpresaCampo=$plantillaEmpresaCampo->find($id);
		return view('plantillaEmpresaCampos.edit', compact('plantillaEmpresaCampo'))
			->with( 'list', PlantillaEmpresaCampo::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, PlantillaEmpresaCampo $plantillaEmpresaCampo)
	{
		$plantillaEmpresaCampo=$plantillaEmpresaCampo->find($id);
		return view('plantillaEmpresaCampos.duplicate', compact('plantillaEmpresaCampo'))
			->with( 'list', PlantillaEmpresaCampo::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, PlantillaEmpresaCampo $plantillaEmpresaCampo, updatePlantillaEmpresaCampo $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$plantillaEmpresaCampo=$plantillaEmpresaCampo->find($id);
		$plantillaEmpresaCampo->update( $input );

		return redirect()->route('plantillaEmpresaCampos.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,PlantillaEmpresaCampo $plantillaEmpresaCampo)
	{
		$plantillaEmpresaCampo=$plantillaEmpresaCampo->find($id);
		$plantillaEmpresaCampo->delete();

		return redirect()->route('plantillaEmpresaCampos.index')->with('message', 'Registro Borrado.');
	}

}
