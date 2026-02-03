<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\TipoEscuelaProcedencium;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateTipoEscuelaProcedencium;
use App\Http\Requests\createTipoEscuelaProcedencium;

class TipoEscuelaProcedenciasController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$tipoEscuelaProcedencias = TipoEscuelaProcedencium::getAllData($request);

		return view('tipoEscuelaProcedencias.index', compact('tipoEscuelaProcedencias'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('tipoEscuelaProcedencias.create')
			->with( 'list', TipoEscuelaProcedencium::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createTipoEscuelaProcedencium $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		TipoEscuelaProcedencium::create( $input );

		return redirect()->route('tipoEscuelaProcedencias.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, TipoEscuelaProcedencium $tipoEscuelaProcedencium)
	{
		$tipoEscuelaProcedencium=$tipoEscuelaProcedencium->find($id);
		return view('tipoEscuelaProcedencias.show', compact('tipoEscuelaProcedencium'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, TipoEscuelaProcedencium $tipoEscuelaProcedencium)
	{
		$tipoEscuelaProcedencium=$tipoEscuelaProcedencium->find($id);
		return view('tipoEscuelaProcedencias.edit', compact('tipoEscuelaProcedencium'))
			->with( 'list', TipoEscuelaProcedencium::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, TipoEscuelaProcedencium $tipoEscuelaProcedencium)
	{
		$tipoEscuelaProcedencium=$tipoEscuelaProcedencium->find($id);
		return view('tipoEscuelaProcedencias.duplicate', compact('tipoEscuelaProcedencium'))
			->with( 'list', TipoEscuelaProcedencium::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, TipoEscuelaProcedencium $tipoEscuelaProcedencium, updateTipoEscuelaProcedencium $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$tipoEscuelaProcedencium=$tipoEscuelaProcedencium->find($id);
		$tipoEscuelaProcedencium->update( $input );

		return redirect()->route('tipoEscuelaProcedencias.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,TipoEscuelaProcedencium $tipoEscuelaProcedencium)
	{
		$tipoEscuelaProcedencium=$tipoEscuelaProcedencium->find($id);
		$tipoEscuelaProcedencium->delete();

		return redirect()->route('tipoEscuelaProcedencias.index')->with('message', 'Registro Borrado.');
	}

}
