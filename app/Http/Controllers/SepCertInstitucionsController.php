<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\SepCertInstitucion;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateSepCertInstitucion;
use App\Http\Requests\createSepCertInstitucion;

class SepCertInstitucionsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$sepCertInstitucions = SepCertInstitucion::getAllData($request);

		return view('sepCertInstitucions.index', compact('sepCertInstitucions'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('sepCertInstitucions.create')
			->with( 'list', SepCertInstitucion::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createSepCertInstitucion $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		SepCertInstitucion::create( $input );

		return redirect()->route('sepCertInstitucions.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, SepCertInstitucion $sepCertInstitucion)
	{
		$sepCertInstitucion=$sepCertInstitucion->find($id);
		return view('sepCertInstitucions.show', compact('sepCertInstitucion'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, SepCertInstitucion $sepCertInstitucion)
	{
		$sepCertInstitucion=$sepCertInstitucion->find($id);
		return view('sepCertInstitucions.edit', compact('sepCertInstitucion'))
			->with( 'list', SepCertInstitucion::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, SepCertInstitucion $sepCertInstitucion)
	{
		$sepCertInstitucion=$sepCertInstitucion->find($id);
		return view('sepCertInstitucions.duplicate', compact('sepCertInstitucion'))
			->with( 'list', SepCertInstitucion::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, SepCertInstitucion $sepCertInstitucion, updateSepCertInstitucion $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$sepCertInstitucion=$sepCertInstitucion->find($id);
		$sepCertInstitucion->update( $input );

		return redirect()->route('sepCertInstitucions.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,SepCertInstitucion $sepCertInstitucion)
	{
		$sepCertInstitucion=$sepCertInstitucion->find($id);
		$sepCertInstitucion->delete();

		return redirect()->route('sepCertInstitucions.index')->with('message', 'Registro Borrado.');
	}

}
