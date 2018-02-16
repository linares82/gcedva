<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Ccuestionario;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateCcuestionario;
use App\Http\Requests\createCcuestionario;

class CcuestionariosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$ccuestionarios = Ccuestionario::getAllData($request);

		return view('ccuestionarios.index', compact('ccuestionarios'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('ccuestionarios.create')
			->with( 'list', Ccuestionario::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createCcuestionario $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		Ccuestionario::create( $input );

		return redirect()->route('ccuestionarios.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, Ccuestionario $ccuestionario)
	{
		$ccuestionario=$ccuestionario->find($id);
		return view('ccuestionarios.show', compact('ccuestionario'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, Ccuestionario $ccuestionario)
	{
		$ccuestionario=$ccuestionario->find($id);
		return view('ccuestionarios.edit', compact('ccuestionario'))
			->with( 'list', Ccuestionario::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, Ccuestionario $ccuestionario)
	{
		$ccuestionario=$ccuestionario->find($id);
		return view('ccuestionarios.duplicate', compact('ccuestionario'))
			->with( 'list', Ccuestionario::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, Ccuestionario $ccuestionario, updateCcuestionario $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$ccuestionario=$ccuestionario->find($id);
		$ccuestionario->update( $input );

		return redirect()->route('ccuestionarios.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,Ccuestionario $ccuestionario)
	{
		$ccuestionario=$ccuestionario->find($id);
		$ccuestionario->delete();

		return redirect()->route('ccuestionarios.index')->with('message', 'Registro Borrado.');
	}

}
