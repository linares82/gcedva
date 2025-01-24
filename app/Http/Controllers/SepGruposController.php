<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\SepGrupo;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateSepGrupo;
use App\Http\Requests\createSepGrupo;

class SepGruposController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$sepGrupos = SepGrupo::getAllData($request);

		return view('sepGrupos.index', compact('sepGrupos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('sepGrupos.create')
			->with( 'list', SepGrupo::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createSepGrupo $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		SepGrupo::create( $input );

		return redirect()->route('sepGrupos.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, SepGrupo $sepGrupo)
	{
		$sepGrupo=$sepGrupo->find($id);
		return view('sepGrupos.show', compact('sepGrupo'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, SepGrupo $sepGrupo)
	{
		$sepGrupo=$sepGrupo->find($id);
		return view('sepGrupos.edit', compact('sepGrupo'))
			->with( 'list', SepGrupo::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, SepGrupo $sepGrupo)
	{
		$sepGrupo=$sepGrupo->find($id);
		return view('sepGrupos.duplicate', compact('sepGrupo'))
			->with( 'list', SepGrupo::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, SepGrupo $sepGrupo, updateSepGrupo $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$sepGrupo=$sepGrupo->find($id);
		$sepGrupo->update( $input );

		return redirect()->route('sepGrupos.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,SepGrupo $sepGrupo)
	{
		$sepGrupo=$sepGrupo->find($id);
		$sepGrupo->delete();

		return redirect()->route('sepGrupos.index')->with('message', 'Registro Borrado.');
	}

}
