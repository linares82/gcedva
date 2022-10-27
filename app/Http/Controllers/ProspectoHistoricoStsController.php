<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\ProspectoHistoricoSt;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateProspectoHistoricoSt;
use App\Http\Requests\createProspectoHistoricoSt;

class ProspectoHistoricoStsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$prospectoHistoricoSts = ProspectoHistoricoSt::getAllData($request);

		return view('prospectoHistoricoSts.index', compact('prospectoHistoricoSts'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('prospectoHistoricoSts.create')
			->with( 'list', ProspectoHistoricoSt::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createProspectoHistoricoSt $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		ProspectoHistoricoSt::create( $input );

		return redirect()->route('prospectoHistoricoSts.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, ProspectoHistoricoSt $prospectoHistoricoSt)
	{
		$prospectoHistoricoSt=$prospectoHistoricoSt->find($id);
		return view('prospectoHistoricoSts.show', compact('prospectoHistoricoSt'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, ProspectoHistoricoSt $prospectoHistoricoSt)
	{
		$prospectoHistoricoSt=$prospectoHistoricoSt->find($id);
		return view('prospectoHistoricoSts.edit', compact('prospectoHistoricoSt'))
			->with( 'list', ProspectoHistoricoSt::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, ProspectoHistoricoSt $prospectoHistoricoSt)
	{
		$prospectoHistoricoSt=$prospectoHistoricoSt->find($id);
		return view('prospectoHistoricoSts.duplicate', compact('prospectoHistoricoSt'))
			->with( 'list', ProspectoHistoricoSt::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, ProspectoHistoricoSt $prospectoHistoricoSt, updateProspectoHistoricoSt $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$prospectoHistoricoSt=$prospectoHistoricoSt->find($id);
		$prospectoHistoricoSt->update( $input );

		return redirect()->route('prospectoHistoricoSts.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,ProspectoHistoricoSt $prospectoHistoricoSt)
	{
		$prospectoHistoricoSt=$prospectoHistoricoSt->find($id);
		$prospectoHistoricoSt->delete();

		return redirect()->route('prospectoHistoricoSts.index')->with('message', 'Registro Borrado.');
	}

}
