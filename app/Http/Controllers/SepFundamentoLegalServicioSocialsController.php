<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\SepFundamentoLegalServicioSocial;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateSepFundamentoLegalServicioSocial;
use App\Http\Requests\createSepFundamentoLegalServicioSocial;

class SepFundamentoLegalServicioSocialsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$sepFundamentoLegalServicioSocials = SepFundamentoLegalServicioSocial::getAllData($request);

		return view('sepFundamentoLegalServicioSocials.index', compact('sepFundamentoLegalServicioSocials'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('sepFundamentoLegalServicioSocials.create')
			->with( 'list', SepFundamentoLegalServicioSocial::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createSepFundamentoLegalServicioSocial $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		SepFundamentoLegalServicioSocial::create( $input );

		return redirect()->route('sepFundamentoLegalServicioSocials.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, SepFundamentoLegalServicioSocial $sepFundamentoLegalServicioSocial)
	{
		$sepFundamentoLegalServicioSocial=$sepFundamentoLegalServicioSocial->find($id);
		return view('sepFundamentoLegalServicioSocials.show', compact('sepFundamentoLegalServicioSocial'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, SepFundamentoLegalServicioSocial $sepFundamentoLegalServicioSocial)
	{
		$sepFundamentoLegalServicioSocial=$sepFundamentoLegalServicioSocial->find($id);
		return view('sepFundamentoLegalServicioSocials.edit', compact('sepFundamentoLegalServicioSocial'))
			->with( 'list', SepFundamentoLegalServicioSocial::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, SepFundamentoLegalServicioSocial $sepFundamentoLegalServicioSocial)
	{
		$sepFundamentoLegalServicioSocial=$sepFundamentoLegalServicioSocial->find($id);
		return view('sepFundamentoLegalServicioSocials.duplicate', compact('sepFundamentoLegalServicioSocial'))
			->with( 'list', SepFundamentoLegalServicioSocial::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, SepFundamentoLegalServicioSocial $sepFundamentoLegalServicioSocial, updateSepFundamentoLegalServicioSocial $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$sepFundamentoLegalServicioSocial=$sepFundamentoLegalServicioSocial->find($id);
		$sepFundamentoLegalServicioSocial->update( $input );

		return redirect()->route('sepFundamentoLegalServicioSocials.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,SepFundamentoLegalServicioSocial $sepFundamentoLegalServicioSocial)
	{
		$sepFundamentoLegalServicioSocial=$sepFundamentoLegalServicioSocial->find($id);
		$sepFundamentoLegalServicioSocial->delete();

		return redirect()->route('sepFundamentoLegalServicioSocials.index')->with('message', 'Registro Borrado.');
	}

}
