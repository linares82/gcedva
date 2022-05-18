<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Sueldo;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateSueldo;
use App\Http\Requests\createSueldo;

class SueldosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$sueldos = Sueldo::getAllData($request);

		return view('sueldos.index', compact('sueldos'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('sueldos.create')
			->with( 'list', Sueldo::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createSueldo $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		Sueldo::create( $input );

		return redirect()->route('sueldos.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, Sueldo $sueldo)
	{
		$sueldo=$sueldo->find($id);
		return view('sueldos.show', compact('sueldo'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, Sueldo $sueldo)
	{
		$sueldo=$sueldo->find($id);
		return view('sueldos.edit', compact('sueldo'))
			->with( 'list', Sueldo::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, Sueldo $sueldo)
	{
		$sueldo=$sueldo->find($id);
		return view('sueldos.duplicate', compact('sueldo'))
			->with( 'list', Sueldo::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, Sueldo $sueldo, updateSueldo $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$sueldo=$sueldo->find($id);
		$sueldo->update( $input );

		return redirect()->route('sueldos.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,Sueldo $sueldo)
	{
		$sueldo=$sueldo->find($id);
		$sueldo->delete();

		return redirect()->route('sueldos.index')->with('message', 'Registro Borrado.');
	}

}
