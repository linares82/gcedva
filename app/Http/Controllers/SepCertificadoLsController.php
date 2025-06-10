<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\SepCertificadoL;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateSepCertificadoL;
use App\Http\Requests\createSepCertificadoL;

class SepCertificadoLsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$sepCertificadoLs = SepCertificadoL::getAllData($request);

		return view('sepCertificadoLs.index', compact('sepCertificadoLs'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('sepCertificadoLs.create')
			->with( 'list', SepCertificadoL::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createSepCertificadoL $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		SepCertificadoL::create( $input );

		return redirect()->route('sepCertificadoLs.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, SepCertificadoL $sepCertificadoL)
	{
		$sepCertificadoL=$sepCertificadoL->find($id);
		return view('sepCertificadoLs.show', compact('sepCertificadoL'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, SepCertificadoL $sepCertificadoL)
	{
		$sepCertificadoL=$sepCertificadoL->find($id);
		return view('sepCertificadoLs.edit', compact('sepCertificadoL'))
			->with( 'list', SepCertificadoL::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, SepCertificadoL $sepCertificadoL)
	{
		$sepCertificadoL=$sepCertificadoL->find($id);
		return view('sepCertificadoLs.duplicate', compact('sepCertificadoL'))
			->with( 'list', SepCertificadoL::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, SepCertificadoL $sepCertificadoL, updateSepCertificadoL $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$sepCertificadoL=$sepCertificadoL->find($id);
		$sepCertificadoL->update( $input );

		return redirect()->route('sepCertificadoLs.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,SepCertificadoL $sepCertificadoL)
	{
		$sepCertificadoL=$sepCertificadoL->find($id);
		$sepCertificadoL->delete();

		return redirect()->route('sepCertificadoLs.index')->with('message', 'Registro Borrado.');
	}

}
