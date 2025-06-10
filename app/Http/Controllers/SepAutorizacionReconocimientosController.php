<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\SepAutorizacionReconocimiento;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateSepAutorizacionReconocimiento;
use App\Http\Requests\createSepAutorizacionReconocimiento;

class SepAutorizacionReconocimientosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$sepAutorizacionReconocimientos = SepAutorizacionReconocimiento::getAllData($request);

		return view('sepAutorizacionReconocimientos.index', compact('sepAutorizacionReconocimientos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('sepAutorizacionReconocimientos.create')
			->with( 'list', SepAutorizacionReconocimiento::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createSepAutorizacionReconocimiento $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		SepAutorizacionReconocimiento::create( $input );

		return redirect()->route('sepAutorizacionReconocimientos.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, SepAutorizacionReconocimiento $sepAutorizacionReconocimiento)
	{
		$sepAutorizacionReconocimiento=$sepAutorizacionReconocimiento->find($id);
		return view('sepAutorizacionReconocimientos.show', compact('sepAutorizacionReconocimiento'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, SepAutorizacionReconocimiento $sepAutorizacionReconocimiento)
	{
		$sepAutorizacionReconocimiento=$sepAutorizacionReconocimiento->find($id);
		return view('sepAutorizacionReconocimientos.edit', compact('sepAutorizacionReconocimiento'))
			->with( 'list', SepAutorizacionReconocimiento::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, SepAutorizacionReconocimiento $sepAutorizacionReconocimiento)
	{
		$sepAutorizacionReconocimiento=$sepAutorizacionReconocimiento->find($id);
		return view('sepAutorizacionReconocimientos.duplicate', compact('sepAutorizacionReconocimiento'))
			->with( 'list', SepAutorizacionReconocimiento::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, SepAutorizacionReconocimiento $sepAutorizacionReconocimiento, updateSepAutorizacionReconocimiento $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$sepAutorizacionReconocimiento=$sepAutorizacionReconocimiento->find($id);
		$sepAutorizacionReconocimiento->update( $input );

		return redirect()->route('sepAutorizacionReconocimientos.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,SepAutorizacionReconocimiento $sepAutorizacionReconocimiento)
	{
		$sepAutorizacionReconocimiento=$sepAutorizacionReconocimiento->find($id);
		$sepAutorizacionReconocimiento->delete();

		return redirect()->route('sepAutorizacionReconocimientos.index')->with('message', 'Registro Borrado.');
	}

}
