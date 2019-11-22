<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\StAutorizacionBeca;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateStAutorizacionBeca;
use App\Http\Requests\createStAutorizacionBeca;

class StAutorizacionBecasController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$stAutorizacionBecas = StAutorizacionBeca::getAllData($request);

		return view('stAutorizacionBecas.index', compact('stAutorizacionBecas'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('stAutorizacionBecas.create')
			->with( 'list', StAutorizacionBeca::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createStAutorizacionBeca $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		StAutorizacionBeca::create( $input );

		return redirect()->route('stAutorizacionBecas.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, StAutorizacionBeca $stAutorizacionBeca)
	{
		$stAutorizacionBeca=$stAutorizacionBeca->find($id);
		return view('stAutorizacionBecas.show', compact('stAutorizacionBeca'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, StAutorizacionBeca $stAutorizacionBeca)
	{
		$stAutorizacionBeca=$stAutorizacionBeca->find($id);
		return view('stAutorizacionBecas.edit', compact('stAutorizacionBeca'))
			->with( 'list', StAutorizacionBeca::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, StAutorizacionBeca $stAutorizacionBeca)
	{
		$stAutorizacionBeca=$stAutorizacionBeca->find($id);
		return view('stAutorizacionBecas.duplicate', compact('stAutorizacionBeca'))
			->with( 'list', StAutorizacionBeca::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, StAutorizacionBeca $stAutorizacionBeca, updateStAutorizacionBeca $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$stAutorizacionBeca=$stAutorizacionBeca->find($id);
		$stAutorizacionBeca->update( $input );

		return redirect()->route('stAutorizacionBecas.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,StAutorizacionBeca $stAutorizacionBeca)
	{
		$stAutorizacionBeca=$stAutorizacionBeca->find($id);
		$stAutorizacionBeca->delete();

		return redirect()->route('stAutorizacionBecas.index')->with('message', 'Registro Borrado.');
	}

}
