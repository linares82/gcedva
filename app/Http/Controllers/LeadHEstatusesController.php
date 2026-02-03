<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\LeadHEstatus;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateLeadHEstatus;
use App\Http\Requests\createLeadHEstatus;

class LeadHEstatusesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$leadHEstatuses = LeadHEstatus::getAllData($request);

		return view('leadHEstatuses.index', compact('leadHEstatuses'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('leadHEstatuses.create')
			->with( 'list', LeadHEstatus::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createLeadHEstatus $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		LeadHEstatus::create( $input );

		return redirect()->route('leadHEstatuses.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, LeadHEstatus $leadHEstatus)
	{
		$leadHEstatus=$leadHEstatus->find($id);
		return view('leadHEstatuses.show', compact('leadHEstatus'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, LeadHEstatus $leadHEstatus)
	{
		$leadHEstatus=$leadHEstatus->find($id);
		return view('leadHEstatuses.edit', compact('leadHEstatus'))
			->with( 'list', LeadHEstatus::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, LeadHEstatus $leadHEstatus)
	{
		$leadHEstatus=$leadHEstatus->find($id);
		return view('leadHEstatuses.duplicate', compact('leadHEstatus'))
			->with( 'list', LeadHEstatus::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, LeadHEstatus $leadHEstatus, updateLeadHEstatus $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$leadHEstatus=$leadHEstatus->find($id);
		$leadHEstatus->update( $input );

		return redirect()->route('leadHEstatuses.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,LeadHEstatus $leadHEstatus)
	{
		$leadHEstatus=$leadHEstatus->find($id);
		$leadHEstatus->delete();

		return redirect()->route('leadHEstatuses.index')->with('message', 'Registro Borrado.');
	}

}
