<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\HCambiosCaja;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateHCambiosCaja;
use App\Http\Requests\createHCambiosCaja;

class HCambiosCajasController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$hCambiosCajas = HCambiosCaja::getAllData($request);

		return view('hCambiosCajas.index', compact('hCambiosCajas'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('hCambiosCajas.create')
			->with( 'list', HCambiosCaja::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createHCambiosCaja $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		HCambiosCaja::create( $input );

		return redirect()->route('hCambiosCajas.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, HCambiosCaja $hCambiosCaja)
	{
		$hCambiosCaja=$hCambiosCaja->find($id);
		return view('hCambiosCajas.show', compact('hCambiosCaja'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, HCambiosCaja $hCambiosCaja)
	{
		$hCambiosCaja=$hCambiosCaja->find($id);
		return view('hCambiosCajas.edit', compact('hCambiosCaja'))
			->with( 'list', HCambiosCaja::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, HCambiosCaja $hCambiosCaja)
	{
		$hCambiosCaja=$hCambiosCaja->find($id);
		return view('hCambiosCajas.duplicate', compact('hCambiosCaja'))
			->with( 'list', HCambiosCaja::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, HCambiosCaja $hCambiosCaja, updateHCambiosCaja $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$hCambiosCaja=$hCambiosCaja->find($id);
		$hCambiosCaja->update( $input );

		return redirect()->route('hCambiosCajas.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,HCambiosCaja $hCambiosCaja)
	{
		$hCambiosCaja=$hCambiosCaja->find($id);
		$hCambiosCaja->delete();

		return redirect()->route('hCambiosCajas.index')->with('message', 'Registro Borrado.');
	}

}
