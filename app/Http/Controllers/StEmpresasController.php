<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\StEmpresa;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateStEmpresa;
use App\Http\Requests\createStEmpresa;

class StEmpresasController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$stEmpresas = StEmpresa::getAllData($request);

		return view('stEmpresas.index', compact('stEmpresas'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('stEmpresas.create')
			->with( 'list', StEmpresa::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createStEmpresa $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		StEmpresa::create( $input );

		return redirect()->route('stEmpresas.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, StEmpresa $stEmpresa)
	{
		$stEmpresa=$stEmpresa->find($id);
		return view('stEmpresas.show', compact('stEmpresa'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, StEmpresa $stEmpresa)
	{
		$stEmpresa=$stEmpresa->find($id);
		return view('stEmpresas.edit', compact('stEmpresa'))
			->with( 'list', StEmpresa::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, StEmpresa $stEmpresa)
	{
		$stEmpresa=$stEmpresa->find($id);
		return view('stEmpresas.duplicate', compact('stEmpresa'))
			->with( 'list', StEmpresa::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, StEmpresa $stEmpresa, updateStEmpresa $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$stEmpresa=$stEmpresa->find($id);
		$stEmpresa->update( $input );

		return redirect()->route('stEmpresas.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,StEmpresa $stEmpresa)
	{
		$stEmpresa=$stEmpresa->find($id);
		$stEmpresa->delete();

		return redirect()->route('stEmpresas.index')->with('message', 'Registro Borrado.');
	}

	public function getCmbEstatus()
	{
		$r = StEmpresa::select('name', 'id')->get();
		$final = array();
		foreach ($r as $r1) {
			array_push($final, array(
				'id' => $r1->id,
				'name' => $r1->name,
				'selectec' => ''
			));
		}
		return $final;
	}

}
