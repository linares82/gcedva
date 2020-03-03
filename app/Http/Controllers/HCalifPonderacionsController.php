<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\HCalifPonderacion;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateHCalifPonderacion;
use App\Http\Requests\createHCalifPonderacion;

class HCalifPonderacionsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$hCalifPonderacions = HCalifPonderacion::getAllData($request);

		return view('hCalifPonderacions.index', compact('hCalifPonderacions'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('hCalifPonderacions.create')
			->with( 'list', HCalifPonderacion::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createHCalifPonderacion $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		HCalifPonderacion::create( $input );

		return redirect()->route('hCalifPonderacions.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, HCalifPonderacion $hCalifPonderacion)
	{
		$hCalifPonderacion=$hCalifPonderacion->find($id);
		return view('hCalifPonderacions.show', compact('hCalifPonderacion'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, HCalifPonderacion $hCalifPonderacion)
	{
		$hCalifPonderacion=$hCalifPonderacion->find($id);
		return view('hCalifPonderacions.edit', compact('hCalifPonderacion'))
			->with( 'list', HCalifPonderacion::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, HCalifPonderacion $hCalifPonderacion)
	{
		$hCalifPonderacion=$hCalifPonderacion->find($id);
		return view('hCalifPonderacions.duplicate', compact('hCalifPonderacion'))
			->with( 'list', HCalifPonderacion::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, HCalifPonderacion $hCalifPonderacion, updateHCalifPonderacion $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$hCalifPonderacion=$hCalifPonderacion->find($id);
		$hCalifPonderacion->update( $input );

		return redirect()->route('hCalifPonderacions.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,HCalifPonderacion $hCalifPonderacion)
	{
		$hCalifPonderacion=$hCalifPonderacion->find($id);
		$hCalifPonderacion->delete();

		return redirect()->route('hCalifPonderacions.index')->with('message', 'Registro Borrado.');
	}

}
