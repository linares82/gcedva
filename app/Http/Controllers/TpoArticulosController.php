<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\TpoArticulo;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateTpoArticulo;
use App\Http\Requests\createTpoArticulo;

class TpoArticulosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$tpoArticulos = TpoArticulo::getAllData($request);

		return view('tpoArticulos.index', compact('tpoArticulos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('tpoArticulos.create')
			->with( 'list', TpoArticulo::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createTpoArticulo $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		TpoArticulo::create( $input );

		return redirect()->route('tpoArticulos.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, TpoArticulo $tpoArticulo)
	{
		$tpoArticulo=$tpoArticulo->find($id);
		return view('tpoArticulos.show', compact('tpoArticulo'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, TpoArticulo $tpoArticulo)
	{
		$tpoArticulo=$tpoArticulo->find($id);
		return view('tpoArticulos.edit', compact('tpoArticulo'))
			->with( 'list', TpoArticulo::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, TpoArticulo $tpoArticulo)
	{
		$tpoArticulo=$tpoArticulo->find($id);
		return view('tpoArticulos.duplicate', compact('tpoArticulo'))
			->with( 'list', TpoArticulo::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, TpoArticulo $tpoArticulo, updateTpoArticulo $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$tpoArticulo=$tpoArticulo->find($id);
		$tpoArticulo->update( $input );

		return redirect()->route('tpoArticulos.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,TpoArticulo $tpoArticulo)
	{
		$tpoArticulo=$tpoArticulo->find($id);
		$tpoArticulo->delete();

		return redirect()->route('tpoArticulos.index')->with('message', 'Registro Borrado.');
	}

}
