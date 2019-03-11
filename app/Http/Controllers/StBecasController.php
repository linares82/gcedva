<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\StBeca;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateStBeca;
use App\Http\Requests\createStBeca;

class StBecasController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$stBecas = StBeca::getAllData($request);

		return view('stBecas.index', compact('stBecas'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('stBecas.create')
			->with( 'list', StBeca::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createStBeca $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		StBeca::create( $input );

		return redirect()->route('stBecas.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, StBeca $stBeca)
	{
		$stBeca=$stBeca->find($id);
		return view('stBecas.show', compact('stBeca'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, StBeca $stBeca)
	{
		$stBeca=$stBeca->find($id);
		return view('stBecas.edit', compact('stBeca'))
			->with( 'list', StBeca::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, StBeca $stBeca)
	{
		$stBeca=$stBeca->find($id);
		return view('stBecas.duplicate', compact('stBeca'))
			->with( 'list', StBeca::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, StBeca $stBeca, updateStBeca $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$stBeca=$stBeca->find($id);
		$stBeca->update( $input );

		return redirect()->route('stBecas.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,StBeca $stBeca)
	{
		$stBeca=$stBeca->find($id);
		$stBeca->delete();

		return redirect()->route('stBecas.index')->with('message', 'Registro Borrado.');
	}

}
