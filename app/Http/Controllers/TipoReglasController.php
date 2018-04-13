<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\TipoRegla;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateTipoRegla;
use App\Http\Requests\createTipoRegla;

class TipoReglasController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$tipoReglas = TipoRegla::getAllData($request);

		return view('tipoReglas.index', compact('tipoReglas'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('tipoReglas.create')
			->with( 'list', TipoRegla::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createTipoRegla $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		TipoRegla::create( $input );

		return redirect()->route('tipoReglas.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, TipoRegla $tipoRegla)
	{
		$tipoRegla=$tipoRegla->find($id);
		return view('tipoReglas.show', compact('tipoRegla'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, TipoRegla $tipoRegla)
	{
		$tipoRegla=$tipoRegla->find($id);
		return view('tipoReglas.edit', compact('tipoRegla'))
			->with( 'list', TipoRegla::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, TipoRegla $tipoRegla)
	{
		$tipoRegla=$tipoRegla->find($id);
		return view('tipoReglas.duplicate', compact('tipoRegla'))
			->with( 'list', TipoRegla::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, TipoRegla $tipoRegla, updateTipoRegla $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$tipoRegla=$tipoRegla->find($id);
		$tipoRegla->update( $input );

		return redirect()->route('tipoReglas.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,TipoRegla $tipoRegla)
	{
		$tipoRegla=$tipoRegla->find($id);
		$tipoRegla->delete();

		return redirect()->route('tipoReglas.index')->with('message', 'Registro Borrado.');
	}

}
