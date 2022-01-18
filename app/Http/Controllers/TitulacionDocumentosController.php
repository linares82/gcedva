<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\TitulacionDocumento;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateTitulacionDocumento;
use App\Http\Requests\createTitulacionDocumento;

class TitulacionDocumentosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$titulacionDocumentos = TitulacionDocumento::getAllData($request);

		return view('titulacionDocumentos.index', compact('titulacionDocumentos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('titulacionDocumentos.create')
			->with( 'list', TitulacionDocumento::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createTitulacionDocumento $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		TitulacionDocumento::create( $input );

		return redirect()->route('titulacionDocumentos.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, TitulacionDocumento $titulacionDocumento)
	{
		$titulacionDocumento=$titulacionDocumento->find($id);
		return view('titulacionDocumentos.show', compact('titulacionDocumento'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, TitulacionDocumento $titulacionDocumento)
	{
		$titulacionDocumento=$titulacionDocumento->find($id);
		return view('titulacionDocumentos.edit', compact('titulacionDocumento'))
			->with( 'list', TitulacionDocumento::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, TitulacionDocumento $titulacionDocumento)
	{
		$titulacionDocumento=$titulacionDocumento->find($id);
		return view('titulacionDocumentos.duplicate', compact('titulacionDocumento'))
			->with( 'list', TitulacionDocumento::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, TitulacionDocumento $titulacionDocumento, updateTitulacionDocumento $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$titulacionDocumento=$titulacionDocumento->find($id);
		$titulacionDocumento->update( $input );

		return redirect()->route('titulacionDocumentos.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,TitulacionDocumento $titulacionDocumento)
	{
		$titulacionDocumento=$titulacionDocumento->find($id);
		$titulacionDocumento->delete();

		return redirect()->route('titulacionDocumentos.index')->with('message', 'Registro Borrado.');
	}

}
