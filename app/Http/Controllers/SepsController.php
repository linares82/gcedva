<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Sep;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateSep;
use App\Http\Requests\createSep;

class SepsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$seps = Sep::getAllData($request);

		return view('seps.index', compact('seps'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('seps.create')
			->with( 'list', Sep::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createSep $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		Sep::create( $input );

		return redirect()->route('seps.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, Sep $sep)
	{
		$sep=$sep->find($id);
		return view('seps.show', compact('sep'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, Sep $sep)
	{
		$sep=$sep->find($id);
		return view('seps.edit', compact('sep'))
			->with( 'list', Sep::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, Sep $sep)
	{
		$sep=$sep->find($id);
		return view('seps.duplicate', compact('sep'))
			->with( 'list', Sep::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, Sep $sep, updateSep $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$sep=$sep->find($id);
		$sep->update( $input );

		return redirect()->route('seps.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,Sep $sep)
	{
		$sep=$sep->find($id);
		$sep->delete();

		return redirect()->route('seps.index')->with('message', 'Registro Borrado.');
	}

}
