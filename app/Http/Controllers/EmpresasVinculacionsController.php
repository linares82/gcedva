<?php namespace App\Http\Controllers;

use Auth;
use App\Plantel;

use App\Http\Requests;
use App\EmpresasVinculacion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\createEmpresasVinculacion;
use App\Http\Requests\updateEmpresasVinculacion;

class EmpresasVinculacionsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$empresasVinculacions = EmpresasVinculacion::getAllData($request);

		return view('empresasVinculacions.index', compact('empresasVinculacions'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$plantels=Plantel::pluck('razon','id');
		return view('empresasVinculacions.create', compact('plantels'))
			->with( 'list', EmpresasVinculacion::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createEmpresasVinculacion $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		EmpresasVinculacion::create( $input );

		return redirect()->route('empresasVinculacions.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, EmpresasVinculacion $empresasVinculacion)
	{
		$empresasVinculacion=$empresasVinculacion->find($id);
		return view('empresasVinculacions.show', compact('empresasVinculacion'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, EmpresasVinculacion $empresasVinculacion)
	{
		$empresasVinculacion=$empresasVinculacion->find($id);
		$plantels=Plantel::pluck('razon','id');
		return view('empresasVinculacions.edit', compact('empresasVinculacion','plantels'))
			->with( 'list', EmpresasVinculacion::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, EmpresasVinculacion $empresasVinculacion)
	{
		$empresasVinculacion=$empresasVinculacion->find($id);
		return view('empresasVinculacions.duplicate', compact('empresasVinculacion'))
			->with( 'list', EmpresasVinculacion::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, EmpresasVinculacion $empresasVinculacion, updateEmpresasVinculacion $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$empresasVinculacion=$empresasVinculacion->find($id);
		$empresasVinculacion->update( $input );

		return redirect()->route('empresasVinculacions.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,EmpresasVinculacion $empresasVinculacion)
	{
		$empresasVinculacion=$empresasVinculacion->find($id);
		$empresasVinculacion->delete();

		return redirect()->route('empresasVinculacions.index')->with('message', 'Registro Borrado.');
	}

}
