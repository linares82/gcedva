<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\UnidadUso;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateUnidadUso;
use App\Http\Requests\createUnidadUso;

class UnidadUsosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$unidadUsos = UnidadUso::getAllData($request);

		return view('unidadUsos.index', compact('unidadUsos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('unidadUsos.create')
			->with( 'list', UnidadUso::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createUnidadUso $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		UnidadUso::create( $input );

		return redirect()->route('unidadUsos.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, UnidadUso $unidadUso)
	{
		$unidadUso=$unidadUso->find($id);
		return view('unidadUsos.show', compact('unidadUso'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, UnidadUso $unidadUso)
	{
		$unidadUso=$unidadUso->find($id);
		return view('unidadUsos.edit', compact('unidadUso'))
			->with( 'list', UnidadUso::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, UnidadUso $unidadUso)
	{
		$unidadUso=$unidadUso->find($id);
		return view('unidadUsos.duplicate', compact('unidadUso'))
			->with( 'list', UnidadUso::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, UnidadUso $unidadUso, updateUnidadUso $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$unidadUso=$unidadUso->find($id);
		$unidadUso->update( $input );

		return redirect()->route('unidadUsos.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,UnidadUso $unidadUso)
	{
		$unidadUso=$unidadUso->find($id);
		$unidadUso->delete();

		return redirect()->route('unidadUsos.index')->with('message', 'Registro Borrado.');
	}

}
