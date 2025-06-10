<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\SepTEstudioAntecedente;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateSepTEstudioAntecedente;
use App\Http\Requests\createSepTEstudioAntecedente;

class SepTEstudioAntecedentesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$sepTEstudioAntecedentes = SepTEstudioAntecedente::getAllData($request);

		return view('sepTEstudioAntecedentes.index', compact('sepTEstudioAntecedentes'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('sepTEstudioAntecedentes.create')
			->with( 'list', SepTEstudioAntecedente::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createSepTEstudioAntecedente $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		SepTEstudioAntecedente::create( $input );

		return redirect()->route('sepTEstudioAntecedentes.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, SepTEstudioAntecedente $sepTEstudioAntecedente)
	{
		$sepTEstudioAntecedente=$sepTEstudioAntecedente->find($id);
		return view('sepTEstudioAntecedentes.show', compact('sepTEstudioAntecedente'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, SepTEstudioAntecedente $sepTEstudioAntecedente)
	{
		$sepTEstudioAntecedente=$sepTEstudioAntecedente->find($id);
		return view('sepTEstudioAntecedentes.edit', compact('sepTEstudioAntecedente'))
			->with( 'list', SepTEstudioAntecedente::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, SepTEstudioAntecedente $sepTEstudioAntecedente)
	{
		$sepTEstudioAntecedente=$sepTEstudioAntecedente->find($id);
		return view('sepTEstudioAntecedentes.duplicate', compact('sepTEstudioAntecedente'))
			->with( 'list', SepTEstudioAntecedente::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, SepTEstudioAntecedente $sepTEstudioAntecedente, updateSepTEstudioAntecedente $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$sepTEstudioAntecedente=$sepTEstudioAntecedente->find($id);
		$sepTEstudioAntecedente->update( $input );

		return redirect()->route('sepTEstudioAntecedentes.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,SepTEstudioAntecedente $sepTEstudioAntecedente)
	{
		$sepTEstudioAntecedente=$sepTEstudioAntecedente->find($id);
		$sepTEstudioAntecedente->delete();

		return redirect()->route('sepTEstudioAntecedentes.index')->with('message', 'Registro Borrado.');
	}

}
