<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\ProspectoHEstatuse;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateProspectoHEstatuse;
use App\Http\Requests\createProspectoHEstatuse;

class ProspectoHEstatusesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$prospectoHEstatuses = ProspectoHEstatuse::getAllData($request);

		return view('prospectoHEstatuses.index', compact('prospectoHEstatuses'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('prospectoHEstatuses.create')
			->with( 'list', ProspectoHEstatuse::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createProspectoHEstatuse $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		ProspectoHEstatuse::create( $input );

		return redirect()->route('prospectoHEstatuses.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, ProspectoHEstatuse $prospectoHEstatuse)
	{
		$prospectoHEstatuse=$prospectoHEstatuse->find($id);
		return view('prospectoHEstatuses.show', compact('prospectoHEstatuse'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, ProspectoHEstatuse $prospectoHEstatuse)
	{
		$prospectoHEstatuse=$prospectoHEstatuse->find($id);
		return view('prospectoHEstatuses.edit', compact('prospectoHEstatuse'))
			->with( 'list', ProspectoHEstatuse::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, ProspectoHEstatuse $prospectoHEstatuse)
	{
		$prospectoHEstatuse=$prospectoHEstatuse->find($id);
		return view('prospectoHEstatuses.duplicate', compact('prospectoHEstatuse'))
			->with( 'list', ProspectoHEstatuse::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, ProspectoHEstatuse $prospectoHEstatuse, updateProspectoHEstatuse $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$prospectoHEstatuse=$prospectoHEstatuse->find($id);
		$prospectoHEstatuse->update( $input );

		return redirect()->route('prospectoHEstatuses.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,ProspectoHEstatuse $prospectoHEstatuse)
	{
		$prospectoHEstatuse=$prospectoHEstatuse->find($id);
		$prospectoHEstatuse->delete();

		return redirect()->route('prospectoHEstatuses.index')->with('message', 'Registro Borrado.');
	}

}
