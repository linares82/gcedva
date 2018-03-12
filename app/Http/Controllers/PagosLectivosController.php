<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\PagosLectivo;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updatePagosLectivo;
use App\Http\Requests\createPagosLectivo;

class PagosLectivosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$pagosLectivos = PagosLectivo::getAllData($request);

		return view('pagosLectivos.index', compact('pagosLectivos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('pagosLectivos.create')
			->with( 'list', PagosLectivo::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createPagosLectivo $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		PagosLectivo::create( $input );

		return redirect()->route('pagosLectivos.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, PagosLectivo $pagosLectivo)
	{
		$pagosLectivo=$pagosLectivo->find($id);
		return view('pagosLectivos.show', compact('pagosLectivo'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, PagosLectivo $pagosLectivo)
	{
		$pagosLectivo=$pagosLectivo->find($id);
		return view('pagosLectivos.edit', compact('pagosLectivo'))
			->with( 'list', PagosLectivo::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, PagosLectivo $pagosLectivo)
	{
		$pagosLectivo=$pagosLectivo->find($id);
		return view('pagosLectivos.duplicate', compact('pagosLectivo'))
			->with( 'list', PagosLectivo::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, PagosLectivo $pagosLectivo, updatePagosLectivo $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$pagosLectivo=$pagosLectivo->find($id);
		$pagosLectivo->update( $input );

		return redirect()->route('pagosLectivos.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,PagosLectivo $pagosLectivo)
	{
		$pagosLectivo=$pagosLectivo->find($id);
		$pagosLectivo->delete();

		return redirect()->route('pagosLectivos.index')->with('message', 'Registro Borrado.');
	}

}
