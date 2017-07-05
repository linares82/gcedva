<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Grado;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateGrado;
use App\Http\Requests\createGrado;

class GradosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$grados = Grado::getAllData($request);

		return view('grados.index', compact('grados'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('grados.create')
			->with( 'list', Grado::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createGrado $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		Grado::create( $input );

		return redirect()->route('grados.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, Grado $grado)
	{
		$grado=$grado->find($id);
		return view('grados.show', compact('grado'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, Grado $grado)
	{
		$grado=$grado->find($id);
		return view('grados.edit', compact('grado'))
			->with( 'list', Grado::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, Grado $grado)
	{
		$grado=$grado->find($id);
		return view('grados.duplicate', compact('grado'))
			->with( 'list', Grado::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, Grado $grado, updateGrado $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$grado=$grado->find($id);
		$grado->update( $input );

		return redirect()->route('grados.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,Grado $grado)
	{
		$grado=$grado->find($id);
		$grado->delete();

		return redirect()->route('grados.index')->with('message', 'Registro Borrado.');
	}

}
