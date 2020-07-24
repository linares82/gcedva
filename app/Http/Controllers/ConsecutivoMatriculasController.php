<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\ConsecutivoMatricula;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateConsecutivoMatricula;
use App\Http\Requests\createConsecutivoMatricula;

class ConsecutivoMatriculasController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$consecutivoMatriculas = ConsecutivoMatricula::getAllData($request);

		return view('consecutivoMatriculas.index', compact('consecutivoMatriculas'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('consecutivoMatriculas.create')
			->with( 'list', ConsecutivoMatricula::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createConsecutivoMatricula $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		ConsecutivoMatricula::create( $input );

		return redirect()->route('consecutivoMatriculas.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, ConsecutivoMatricula $consecutivoMatricula)
	{
		$consecutivoMatricula=$consecutivoMatricula->find($id);
		return view('consecutivoMatriculas.show', compact('consecutivoMatricula'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, ConsecutivoMatricula $consecutivoMatricula)
	{
		$consecutivoMatricula=$consecutivoMatricula->find($id);
		return view('consecutivoMatriculas.edit', compact('consecutivoMatricula'))
			->with( 'list', ConsecutivoMatricula::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, ConsecutivoMatricula $consecutivoMatricula)
	{
		$consecutivoMatricula=$consecutivoMatricula->find($id);
		return view('consecutivoMatriculas.duplicate', compact('consecutivoMatricula'))
			->with( 'list', ConsecutivoMatricula::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, ConsecutivoMatricula $consecutivoMatricula, updateConsecutivoMatricula $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$consecutivoMatricula=$consecutivoMatricula->find($id);
		$consecutivoMatricula->update( $input );

		return redirect()->route('consecutivoMatriculas.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,ConsecutivoMatricula $consecutivoMatricula)
	{
		$consecutivoMatricula=$consecutivoMatricula->find($id);
		$consecutivoMatricula->delete();

		return redirect()->route('consecutivoMatriculas.index')->with('message', 'Registro Borrado.');
	}

}
