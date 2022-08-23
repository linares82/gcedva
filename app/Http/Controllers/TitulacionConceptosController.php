<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\TitulacionConcepto;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateTitulacionConcepto;
use App\Http\Requests\createTitulacionConcepto;

class TitulacionConceptosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$titulacionConceptos = TitulacionConcepto::getAllData($request);

		return view('titulacionConceptos.index', compact('titulacionConceptos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('titulacionConceptos.create')
			->with( 'list', TitulacionConcepto::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createTitulacionConcepto $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		TitulacionConcepto::create( $input );

		return redirect()->route('titulacionConceptos.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, TitulacionConcepto $titulacionConcepto)
	{
		$titulacionConcepto=$titulacionConcepto->find($id);
		return view('titulacionConceptos.show', compact('titulacionConcepto'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, TitulacionConcepto $titulacionConcepto)
	{
		$titulacionConcepto=$titulacionConcepto->find($id);
		return view('titulacionConceptos.edit', compact('titulacionConcepto'))
			->with( 'list', TitulacionConcepto::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, TitulacionConcepto $titulacionConcepto)
	{
		$titulacionConcepto=$titulacionConcepto->find($id);
		return view('titulacionConceptos.duplicate', compact('titulacionConcepto'))
			->with( 'list', TitulacionConcepto::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, TitulacionConcepto $titulacionConcepto, updateTitulacionConcepto $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$titulacionConcepto=$titulacionConcepto->find($id);
		$titulacionConcepto->update( $input );

		return redirect()->route('titulacionConceptos.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,TitulacionConcepto $titulacionConcepto)
	{
		$titulacionConcepto=$titulacionConcepto->find($id);
		$titulacionConcepto->delete();

		return redirect()->route('titulacionConceptos.index')->with('message', 'Registro Borrado.');
	}

}
