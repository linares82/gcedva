<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\CategoriaArticulo;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateCategoriaArticulo;
use App\Http\Requests\createCategoriaArticulo;

class CategoriaArticulosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$categoriaArticulos = CategoriaArticulo::getAllData($request);

		return view('categoriaArticulos.index', compact('categoriaArticulos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('categoriaArticulos.create')
			->with( 'list', CategoriaArticulo::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createCategoriaArticulo $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		CategoriaArticulo::create( $input );

		return redirect()->route('categoriaArticulos.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, CategoriaArticulo $categoriaArticulo)
	{
		$categoriaArticulo=$categoriaArticulo->find($id);
		return view('categoriaArticulos.show', compact('categoriaArticulo'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, CategoriaArticulo $categoriaArticulo)
	{
		$categoriaArticulo=$categoriaArticulo->find($id);
		return view('categoriaArticulos.edit', compact('categoriaArticulo'))
			->with( 'list', CategoriaArticulo::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, CategoriaArticulo $categoriaArticulo)
	{
		$categoriaArticulo=$categoriaArticulo->find($id);
		return view('categoriaArticulos.duplicate', compact('categoriaArticulo'))
			->with( 'list', CategoriaArticulo::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, CategoriaArticulo $categoriaArticulo, updateCategoriaArticulo $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$categoriaArticulo=$categoriaArticulo->find($id);
		$categoriaArticulo->update( $input );

		return redirect()->route('categoriaArticulos.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,CategoriaArticulo $categoriaArticulo)
	{
		$categoriaArticulo=$categoriaArticulo->find($id);
		$categoriaArticulo->delete();

		return redirect()->route('categoriaArticulos.index')->with('message', 'Registro Borrado.');
	}

}
