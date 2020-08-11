<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Discapacidad;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateDiscapacidad;
use App\Http\Requests\createDiscapacidad;

class DiscapacidadsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$discapacidads = Discapacidad::getAllData($request);

		return view('discapacidads.index', compact('discapacidads'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('discapacidads.create')
			->with( 'list', Discapacidad::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createDiscapacidad $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		Discapacidad::create( $input );

		return redirect()->route('discapacidads.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, Discapacidad $discapacidad)
	{
		$discapacidad=$discapacidad->find($id);
		return view('discapacidads.show', compact('discapacidad'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, Discapacidad $discapacidad)
	{
		$discapacidad=$discapacidad->find($id);
		return view('discapacidads.edit', compact('discapacidad'))
			->with( 'list', Discapacidad::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, Discapacidad $discapacidad)
	{
		$discapacidad=$discapacidad->find($id);
		return view('discapacidads.duplicate', compact('discapacidad'))
			->with( 'list', Discapacidad::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, Discapacidad $discapacidad, updateDiscapacidad $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$discapacidad=$discapacidad->find($id);
		$discapacidad->update( $input );

		return redirect()->route('discapacidads.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,Discapacidad $discapacidad)
	{
		$discapacidad=$discapacidad->find($id);
		$discapacidad->delete();

		return redirect()->route('discapacidads.index')->with('message', 'Registro Borrado.');
	}

}
