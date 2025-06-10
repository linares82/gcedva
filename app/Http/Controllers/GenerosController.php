<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Genero;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateGenero;
use App\Http\Requests\createGenero;

class GenerosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$generos = Genero::getAllData($request);

		return view('generos.index', compact('generos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('generos.create')
			->with( 'list', Genero::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createGenero $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		Genero::create( $input );

		return redirect()->route('generos.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, Genero $genero)
	{
		$genero=$genero->find($id);
		return view('generos.show', compact('genero'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, Genero $genero)
	{
		$genero=$genero->find($id);
		return view('generos.edit', compact('genero'))
			->with( 'list', Genero::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, Genero $genero)
	{
		$genero=$genero->find($id);
		return view('generos.duplicate', compact('genero'))
			->with( 'list', Genero::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, Genero $genero, updateGenero $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$genero=$genero->find($id);
		$genero->update( $input );

		return redirect()->route('generos.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,Genero $genero)
	{
		$genero=$genero->find($id);
		$genero->delete();

		return redirect()->route('generos.index')->with('message', 'Registro Borrado.');
	}

}
