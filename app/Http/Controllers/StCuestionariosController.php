<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\StCuestionario;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateStCuestionario;
use App\Http\Requests\createStCuestionario;

class StCuestionariosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$stCuestionarios = StCuestionario::getAllData($request);

		return view('stCuestionarios.index', compact('stCuestionarios'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('stCuestionarios.create')
			->with( 'list', StCuestionario::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createStCuestionario $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		StCuestionario::create( $input );

		return redirect()->route('stCuestionarios.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, StCuestionario $stCuestionario)
	{
		$stCuestionario=$stCuestionario->find($id);
		return view('stCuestionarios.show', compact('stCuestionario'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, StCuestionario $stCuestionario)
	{
		$stCuestionario=$stCuestionario->find($id);
		return view('stCuestionarios.edit', compact('stCuestionario'))
			->with( 'list', StCuestionario::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, StCuestionario $stCuestionario)
	{
		$stCuestionario=$stCuestionario->find($id);
		return view('stCuestionarios.duplicate', compact('stCuestionario'))
			->with( 'list', StCuestionario::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, StCuestionario $stCuestionario, updateStCuestionario $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$stCuestionario=$stCuestionario->find($id);
		$stCuestionario->update( $input );

		return redirect()->route('stCuestionarios.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,StCuestionario $stCuestionario)
	{
		$stCuestionario=$stCuestionario->find($id);
		$stCuestionario->delete();

		return redirect()->route('stCuestionarios.index')->with('message', 'Registro Borrado.');
	}

}
