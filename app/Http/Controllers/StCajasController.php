<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\StCaja;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateStCaja;
use App\Http\Requests\createStCaja;

class StCajasController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$stCajas = StCaja::getAllData($request);

		return view('stCajas.index', compact('stCajas'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('stCajas.create')
			->with( 'list', StCaja::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createStCaja $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		StCaja::create( $input );

		return redirect()->route('stCajas.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, StCaja $stCaja)
	{
		$stCaja=$stCaja->find($id);
		return view('stCajas.show', compact('stCaja'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, StCaja $stCaja)
	{
		$stCaja=$stCaja->find($id);
		return view('stCajas.edit', compact('stCaja'))
			->with( 'list', StCaja::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, StCaja $stCaja)
	{
		$stCaja=$stCaja->find($id);
		return view('stCajas.duplicate', compact('stCaja'))
			->with( 'list', StCaja::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, StCaja $stCaja, updateStCaja $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$stCaja=$stCaja->find($id);
		$stCaja->update( $input );

		return redirect()->route('stCajas.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,StCaja $stCaja)
	{
		$stCaja=$stCaja->find($id);
		$stCaja->delete();

		return redirect()->route('stCajas.index')->with('message', 'Registro Borrado.');
	}

}
