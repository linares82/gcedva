<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\CombinacionEmpresa;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateCombinacionEmpresa;
use App\Http\Requests\createCombinacionEmpresa;

class CombinacionEmpresasController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$combinacionEmpresas = CombinacionEmpresa::getAllData($request);

		return view('combinacionEmpresas.index', compact('combinacionEmpresas'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('combinacionEmpresas.create')
			->with( 'list', CombinacionEmpresa::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createCombinacionEmpresa $request)
	{

		$input = $request->all();
                //dd($input);
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		CombinacionEmpresa::create( $input );
                
		//return redirect()->route('combinacionEmpresas.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, CombinacionEmpresa $combinacionEmpresa)
	{
		$combinacionEmpresa=$combinacionEmpresa->find($id);
		return view('combinacionEmpresas.show', compact('combinacionEmpresa'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, CombinacionEmpresa $combinacionEmpresa)
	{
		$combinacionEmpresa=$combinacionEmpresa->find($id);
		return view('combinacionEmpresas.edit', compact('combinacionEmpresa'))
			->with( 'list', CombinacionEmpresa::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, CombinacionEmpresa $combinacionEmpresa)
	{
		$combinacionEmpresa=$combinacionEmpresa->find($id);
		return view('combinacionEmpresas.duplicate', compact('combinacionEmpresa'))
			->with( 'list', CombinacionEmpresa::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, CombinacionEmpresa $combinacionEmpresa, updateCombinacionEmpresa $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$combinacionEmpresa=$combinacionEmpresa->find($id);
		$combinacionEmpresa->update( $input );

		return redirect()->route('combinacionEmpresas.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,CombinacionEmpresa $combinacionEmpresa)
	{
		$combinacionEmpresa=$combinacionEmpresa->find($id);
                $empresa=$combinacionEmpresa->empresa_id;
		$combinacionEmpresa->delete();

		return redirect()->route('empresas.edit', $empresa)->with('message', 'Registro Borrado.');
	}

}
