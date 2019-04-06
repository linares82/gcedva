<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\StCursoEmpresa;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateStCursoEmpresa;
use App\Http\Requests\createStCursoEmpresa;

class StCursoEmpresasController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$stCursoEmpresas = StCursoEmpresa::getAllData($request);

		return view('stCursoEmpresas.index', compact('stCursoEmpresas'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('stCursoEmpresas.create')
			->with( 'list', StCursoEmpresa::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createStCursoEmpresa $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		StCursoEmpresa::create( $input );

		return redirect()->route('stCursoEmpresas.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, StCursoEmpresa $stCursoEmpresa)
	{
		$stCursoEmpresa=$stCursoEmpresa->find($id);
		return view('stCursoEmpresas.show', compact('stCursoEmpresa'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, StCursoEmpresa $stCursoEmpresa)
	{
		$stCursoEmpresa=$stCursoEmpresa->find($id);
		return view('stCursoEmpresas.edit', compact('stCursoEmpresa'))
			->with( 'list', StCursoEmpresa::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, StCursoEmpresa $stCursoEmpresa)
	{
		$stCursoEmpresa=$stCursoEmpresa->find($id);
		return view('stCursoEmpresas.duplicate', compact('stCursoEmpresa'))
			->with( 'list', StCursoEmpresa::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, StCursoEmpresa $stCursoEmpresa, updateStCursoEmpresa $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$stCursoEmpresa=$stCursoEmpresa->find($id);
		$stCursoEmpresa->update( $input );

		return redirect()->route('stCursoEmpresas.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,StCursoEmpresa $stCursoEmpresa)
	{
		$stCursoEmpresa=$stCursoEmpresa->find($id);
		$stCursoEmpresa->delete();

		return redirect()->route('stCursoEmpresas.index')->with('message', 'Registro Borrado.');
	}

}
