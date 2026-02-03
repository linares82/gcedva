<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\StLead;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateStLead;
use App\Http\Requests\createStLead;

class StLeadsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$stLeads = StLead::getAllData($request);

		return view('stLeads.index', compact('stLeads'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('stLeads.create')
			->with( 'list', StLead::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createStLead $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		StLead::create( $input );

		return redirect()->route('stLeads.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, StLead $stLead)
	{
		$stLead=$stLead->find($id);
		return view('stLeads.show', compact('stLead'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, StLead $stLead)
	{
		$stLead=$stLead->find($id);
		return view('stLeads.edit', compact('stLead'))
			->with( 'list', StLead::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, StLead $stLead)
	{
		$stLead=$stLead->find($id);
		return view('stLeads.duplicate', compact('stLead'))
			->with( 'list', StLead::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, StLead $stLead, updateStLead $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$stLead=$stLead->find($id);
		$stLead->update( $input );

		return redirect()->route('stLeads.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,StLead $stLead)
	{
		$stLead=$stLead->find($id);
		$stLead->delete();

		return redirect()->route('stLeads.index')->with('message', 'Registro Borrado.');
	}

}
