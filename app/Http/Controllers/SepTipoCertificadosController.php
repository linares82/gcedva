<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\SepTipoCertificado;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateSepTipoCertificado;
use App\Http\Requests\createSepTipoCertificado;

class SepTipoCertificadosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$sepTipoCertificados = SepTipoCertificado::getAllData($request);

		return view('sepTipoCertificados.index', compact('sepTipoCertificados'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('sepTipoCertificados.create')
			->with( 'list', SepTipoCertificado::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createSepTipoCertificado $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		SepTipoCertificado::create( $input );

		return redirect()->route('sepTipoCertificados.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, SepTipoCertificado $sepTipoCertificado)
	{
		$sepTipoCertificado=$sepTipoCertificado->find($id);
		return view('sepTipoCertificados.show', compact('sepTipoCertificado'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, SepTipoCertificado $sepTipoCertificado)
	{
		$sepTipoCertificado=$sepTipoCertificado->find($id);
		return view('sepTipoCertificados.edit', compact('sepTipoCertificado'))
			->with( 'list', SepTipoCertificado::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, SepTipoCertificado $sepTipoCertificado)
	{
		$sepTipoCertificado=$sepTipoCertificado->find($id);
		return view('sepTipoCertificados.duplicate', compact('sepTipoCertificado'))
			->with( 'list', SepTipoCertificado::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, SepTipoCertificado $sepTipoCertificado, updateSepTipoCertificado $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$sepTipoCertificado=$sepTipoCertificado->find($id);
		$sepTipoCertificado->update( $input );

		return redirect()->route('sepTipoCertificados.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,SepTipoCertificado $sepTipoCertificado)
	{
		$sepTipoCertificado=$sepTipoCertificado->find($id);
		$sepTipoCertificado->delete();

		return redirect()->route('sepTipoCertificados.index')->with('message', 'Registro Borrado.');
	}

}
