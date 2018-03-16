<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\AvisosInicio;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateAvisosInicio;
use App\Http\Requests\createAvisosInicio;

class AvisosIniciosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$avisosInicios = AvisosInicio::getAllData($request);

		return view('avisosInicios.index', compact('avisosInicios'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('avisosInicios.create')
			->with( 'list', AvisosInicio::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createAvisosInicio $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		AvisosInicio::create( $input );

		return redirect()->route('avisosInicios.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, AvisosInicio $avisosInicio)
	{
		$avisosInicio=$avisosInicio->find($id);
		return view('avisosInicios.show', compact('avisosInicio'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, AvisosInicio $avisosInicio)
	{
		$avisosInicio=$avisosInicio->find($id);
		return view('avisosInicios.edit', compact('avisosInicio'))
			->with( 'list', AvisosInicio::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, AvisosInicio $avisosInicio)
	{
		$avisosInicio=$avisosInicio->find($id);
		return view('avisosInicios.duplicate', compact('avisosInicio'))
			->with( 'list', AvisosInicio::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, AvisosInicio $avisosInicio, updateAvisosInicio $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$avisosInicio=$avisosInicio->find($id);
		$avisosInicio->update( $input );

		return redirect()->route('avisosInicios.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,AvisosInicio $avisosInicio)
	{
		$avisosInicio=$avisosInicio->find($id);
		$avisosInicio->delete();

		return redirect()->route('avisosInicios.index')->with('message', 'Registro Borrado.');
	}

}
