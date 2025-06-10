<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\SepCertTipo;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateSepCertTipo;
use App\Http\Requests\createSepCertTipo;

class SepCertTiposController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$sepCertTipos = SepCertTipo::getAllData($request);

		return view('sepCertTipos.index', compact('sepCertTipos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('sepCertTipos.create')
			->with( 'list', SepCertTipo::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createSepCertTipo $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		SepCertTipo::create( $input );

		return redirect()->route('sepCertTipos.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, SepCertTipo $sepCertTipo)
	{
		$sepCertTipo=$sepCertTipo->find($id);
		return view('sepCertTipos.show', compact('sepCertTipo'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, SepCertTipo $sepCertTipo)
	{
		$sepCertTipo=$sepCertTipo->find($id);
		return view('sepCertTipos.edit', compact('sepCertTipo'))
			->with( 'list', SepCertTipo::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, SepCertTipo $sepCertTipo)
	{
		$sepCertTipo=$sepCertTipo->find($id);
		return view('sepCertTipos.duplicate', compact('sepCertTipo'))
			->with( 'list', SepCertTipo::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, SepCertTipo $sepCertTipo, updateSepCertTipo $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$sepCertTipo=$sepCertTipo->find($id);
		$sepCertTipo->update( $input );

		return redirect()->route('sepCertTipos.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,SepCertTipo $sepCertTipo)
	{
		$sepCertTipo=$sepCertTipo->find($id);
		$sepCertTipo->delete();

		return redirect()->route('sepCertTipos.index')->with('message', 'Registro Borrado.');
	}

}
