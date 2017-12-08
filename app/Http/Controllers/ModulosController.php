<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Modulo;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateModulo;
use App\Http\Requests\createModulo;

class ModulosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$modulos = Modulo::getAllData($request);

		return view('modulos.index', compact('modulos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('modulos.create')
			->with( 'list', Modulo::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createModulo $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		Modulo::create( $input );

		return redirect()->route('modulos.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, Modulo $modulo)
	{
		$modulo=$modulo->find($id);
		return view('modulos.show', compact('modulo'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, Modulo $modulo)
	{
		$modulo=$modulo->find($id);
		return view('modulos.edit', compact('modulo'))
			->with( 'list', Modulo::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, Modulo $modulo)
	{
		$modulo=$modulo->find($id);
		return view('modulos.duplicate', compact('modulo'))
			->with( 'list', Modulo::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, Modulo $modulo, updateModulo $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$modulo=$modulo->find($id);
		$modulo->update( $input );

		return redirect()->route('modulos.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,Modulo $modulo)
	{
		$modulo=$modulo->find($id);
		$modulo->delete();

		return redirect()->route('modulos.index')->with('message', 'Registro Borrado.');
	}

}
