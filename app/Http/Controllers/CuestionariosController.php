<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Cuestionario;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateCuestionario;
use App\Http\Requests\createCuestionario;

class CuestionariosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$cuestionarios = Cuestionario::getAllData($request);

		return view('cuestionarios.index', compact('cuestionarios'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('cuestionarios.create')
			->with( 'list', Cuestionario::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createCuestionario $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		Cuestionario::create( $input );

		return redirect()->route('cuestionarios.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, Cuestionario $cuestionario)
	{
		$cuestionario=$cuestionario->find($id);
		return view('cuestionarios.show', compact('cuestionario'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, Cuestionario $cuestionario)
	{
		$cuestionario=$cuestionario->find($id);
		return view('cuestionarios.edit', compact('cuestionario'))
			->with( 'list', Cuestionario::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, Cuestionario $cuestionario)
	{
		$cuestionario=$cuestionario->find($id);
		return view('cuestionarios.duplicate', compact('cuestionario'))
			->with( 'list', Cuestionario::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, Cuestionario $cuestionario, updateCuestionario $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$cuestionario=$cuestionario->find($id);
		$cuestionario->update( $input );

		return redirect()->route('cuestionarios.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,Cuestionario $cuestionario)
	{
		$cuestionario=$cuestionario->find($id);
		$cuestionario->delete();

		return redirect()->route('cuestionarios.index')->with('message', 'Registro Borrado.');
	}

}
