<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\StMuebleUso;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateStMuebleUso;
use App\Http\Requests\createStMuebleUso;

class StMuebleUsosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$stMuebleUsos = StMuebleUso::getAllData($request);

		return view('stMuebleUsos.index', compact('stMuebleUsos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('stMuebleUsos.create')
			->with( 'list', StMuebleUso::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createStMuebleUso $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		StMuebleUso::create( $input );

		return redirect()->route('stMuebleUsos.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, StMuebleUso $stMuebleUso)
	{
		$stMuebleUso=$stMuebleUso->find($id);
		return view('stMuebleUsos.show', compact('stMuebleUso'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, StMuebleUso $stMuebleUso)
	{
		$stMuebleUso=$stMuebleUso->find($id);
		return view('stMuebleUsos.edit', compact('stMuebleUso'))
			->with( 'list', StMuebleUso::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, StMuebleUso $stMuebleUso)
	{
		$stMuebleUso=$stMuebleUso->find($id);
		return view('stMuebleUsos.duplicate', compact('stMuebleUso'))
			->with( 'list', StMuebleUso::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, StMuebleUso $stMuebleUso, updateStMuebleUso $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$stMuebleUso=$stMuebleUso->find($id);
		$stMuebleUso->update( $input );

		return redirect()->route('stMuebleUsos.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,StMuebleUso $stMuebleUso)
	{
		$stMuebleUso=$stMuebleUso->find($id);
		$stMuebleUso->delete();

		return redirect()->route('stMuebleUsos.index')->with('message', 'Registro Borrado.');
	}

}
