<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\CicloMatricula;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateCicloMatricula;
use App\Http\Requests\createCicloMatricula;

class CicloMatriculasController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$cicloMatriculas = CicloMatricula::getAllData($request);

		return view('cicloMatriculas.index', compact('cicloMatriculas'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('cicloMatriculas.create')
			->with( 'list', CicloMatricula::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createCicloMatricula $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		CicloMatricula::create( $input );

		return redirect()->route('cicloMatriculas.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, CicloMatricula $cicloMatricula)
	{
		$cicloMatricula=$cicloMatricula->find($id);
		return view('cicloMatriculas.show', compact('cicloMatricula'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, CicloMatricula $cicloMatricula)
	{
		$cicloMatricula=$cicloMatricula->find($id);
		return view('cicloMatriculas.edit', compact('cicloMatricula'))
			->with( 'list', CicloMatricula::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, CicloMatricula $cicloMatricula)
	{
		$cicloMatricula=$cicloMatricula->find($id);
		return view('cicloMatriculas.duplicate', compact('cicloMatricula'))
			->with( 'list', CicloMatricula::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, CicloMatricula $cicloMatricula, updateCicloMatricula $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$cicloMatricula=$cicloMatricula->find($id);
		$cicloMatricula->update( $input );

		return redirect()->route('cicloMatriculas.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,CicloMatricula $cicloMatricula)
	{
		$cicloMatricula=$cicloMatricula->find($id);
		$cicloMatricula->delete();

		return redirect()->route('cicloMatriculas.index')->with('message', 'Registro Borrado.');
	}

}
