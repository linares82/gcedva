<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\PorcentajeBeca;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updatePorcentajeBeca;
use App\Http\Requests\createPorcentajeBeca;

class PorcentajeBecasController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$porcentajeBecas = PorcentajeBeca::getAllData($request);

		return view('porcentajeBecas.index', compact('porcentajeBecas'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('porcentajeBecas.create')
			->with( 'list', PorcentajeBeca::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createPorcentajeBeca $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		PorcentajeBeca::create( $input );

		return redirect()->route('porcentajeBecas.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, PorcentajeBeca $porcentajeBeca)
	{
		$porcentajeBeca=$porcentajeBeca->find($id);
		return view('porcentajeBecas.show', compact('porcentajeBeca'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, PorcentajeBeca $porcentajeBeca)
	{
		$porcentajeBeca=$porcentajeBeca->find($id);
		return view('porcentajeBecas.edit', compact('porcentajeBeca'))
			->with( 'list', PorcentajeBeca::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, PorcentajeBeca $porcentajeBeca)
	{
		$porcentajeBeca=$porcentajeBeca->find($id);
		return view('porcentajeBecas.duplicate', compact('porcentajeBeca'))
			->with( 'list', PorcentajeBeca::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, PorcentajeBeca $porcentajeBeca, updatePorcentajeBeca $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$porcentajeBeca=$porcentajeBeca->find($id);
		$porcentajeBeca->update( $input );

		return redirect()->route('porcentajeBecas.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,PorcentajeBeca $porcentajeBeca)
	{
		$porcentajeBeca=$porcentajeBeca->find($id);
		$porcentajeBeca->delete();

		return redirect()->route('porcentajeBecas.index')->with('message', 'Registro Borrado.');
	}

}
