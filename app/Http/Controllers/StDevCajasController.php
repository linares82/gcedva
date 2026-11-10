<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\StDevCaja;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateStDevCaja;
use App\Http\Requests\createStDevCaja;

class StDevCajasController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$stDevCajas = StDevCaja::getAllData($request);

		return view('stDevCajas.index', compact('stDevCajas'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('stDevCajas.create')
			->with( 'list', StDevCaja::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createStDevCaja $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		StDevCaja::create( $input );

		return redirect()->route('stDevCajas.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, StDevCaja $stDevCaja)
	{
		$stDevCaja=$stDevCaja->find($id);
		return view('stDevCajas.show', compact('stDevCaja'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, StDevCaja $stDevCaja)
	{
		$stDevCaja=$stDevCaja->find($id);
		return view('stDevCajas.edit', compact('stDevCaja'))
			->with( 'list', StDevCaja::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, StDevCaja $stDevCaja)
	{
		$stDevCaja=$stDevCaja->find($id);
		return view('stDevCajas.duplicate', compact('stDevCaja'))
			->with( 'list', StDevCaja::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, StDevCaja $stDevCaja, updateStDevCaja $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$stDevCaja=$stDevCaja->find($id);
		$stDevCaja->update( $input );

		return redirect()->route('stDevCajas.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,StDevCaja $stDevCaja)
	{
		$stDevCaja=$stDevCaja->find($id);
		$stDevCaja->delete();

		return redirect()->route('stDevCajas.index')->with('message', 'Registro Borrado.');
	}

}
